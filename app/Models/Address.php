<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'reference',
        'postal_code',
        'locality',
        'province',
        'receiver',
        'receiver_info',
        'default',
    ];

    protected $casts = [
        'receiver_info' => 'array', // Convierte el campo JSON a un array automáticamente
        'default' => 'boolean', // Convierte el campo a booleano automáticamente
    ];

}
