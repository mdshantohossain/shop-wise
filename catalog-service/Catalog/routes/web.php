<?php

use Illuminate\Support\Facades\Route;
use service\Catalog\app\Http\Controllers\CategoryController;
use service\Catalog\app\Http\Controllers\ProductController;
use service\Catalog\app\Http\Controllers\ProductPolicyController;
use service\Catalog\app\Http\Controllers\SubCategoryController;

Route::middleware(['web', 'auth', config('jetstream.auth_session'), 'verified'])->group(function () {


});





