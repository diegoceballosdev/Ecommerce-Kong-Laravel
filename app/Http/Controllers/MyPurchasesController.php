<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MyPurchasesController extends Controller
{
    public function index()
    {
        return view('myPurchases');
    }
}
