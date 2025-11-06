<?php

namespace App\Listeners;



use Illuminate\Auth\Events\Login;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RestoreCartItems
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        //Restaurar carrito de compras
        Cart::instance('shopping')->restore($event->user['id']); // el id del usuario autenticado
    }
}
