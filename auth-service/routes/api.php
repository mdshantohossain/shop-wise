<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;


Route::prefix('v1')->group(function () {
    Route::post('/seller/register', [SellerController::class, 'register']);
});
