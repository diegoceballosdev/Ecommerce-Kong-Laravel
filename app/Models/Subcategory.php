<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
    ];

    //Relacion 1 a N inversa:
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relacion 1 a N:
    public function products(){
        return $this->hasMany(Product::class);
    }
}
