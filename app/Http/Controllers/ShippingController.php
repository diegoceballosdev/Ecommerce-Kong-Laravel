<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PendingPayment;
use Illuminate\Support\Str; // Asegúrese de importar Str
use Gloudemans\Shoppingcart\Facades\Cart;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\MerchantOrder\Item;

class ShippingController extends Controller
{

    public function index()
    {
        // Mostrar solo productos con stock suficiente:
        Cart::instance('shopping');

        $content = Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        });

        $subtotal = $content->sum(function ($item) {
            return $item->subtotal;
        });
        $shipping = number_format(num: 0, decimals: 2); // PENdiente de implementar con correo argentino o andreani
        $total = $subtotal + $shipping;

        $address = Address::where('user_id', auth()->id())
            ->where('default', true)
            ->first();

        //Mercado Pago:
        $preferenceId = $this->generatePreferenceIdMercadoPago();

        return view('shipping.index', compact('content', 'subtotal', 'shipping', 'total', 'address', 'preferenceId'));
    }

    public function generatePreferenceIdMercadoPago()
    {
        // --- Lógica de Persistencia CRÍTICA (Paso A) ---

        // 1. Generar UUID que servirá de clave maestra
        $externalReference = (string) Str::uuid();

        // 2. Restaurar el carrito del usuario (si usa identificación persistente de carrito): Usamos auth()->id() para asegurar que trabajamos con el carrito actual del usuario logueado.
        Cart::instance('shopping')->restore(auth()->id());

        // 3. Productos
        $content = Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        });

        // 4. Totales
        $subtotal = $content->sum(function ($item) {
            return $item->subtotal;
        });
        $shipping = number_format(num: 250, decimals: 2);
        $total = $subtotal + $shipping;

        // 5. Obtener dirección por defecto "
        $address = Address::where('user_id', auth()->id())
            ->where('default', true)
            ->first();

        // 6. Guardar (Persistir) el carrito en la DB usando el UUID como clave.
        // Esto desvincula el carrito de la sesión.
        Cart::instance('shopping')->store($externalReference);

        if ($address !== null) {
            // 7. Crear el registro de Pago Pendiente (PendingPayment)
            PendingPayment::create([
                'user_id' => auth()->id(),
                'external_reference' => $externalReference,
                'products' => $content,
                'address' => $address,
                'total' => $total,
            ]);
        }

        // --------------------------------------------------

        // --- Lógica de Mercado Pago (Paso B) ---
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        $items = [];
        foreach ($content as $cartItem) {
            $item = new Item();
            $item->id = (string) $cartItem->id;
            $item->title = (string) $cartItem->name;
            $item->quantity = (int) $cartItem->qty;
            $item->unit_price = (float) $cartItem->price;

            $items[] = $item;
        }

        $client = new PreferenceClient();

        $preference = $client->create([
            'items' => $items, // Productos

            'external_reference' => $externalReference, // Clave maestra UUID
            'statement_descriptor' => 'Kong Tienda Online', // Nombre que aparece en el resumen de la tarjeta

            'shipments' => [
                'cost' => 0, // En este ejemplo, el costo de envío es GRATIS
                'mode' => 'not_specified', // Otras opciones: 'me2', 'custom'
            ],

            'back_urls' => [
                'success' => route('welcome.index'),
                'failure' => route('cart.index'),
                // 'pending' => route('cart.index'), // Opcional: URL para pagos pendientes
            ],
            'auto_return' => 'approved',
            'notification_url' => url('api/mercadopago/webhook'),

            'payment_methods' => [
                // 'excluded_payment_methods' => [
                //     ['id' => 'amex'], // Excluir American Express
                //     ['id' => 'visa'], // Excluir Visa
                //     ['id' => 'master'], // Excluir MasterCard
                //     ['id' => 'debvisa'], //Excluir Visa Débito
                //     ['id' => 'debmast'], // Excluir MasterCard Débito
                //     ['id' => 'naranja'], // Excluir Naranja
                //     ['id' => 'diners'], // Excluir Diners Club
                //     ['id' => 'hipercard'], // Excluir Hipercard
                //     ['id' => 'mercadopago'], // Excluir saldo de MercadoPago
                // ],
                // 'excluded_payment_types' => [
                //     ['id' => 'ticket'], // Excluir pagos en efectivo
                //     ['id' => 'atm'], // Excluir pagos por cajero automático
                //     ['id' => 'debit_card'], // Excluir tarjetas de débito
                //     ['id' => 'credit_card'], // Excluir tarjetas de crédito
                //     ['id' => 'prepaid_card'], // Excluir tarjetas prepago
                //     ['id' => 'bank_transfer'], // Excluir transferencias bancarias
                //     ['id' => 'digital_wallet'], // Excluir billeteras digitales
                //     ['id' => 'mobile_payment'], // Excluir pagos móviles
                //     ['id' => 'mercadopago'], // Excluir saldo de MercadoPago
                //     ['id' => 'qr'], // Excluir QR
                //     ['id' => 'mobile_wallet'], // Excluir mobile wallet
                // ],

                // 'default_installments' => 1, // Cuotas por defecto
                // 'payment_type' => 'credit_card', // Forzar solo tarjeta de crédito
                // 'default_payment_method_id' => null, // No preseleccionar método de pago
                // 'purpose' => 'wallet_purchase', // Indicar que solo se puede pagar usando una cuenta de MercadoPago


                'installments' => 6, // Máximo 6 cuotas

                'binary_mode' => true, // Activar modo binario (aprobado/rechazado)-  No permite pagos pendientes
            ],
        ]);

        return $preference->id;
    }

}