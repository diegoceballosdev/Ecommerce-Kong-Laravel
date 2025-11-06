<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

        protected $fillable = [
        'value',
        'description',
        'option_id',
    ];

    //Relacion 1 a N inversa:
    public function option(){
        return $this->belongsTo(Option::class);
    }

    //Relacion M a N:
    public function variants(){
        return $this->belongsToMany(Variant::class)
                    ->withTimestamps(); //para crear columnas de creacion y modificacion en tablas intermedias.
    }
}
