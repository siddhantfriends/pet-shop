<?php

use App\Http\Controllers\ProductController;

Route::apiResource('/products', ProductController::class)->only('index');
Route::apiResource('/product', ProductController::class)->only('show');

Route::apiResource('/product/create', ProductController::class)
    ->middleware('auth.jwt')
    ->only('store')
    ->name('store', 'product.store');

Route::apiResource('/product', ProductController::class)
    ->middleware('auth.jwt')
    ->except(['index', 'show', 'store']);
