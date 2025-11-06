<?php

namespace App\Livewire;


use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ShoppingCart extends Component
{
    public function mount()
    {
        // Inicializar cualquier dato necesario para el carrito de compras
        Cart::instance(instance: 'shopping');
    }

    #[Computed()]
    public function subtotal()
    {
        return Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        })->sum(function ($item) {
            return $item->subtotal;
        });
    }

    public function increase($rowId)
    {
        Cart::instance(instance: 'shopping');

        Cart::update(rowId: $rowId, qty: Cart::get(rowId: $rowId)->qty + 1);

        if (auth()->check()) {
            Cart::store(auth()->id()); // Guarda el carrito en la base de datos (opcional)
        }

        $this->dispatch('cartUpdated', Cart::count()); // para actualizar el contador del carrito en la barra de navegacion

    }

    public function decrease($rowId)
    {
        Cart::instance(instance: 'shopping');

        $item = Cart::get(rowId: $rowId);

        if ($item->qty > 1) {
            Cart::update(rowId: $rowId, qty: $item->qty - 1); // Disminuye la cantidad en 1 si es mayor que 1
        } else {
            Cart::remove(rowId: $rowId); // Elimina el item si la cantidad es 1
        }

        if (auth()->check()) {
            Cart::store(auth()->id()); // Guarda el carrito en la base de datos (opcional)
        }

        $this->dispatch('cartUpdated', Cart::count()); // para actualizar el contador del carrito en la barra de navegacion

    }

    public function removeProduct($rowId)
    {
        Cart::instance(instance: 'shopping');

        Cart::remove(rowId: $rowId);

        if (auth()->check()) {
            Cart::store(auth()->id()); // Guarda el carrito en la base de datos (opcional)
        }

        $this->dispatch('cartUpdated', Cart::count()); // para actualizar el contador del carrito en la barra de navegacion

    }

    public function destroyCart()
    {
        Cart::instance(instance: 'shopping');

        Cart::destroy();

        if (auth()->check()) {
            Cart::store(auth()->id()); // Guarda el carrito en la base de datos (opcional)
        }

        $this->dispatch('cartUpdated', Cart::count()); // para actualizar el contador del carrito en la barra de navegacion

    }
    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
