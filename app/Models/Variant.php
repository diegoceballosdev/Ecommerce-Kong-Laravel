<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'stock',
        'product_id',
    ];

    // Accessor para la imagen del producto:
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->image_path ? Storage::url($this->image_path) : asset('img/no-image.png'),
        ); //si tiene imagen, la saca de storage, si no, saca una por defecto.
    }

    //Relacion 1 a N inversa:
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //Relacion M a N:
    public function features()
    {
        return $this->belongsToMany(Feature::class)
            ->withTimestamps(); //para crear columnas de creacion y modificacion en tablas intermedias.
    }
}
