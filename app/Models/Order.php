<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus; // Asegúrate de importar la clase OrderStatus

class Order extends Model
{
    use HasFactory;

    //los campos listados en $guarded estarán protegidos y no podrán ser llenados usando métodos como create() o fill().
    protected $guarded = [
        'status'
    ];

    protected $casts = [
        'products' => 'array',
        'address' => 'array',
        'status' => OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
