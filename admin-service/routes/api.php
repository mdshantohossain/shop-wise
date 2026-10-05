<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ShippingChargeController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use service\Catalog\app\Http\Controllers\ProductController;
use service\Catalog\app\Http\Controllers\ReviewController;
use service\Catalog\app\Http\Controllers\SearchController;
use App\Http\Controllers\SellerController;

Route::middleware('auth:sanctum')->group(function () {
    // user
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/save-address', [UserController::class, 'saveAddress']);
    Route::post('/update-address', [UserController::class, 'updateAddress']);
    Route::get('/delete-address/{id}', [UserController::class, 'deleteAddress']);
    Route::post('/update-password', [UserController::class, 'updatePassword']);

    // product review
    Route::post('/create-review', [ReviewController::class, 'addReview']);

    Route::get('/addresses', [UserController::class, 'getAddresses']);

    // logout
    Route::post('/auth/logout',  [LoginController::class, 'logout']);
});

// filter
Route::get('/filter-products', [SearchController::class, 'filterProducts']);

// auth
Route::post('/auth/register',  [RegistrationController::class, 'index']);
Route::get('/auth/verify-email',  [RegistrationController::class, 'verifyEmail']);
Route::get('/auth/resend-verification-email',  [RegistrationController::class, 'resendVerifyEmail']);
Route::post('/auth/login',  [LoginController::class, 'login']);

// social login
Route::post('/auth/social-login',  [SocialLoginController::class, 'socialLogin']);

Route::get('/auth/forgot-password',  [ForgotPasswordController::class, 'index']);
Route::post('/auth/reset-password',  [ForgotPasswordController::class, 'store']);

// refresh access token
Route::post('/auth/refresh-token', [LoginController::class, 'refreshToken']);

// wishlist
Route::post('/wishlist-add', [WishlistController::class, 'store']);

// shipping charge
Route::get('/shipping-charge', [ShippingChargeController::class, 'getShippingMethods']);

Route::get('/faqs', [FaqController::class, 'getAllFaqs']);
Route::get('/app-info', [AppInfoController::class, 'getAppInfo']);
Route::get('/product-details/{slug}', [ProductController::class, 'getProductDetail']);
Route::get('/related-products/{slug}', [ProductController::class, 'getRelatedProducts']);

Route::prefix('v1')->group(function () {
   // seller
    Route::post('/seller/register', [SellerController::class, 'register']);
});
