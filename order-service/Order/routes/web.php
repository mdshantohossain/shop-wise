<?php

use Illuminate\Support\Facades\Route;

use App\Modules\Order\app\Http\Controllers\OrderController;

Route::get( '/download/invoice/{order}', [OrderController::class, 'invoice'])
    ->name('download.invoice');

// order routes
Route::resource( 'orders', OrderController::class)->except( 'create', 'store')
    ->middleware(['permission:order module']);
