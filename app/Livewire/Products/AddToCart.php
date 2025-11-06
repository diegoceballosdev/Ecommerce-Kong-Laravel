<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;
use PhpParser\Node\Stmt\Foreach_;

class AddToCart extends Component
{
    public $product;
    public $variant; // variante seleccionada (si el producto tiene variantes)
    public $quantity = 1;
    public $stock;


    public $selectedFeatures = [
        // 'idTalla' => 'idValue',
        // 'idColor' => 'idValue',
    ];

    public function mount()
    {
        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->toArray(); // selecciona todas las features del producto (para productos sin variantes)

        $this->getVariant();
    }

    public function updatedSelectedFeatures()
    {
        $this->getVariant();
    }

    public function getVariant()
    {
        $this->variant = $this->product->variants->filter(function ($variant) {

            return !array_diff($variant->features->pluck('id')->toArray(), $this->selectedFeatures); // compara los ids de las features del variant con las features seleccionadas y devuelve el variant que coincida
        })
            ->first();

        $this->stock = $this->variant->stock;

        $this->quantity = 1; // resetea la cantidad a 1 cada vez que se cambia la variante
    }

    public function addToCart()
    {

        Cart::instance('shopping');  // Selecciona el carrito de compras (puede haber varios, como wishlist, etc)

        // Verifica si el producto ya esta en el carrito (mismo id, misma varianteSKU y mismas features)
        $cartItem = Cart::search(function ($cartItem, $rowId) {

            return $cartItem->options->code === $this->variant->sku;

        })->first();

        if($cartItem){
            $stock = $this->stock - $cartItem->qty; // calcula el stock restante

            if($stock < $this->quantity){
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Lo sentimos',
                    'text' => "No hay suficiente stock para agregar la cantidad seleccionada.",
                ]);

                return;
            }
        }

        // Hay varias formas de agregar un producto al carrito (ver documentacion), esta es una de ellas:
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->quantity, //uso 'qty' en lugar de 'quantity' porque es lo que usa el paquete del shoppingcart
            'price' => $this->product->price,
            'options' => [
                'image' => $this->product->image,
                'code' => $this->variant->sku,
                'stock' => $this->variant->stock,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                    //->pluck('value', 'id') // trae las features seleccionadas
                    ->pluck('description', 'id') // trae las features seleccionadas
                    ->toArray()
            ],
            // tax = 21, //impuestos
        ])
            ->associate(Product::class);

        if (auth()->check()) {
            Cart::store(auth()->id()); // Guarda el carrito en la base de datos (opcional)
        }

        $this->dispatch('cartUpdated', Cart::count()); // para actualizar el contador del carrito en la barra de navegacion


        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Listo',
            'text' => "El producto ha sido agregado al carrito de compras.",
        ]);
    }


    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
