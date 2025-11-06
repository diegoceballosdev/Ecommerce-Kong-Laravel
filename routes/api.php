<?php

use App\Http\Controllers\Api\SortController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MercadoPagoController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sort/covers', [SortController::class, 'covers'])->name('api.sort.covers');


Route::post('/mercadopago/webhook', [MercadoPagoController::class, 'handleWebhook'])
    ->name('mercadopago.webhook')->withoutMiddleware(VerifyCsrfToken::class);
