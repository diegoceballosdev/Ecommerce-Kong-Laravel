<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Exception;
use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\PendingPayment; // Importar el modelo de pre-orden

class MercadoPagoController extends Controller
{
    /**
     * Maneja las notificaciones asíncronas (webhooks) de Mercado Pago.
     */
    public function handleWebhook(Request $request)
    {
        // 1. Filtrar y Validar Tipo de Evento (usando el objeto Request de Laravel)
        $data = $request->all();
        $topic = $data['type'] ?? null;
        $payment_id = $data['data']['id'] ?? null;

        if ($topic !== 'payment' || !$payment_id) {
            Log::info("Webhook recibido y omitido: Tipo no es 'payment' o falta ID.");
            return response()->json(['status' => 'ok'], 200);
        }

        // 2. Configurar token y consultar la API de MP (Seguridad y Obtención de Datos)
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $paymentClient = new PaymentClient();
        $externalReference = null;
        $pendingPayment = null;

        try {
            $payment = $paymentClient->get($payment_id);
            $externalReference = $payment->external_reference;
        } catch (Exception $e) {
            Log::error("Error al consultar Payment ID {$payment_id}: " . $e->getMessage());
            // Retorna 500 para que MP intente de nuevo
            return response()->json(['status' => 'error'], 500);
        }

        // 3. Validación de Estado de Pago y Referencia Externa
        if ($payment->status !== 'approved' || !$externalReference) {
            Log::info("Pago {$payment_id} no aprobado ({$payment->status}) o sin external_reference. Omitido.");
            return response()->json(['status' => 'ok'], 200);
        }

        // 4. INICIO DE LA TRANSACCIÓN ATÓMICA
        try {
            DB::transaction(function () use ($externalReference, $payment, $payment_id, &$pendingPayment) {

                // 4.1 Idempotencia y Contexto: Buscar y bloquear la pre-orden.
                // Usamos lockForUpdate para evitar que dos webhooks procesen la misma fila al mismo tiempo.
                $pendingPayment = PendingPayment::where('external_reference', $externalReference)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Si ya fue procesado, salimos (Idempotencia)
                if ($pendingPayment->status === 'processed') {
                    Log::warning("PendingPayment {$externalReference} ya procesado. Idempotencia aplicada.");
                    return;
                }

                // 4.2 Creación de la Orden Final
                // Usamos los datos persistidos en PendingPayment
                Order::create([
                    'user_id' => $pendingPayment->user_id,
                    'products' => $pendingPayment->products,
                    'address' => $pendingPayment->address,
                    'payment_id' => $payment->id,
                    'total' => $pendingPayment->total,
                ]);

                // 4.3 Restaurar Carrito (para la lógica de stock)
                Cart::instance('shopping')->restore($externalReference);
                $content = Cart::content();

                // 4.4 Reducción de Stock (Atomicidad)
                // Se asume que $pendingPayment->products (o $content) ya filtró el stock,
                // pero la reducción debe ser segura.
                foreach ($content as $item) {
                    Variant::where('sku', $item->options['code'])
                        ->decrement('stock', $item->qty);
                }

                // 4.5 Limpieza de Contexto: ¡SOLUCIÓN DE ELIMINACIÓN MANUAL!
                // Eliminamos directamente el registro de la DB usando el Query Builder de Laravel.
                DB::table('shoppingcart')
                    ->where('identifier', $externalReference) // Clave única del carrito
                    ->where('instance', 'shopping')         // Nombre de la instancia
                    ->delete();

                // 4.6 Actualizar el estado de la pre-orden a procesado (Fin de la Idempotencia)
                $pendingPayment->update([
                    'payment_id' => $payment_id,
                    'status' => 'processed',
                ]);

            }); // FIN DB::transaction: COMMIT si todo es exitoso.

        } catch (Exception $e) {
            // Manejo de fallos de la transacción (Ej: stock negativo, error DB)
            Log::error("Error Crítico en el Webhook {$payment_id} (ROLLBACK DB): " . $e->getMessage());

            // Si la transacción falla, actualizamos el estado para revisión manual
            // y prevenimos que se intente procesar de nuevo automáticamente.
            if ($pendingPayment && $pendingPayment->status === 'pending') {
                $pendingPayment->update(['status' => 'manual_review']);
            }
            // Retornar 500 para forzar a MP a reintentar (si el fallo es temporal).
            return response()->json(['status' => 'internal_error'], 500);
        }

        // 5. Respuesta final a Mercado Pago.
        return response()->json(['status' => 'ok', 'message' => 'Order processed successfully.'], 200);
    }
}