<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'family_id',
    ];

    //Relacion 1 a N inversa:
    public function family(){
        return $this->belongsTo(Family::class);
    }

    //Relacion 1 a N:
    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }
}
