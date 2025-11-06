<?php

namespace App\Observers;

use App\Models\Variant;
use Illuminate\Support\Str;

class VariantObserver
{
    public function created(Variant $variant)
    {

        if ($variant->product->options->count() == 0) {
            $variant->sku = $variant->product->sku;

            $variant->stock = 10; //solo para pruebas, en produccion eliminar esta linea

            $variant->save();

            return;
        }

        //queremos generar un sku numeric de 12 digitos
        $variant->sku = Str::random(12);
        $variant->save();
    }
}