<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\MyPurchasesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\VerifyStock;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//VISTA PRINCIPAL

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('contact', function () {
    return view('contact');
})->name('contact');

Route::get('faq', function () {
    return view('faq');
})->name('faq');


//VISTAS DE PRODUCTOS

Route::get('search', [SearchProductController::class, 'index'])->name('search');

Route::get('families/{family}', [FamilyController::class, 'show'])->name('families.show');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');


//VISTAS DE CARRITO Y COMPRA

Route::get('my-purchases', [MyPurchasesController::class, 'index'])->name('my-purchases')->middleware('auth');

Route::get('cart', [CartController::class, 'index'])->name('cart.index')->middleware(VerifyStock::class);

Route::get('shipping', [ShippingController::class, 'index'])->name('shipping.index')->middleware('auth');

Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');

Route::post('checkout/paid', [CheckoutController::class, 'paid'])->name('checkout.paid')->middleware('auth');

Route::get('gracias', function () {
    return view('checkout.gracias');
})->name('checkout.gracias')->middleware('auth');