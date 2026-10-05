<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CjController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailSettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShippingChargeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AdminAuthenticatedMiddleware;
use App\Http\Middleware\AuthenticatedForUserMiddleware;
use App\Modules\Payment\app\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPolicyController;

// custom login route
Route::post('/login', [LoginController::class, 'index']);


Route::middleware(['auth', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::middleware(AuthenticatedForUserMiddleware::class)->group(function () {
        Route::resource('wishlist', WishlistController::class)->except(['create', 'show', 'edit', 'update']);
    });

    Route::resource('/categories', CategoryController::class)
        ->except(['show']);

    Route::resource('/sub-categories', SubCategoryController::class)
        ->except(['show']);

    Route::resource('products', ProductController::class);

// get sub category via category id
    Route::get('/get-sub-categories/{categoryId}', [SubCategoryController::class,  'getSubCategories']);

    Route::resource('product-policies', ProductPolicyController::class)->except(['show']);

    // order
    Route::resource('orders', OrderController::class);
    Route::get('/progressing-orders', [OrderController::class, 'progressingOrders'])->name('progressing.orders');
    Route::get('/in-complete-orders', [OrderController::class, 'inCompleteOrders'])->name('in-complete.orders');
    Route::get('/revision-orders', [OrderController::class, 'revisionOrders'])->name('revision.orders');

    // admin routes
    Route::middleware(AdminAuthenticatedMiddleware::class)->group(function () {
        // admin dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware(['permission:dashboard show']);

        // banners
        Route::resource('banners', BannerController::class);

        Route::resource('reviews', ReviewController::class)
            ->middleware(['permission:review create|review edit|review destroy']);

        // shipping manage
        Route::resource('shipping',  ShippingChargeController::class)
            ->except( 'show');

        // notifications
        Route::get('/all-notifications', [NotificationController::class, 'index'])->name('all.notifications');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark.all.read');

        // app info
        Route::get('/app-info', [AppInfoController::class, 'index'])
            ->name('app.info')
            ->middleware(['permission:permission module']);

        Route::match(['post', 'put'], '/app-info', [AppInfoController::class, 'store'])
            ->middleware(['permission:permission module']);

        // email credential
        Route::get('/mail-setting', [MailSettingController::class, 'index'])
            ->name('mail.setting');
        Route::post('/mail-setting', [MailSettingController::class, 'store']);

        // role, permission and user
        Route::resource('permissions', PermissionController::class)
            ->except(['show'])
            ->middleware(['permission:permission create']);

        Route::resource('roles', RoleController::class)
            ->except(['show'])
             ->middleware(['permission:role create|role edit|role destroy']);

        Route::resource('users', UserController::class)
            ->except(['show'])
            ->middleware(['permission:user create|user edit|user destroy']);

Route::resource('faqs', FaqController::class)
    ->except(['show'])
    ->middleware(['permission:faq create|faq edit|faq destroy']);
});

// cj token crud
Route::get('/cj-token', [CjController::class, 'create'])->name('cj.token');
Route::match(['post', 'put'], '/app-info', [CjController::class, 'store'])->name('cj.token.store');

// payment gateway api
Route::get('/payment-gateway/setting', [PaymentController::class, 'create'])->name('payment.setting');
Route::match(['post', 'put'], '/payment-gateway/setting', [PaymentController::class, 'store'])->name('payment.setting.store');

// cj search product
Route::post('/cj-search-product', [CjController::class, 'index'])->name('cj.product.search');
});

// payment route
Route::post('/payment-success', [PaymentController::class, 'payment'])->name('payment.callback');

// application cache clear
Route::get('/app-cache-clear', function () {
    Artisan::call('optimize:clear');
    return back()->with('success', 'App cache is cleared');
})->name('app-cache.clear');
