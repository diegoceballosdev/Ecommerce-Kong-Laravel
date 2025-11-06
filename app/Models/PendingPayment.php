<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_reference',
        'payment_id',
        'status',
        'total',
        'products',
        'address',
    ];

    protected $casts = [
        'products' => 'array',
        'address' => 'array',
        'total' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}