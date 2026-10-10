<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('v1')->group(function () {
    Route::prefix('shop')->group(function () {

    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);

    });

    Route::prefix('seller')->group(function () {
        Route::post('/register', [AuthController::class, 'sellerRegister']);

    });

    Route::prefix('admin')->group(function () {

    });
});


