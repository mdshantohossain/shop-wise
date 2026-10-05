<?php

namespace App\Providers;

use App\Observers\ProductObserver;
use App\Observers\ReviewObserver;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use service\Catalog\app\Models\Product;
use service\Catalog\app\Models\Review;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $loader = AliasLoader::getInstance();
            $loader->alias('Debugbar', Debugbar::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // notification
        View::composer('admin.layouts.master', function ($view) {
            if(auth()->check() && auth()->user()->can('notification module')) {
                $notifications = auth()->user()
                    ->unreadNotifications()
                    ->limit(6)
                    ->get();

                $notificationCount = auth()->user()
                    ->unreadNotifications()
                    ->count();

                $view->with([
                    'notifications' => $notifications,
                    'notificationCount' => $notificationCount,
                ]);
            }
        });
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
