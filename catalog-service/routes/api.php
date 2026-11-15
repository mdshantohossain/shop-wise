<?php

use Illuminate\Support\Facades\Route;

use service\Catalog\app\Http\Controllers\BrandController;
use service\Catalog\app\Http\Controllers\CategoryController;
use service\Catalog\app\Http\Controllers\ProductController;
use service\Catalog\app\Http\Controllers\SearchController;

Route::middleware('auth:sanctum')->group(function () {
});

Route::get('/brands', [BrandController::class, 'getBrands']);
Route::get('/categories', [CategoryController::class, 'getAllCategories']);
Route::get('/exclusive-products', [ProductController::class, 'getExclusiveProducts']);
Route::get('/trending-products', [ProductController::class, 'getTrendingProducts']);
Route::get('/category-products', [ProductController::class, 'getCategoryProducts']);
Route::get('/sub-category-products', [ProductController::class, 'getSubCategoryProducts']);
Route::get('/search-products', [SearchController::class, 'getSearchProducts']);

// get products slug for ssg
Route::get('/products/slugs', [ProductController::class, 'getProductsSlugs']);
