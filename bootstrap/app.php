<?php

use App\Http\Middleware\VerifyStock;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',

        //Debo agregar esto para que laravel reconozca las rutas de routes/admin.php
        then: function () {
            Route::middleware('web', 'auth')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {

        //Registro de nuevos middleware globales:
        //$middleware->append(VerifyStock::class);

        // Excluir rutas de la verificación CSRF:
        $middleware->validateCsrfTokens(except: [
            'checkout/*',
            // 'mercadopago/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
