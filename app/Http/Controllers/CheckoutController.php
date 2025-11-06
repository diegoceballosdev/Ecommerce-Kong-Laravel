<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Variant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
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

        $shipping = number_format(num: 0, decimals: 2);

        $total = $subtotal + $shipping;

        // Generar los tokens necesarios para el pago de NIUBIZ
        $access_token = $this->generateAccessToken();
        $session_token = $this->generateSessionToken($access_token, $total);

        return view('checkout.index', compact('session_token', 'content', 'subtotal', 'shipping', 'total'));
    }

    //TOKEN DE ACCESO NIUBIZ:
    public function generateAccessToken()
    {
        // Lógica para generar el access token
        $url_api = config('services.niubiz.url_api') . '/api.security/v1/security';
        $user = config('services.niubiz.user');
        $password = config('services.niubiz.password');

        $auth = base64_encode($user . ":" . $password);

        return Http::withHeaders([
            'Authorization' => 'Basic ' . $auth
        ])
            ->get($url_api)
            ->body();
    }

    //SESSION TOKEN NIUBIZ:
    public function generateSessionToken($access_token, $total)
    {
        // Lógica para generar el session token
        $merchant_id = config('services.niubiz.merchant_id');

        $url_api = config('services.niubiz.url_api') . "/api.ecommerce/v2/ecommerce/token/session/{$merchant_id}";

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            //'Host' => 'apisandbox.vnforappstest.com'
        ])
            ->post($url_api, [
                'channel' => 'web',
                'amount' => $total,
                'antifraud' => [
                    'clientIp' => request()->ip(),
                    'merchantDefineData' => [
                        // 'MDD4' => "integraciones@niubiz.com.pe",
                        // 'MDD32' => "JD1892639123",
                        // 'MDD75' => "Registrado",
                        // 'MDD77' => '458',
                        'MDD15' => "value15",
                        'MDD20' => "value20",
                        'MDD33' => 'value33',
                    ]
                ],
                // 'dateMap' => [
                //     "cardholderCity" => "Lima",
                //     "cardholderCountry" => "PE",
                //     "cardholderAddress" => "Av Jose Pardo 831",
                //     "cardholderPostalCode" => "12345",
                //     "cardholderState" => "LIM",
                //     "cardholderPhoneNumber" => "987654321"
                // ]
            ])
            ->json();

        //dd($response['sessionKey']);
        return $response['sessionKey'];
    }

    public function paid(Request $request)
    {
        // Manejar la respuesta después del pago

        $access_token = $this->generateAccessToken();

        $merchant_id = config('services.niubiz.merchant_id');

        $url_api = config('services.niubiz.url_api') . "/api.authorization/v3/authorization/ecommerce/{$merchant_id}";

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
        ])
            ->post($url_api, [
                'channel' => 'web',
                'captureType' => 'manual',
                "countable" => true,
                "order" => [
                    "tokenId" => $request->transactionToken, //tokenId de la tarjeta 
                    "purchaseNumber" => $request->purchaseNumber, //número de compra 
                    "amount" => $request->amount, //monto de la compra cargado en la ruta get desde el index.blade
                    "currency" => "USD" //moneda de la compra
                ]
            ])
            ->json();

        //guardar en sesión los detalles de la transacción para mostrarlos en la vista gracias.blade.php
        session()->flash('niubiz', [
            'response' => $response,
            "purchaseNumber" => $request->purchaseNumber,
        ]);


        if (isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] == '000') {

            //Pago Aprobado

            // Mostrar solo productos con stock suficiente:
            Cart::instance('shopping');

            $content = Cart::content()->filter(function ($item) {
                return $item->qty <= $item->options['stock'];
            });

            $address = Address::where('user_id', auth()->id())
                ->where('default', true)
                ->first();

            Order::create([
                'user_id' => auth()->id(),
                'products' => $content,
                'address' => $address,
                'payment_id' => $response['dataMap']['TRANSACTION_ID'],
                'total' => $response['dataMap']['AMOUNT'],
            ]);

            foreach ($content as $item) {
                Variant::where('sku', $item->options['code'])
                    ->decrement('stock', $item->qty);

                    Cart::remove($item->rowId); //eliminar del carrito los productos que se han comprado
            }

            Cart::destroy(); //vaciar el carrito

            return redirect()->route('checkout.gracias');

        } else {

            //Pago Rechazado
            return redirect()->route('checkout.index');
        }
    }
}
