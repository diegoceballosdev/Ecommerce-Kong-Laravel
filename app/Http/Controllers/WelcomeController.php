<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {

        $covers = Cover::where('is_active', true)

            ->whereDate('start_at', '<=', now()) //la fecha de inicio es menor o igual a hoy
            ->where(function ($query) {
                //la fecha de fin es mayor o igual a hoy o la fecha de fin es nula)
                $query->whereDate('end_at', '>=', now())
                    ->orWhereNull('end_at');
            })
            ->orderBy('order')
            ->get();

        $lastProducts = Product::orderBy('created_at', 'desc')
            ->take(8) //cantidad de registros
            ->get();

        return view('welcome', compact('covers','lastProducts'));
    }
}
