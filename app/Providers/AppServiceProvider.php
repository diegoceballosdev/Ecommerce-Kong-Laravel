<?php

namespace App\Providers;

use App\Listeners\RestoreCartItems;
use App\Models\Cover;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use App\Observers\CoverObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\VariantObserver;
use Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
if (env(key: 'APP_ENV') === 'local' && request()->server(key: 'HTTP_X_FORWARDED_PROTO') === 'https') {
    URL::forceScheme(scheme: 'https');
}
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cover::observe(CoverObserver::class);
        Order::observe(OrderObserver::class);
        Product::observe(ProductObserver::class);
        Variant::observe(VariantObserver::class);

        // This is the manual registration for the Login event.
        Event::listen(
            Login::class,
            RestoreCartItems::class
        );
    }
}
