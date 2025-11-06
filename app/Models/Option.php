<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    //Relacion M a N:
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(OptionProduct::class) //usa el modelo para el casteo de json definido en dicho modelo
            ->withPivot('features') //para recuperar columnas.
            ->withTimestamps(); //para crear y recuperar columnas de creacion y modificacion en tablas intermedias.
    }

    //Relacion 1 a N:
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}