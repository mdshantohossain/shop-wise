<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        // Public
        Route::post('/login', [AuthController::class, 'login']);

        // Protected
        Route::middleware(['auth:api', 'session.active'])->group(function () {
        Route::get('/me', 'me');
        Route::post('/register', 'register');
        Route::post('/web/logout', 'webLogout');
        Route::post('/mobile/logout', 'mobileLogout');

        Route::post('/logout-all', 'logoutAll');

        Route::delete('/sessions/{sessionId}', 'revokeSession');
        });
    });

    Route::middleware('trusted.web')->group(function () {
        Route::post('/web/refresh', [AuthController::class, 'webRefreshToken']);
        Route::post('/mobile/refresh', [AuthController::class, 'mobileRefreshToken']);
    });

    Route::post('/seller/register', [SellerController::class, 'register']);
});
