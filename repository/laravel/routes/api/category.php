<?php

use App\Http\Controllers\CategoryController;

Route::apiResource('/categories', CategoryController::class)->only('index');
Route::apiResource('/category', CategoryController::class)->only('show');

Route::apiResource('/category', CategoryController::class)
    ->middleware('auth.jwt')
    ->except(['index', 'show']);
