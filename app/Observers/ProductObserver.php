<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Variant;

class ProductObserver
{
    public function created(Product $product)
    {
        Variant::Create([
            'product_id' => $product->id,
        ]);
    }
}
