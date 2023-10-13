<?php

use App\Http\Controllers\CategoryController;

Route::apiResource('/categories', CategoryController::class)->only('index');
Route::apiResource('/category', CategoryController::class)->only('show');

Route::apiResource('/category/create', CategoryController::class)
    ->middleware('auth.jwt')
    ->only('store')
    ->name('store', 'category.store');

Route::apiResource('/category', CategoryController::class)
    ->middleware('auth.jwt')
    ->except(['index', 'show', 'store']);
