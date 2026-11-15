<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('shop')->group(function () {

    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

    });

    Route::prefix('seller')->group(function () {
        Route::post('/register', [AuthController::class, 'sellerRegister']);

    });

    Route::prefix('admin')->group(function () {

    });
});
