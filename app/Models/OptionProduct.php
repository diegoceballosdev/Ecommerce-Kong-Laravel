<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class OptionProduct extends Pivot //en vez de extender de 'Model', lo modifico y ahora extiende de 'Pivot'
{
    use HasFactory;

    protected $table = 'option_product';

    //agrego este casteo en la tabla intermedia para que los features que son JSON se codifiquen como ARRAY al guardar, y al consultarlos se vuelvan nuevamente un JSON
    //esto evita que todo el tiempo estemos usando 'json_code' y 'json_encode' para castearlos
    protected $casts = [
        'features' =>'array'
    ];
}
