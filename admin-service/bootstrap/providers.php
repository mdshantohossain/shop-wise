<?php

use App\Modules\Order\app\Providers\OrderServiceProvider;
use App\Modules\Payment\app\Providers\PaymentServiceProvider;
use service\Catalog\app\Providers\CatalogServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    Gloudemans\Shoppingcart\ShoppingcartServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    CatalogServiceProvider::class,
    PaymentServiceProvider::class,
    OrderServiceProvider::class,
];
