<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'stock',
        'subcategory_id',
    ];

    // Accessor para la imagen del producto:
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->image_path));
    }

    //Relacion 1 a N inversa:
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    //Relacion 1 a N:
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    //Relacion M a N:
    public function options()
    {
        return $this->belongsToMany(Option::class)
            ->using(OptionProduct::class) //usa el modelo para el casteo de json definido en dicho modelo
            ->withPivot('features') //para recuperar columnas.
            ->withTimestamps(); //para crear columnas de creacion y modificacion en tablas intermedias.
    }
}