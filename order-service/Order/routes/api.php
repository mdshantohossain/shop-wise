<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Order\app\Http\Controllers\OrderController;


// check valid order
//Route::get('/orders', [OrderController::class, 'getOrders']);

// verify order
Route::get('/verify-order/{slug}', [OrderController::class, 'verifyOrder']);

// place order
Route::post('/place-order', [OrderController::class, 'placeOrder']);
