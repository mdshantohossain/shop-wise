<?php

namespace App\Modules\Order\app\Providers;

use App\Modules\Order\app\Models\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        Route::prefix('api')
             ->group(__DIR__ . '/../../routes/api.php');

        Route::bind('order', function (string $slug) {
            return Order::where('slug', $slug)->firstOrFail();
        });
    }
}
