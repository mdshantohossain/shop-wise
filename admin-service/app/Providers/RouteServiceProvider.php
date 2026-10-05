<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use service\Catalog\app\Models\Product;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Route::bind('review', function (int $id) {
            return Product::select(['id', 'name', 'image_thumbnail', 'sku'])->where('id', $id)->firstOrFail();
        });
    }
}
