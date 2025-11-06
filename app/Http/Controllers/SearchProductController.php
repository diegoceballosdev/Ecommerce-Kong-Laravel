<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class SearchProductController extends Controller
{
    use WithPagination;

    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::where('name', 'LIKE', "%{$search}%")
            ->paginate(12);

        return view('search.index', compact('products'));
    }

}
