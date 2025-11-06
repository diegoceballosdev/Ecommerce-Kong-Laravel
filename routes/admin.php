<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard')
    ->middleware('can:access_dashboard');

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports.index');
    // ->middleware('can:manage_reports');

Route::resource('users', UserController::class)
    ->middleware('can:manage_users');

Route::resource('families', FamilyController::class)
    ->middleware('can:manage_families');

Route::resource('categories', CategoryController::class)
    ->middleware('can:manage_categories');

Route::resource('subcategories', SubcategoryController::class)
    ->middleware('can:manage_subcategories');

Route::resource('products', ProductController::class)
    ->middleware('can:manage_products');

Route::get('products/{product}/variants/{variant}', [ProductController::class, 'variants'])
    ->name('products.variants')
    ->scopeBindings() //->scopeBindings() para que use el scope del modelo Product en Variant (lo que evita que pueda acceder a variantes de otros productos)
    ->middleware('can:manage_products');

Route::put('products/{product}/variants/{variant}', [ProductController::class, 'variantsUpdate'])
    ->name('products.variantsUpdate')
    ->scopeBindings() //->scopeBindings() para que use el scope del modelo Product en Variant (lo que evita que pueda acceder a variantes de otros productos)
    ->middleware('can:manage_products');

Route::get('/options', [OptionController::class, 'index'])
    ->middleware('can:manage_options')
    ->name('options.index');

Route::resource('covers', CoverController::class)->middleware('can:manage_covers')
    ->middleware('can:manage_covers');

Route::get('orders', [OrderController::class, 'index'])
    ->name('orders.index')
    ->middleware('can:manage_orders');

Route::resource('drivers', DriverController::class)
    ->middleware('can:manage_drivers');

Route::get('shipment', [ShipmentController::class, 'index'])
    ->name('shipments.index')
    ->middleware('can:manage_shipments');