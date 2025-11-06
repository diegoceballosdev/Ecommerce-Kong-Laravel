<?php

namespace App\Observers;

use App\Mail\SendMail;
use App\Models\Order;
use App\Models\Variant;
use Barryvdh\DomPDF\Facade\Pdf;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    public function created(Order $order)
    {
        // Creamos la factura de compra

        $pdf = Pdf::loadView('orders.ticket', compact('order'));

        $pdf->save(storage_path('app/public/orders/ticket-' . $order->id . '.pdf'));

        $order->pdf_path = 'orders/ticket-' . $order->id . '.pdf';

        $order->save();


        //Enviamos EMAIL de COMPRA EXITOSA -----------------------------------

        Mail::to($order->user->email)->send(new SendMail($order));
    }
}
