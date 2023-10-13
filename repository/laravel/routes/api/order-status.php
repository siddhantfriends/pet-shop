<?php

use App\Http\Controllers\OrderStatusController;

Route::apiResource('/order-statuses', OrderStatusController::class)->only('index');
Route::apiResource('/order-status', OrderStatusController::class)->only('show');

Route::apiResource('/order-status/create', OrderStatusController::class)
    ->middleware('auth.jwt')
    ->only('store')
    ->name('store', 'order-status.store');

Route::apiResource('/order-status', OrderStatusController::class)
    ->middleware('auth.jwt')
    ->except(['index', 'show', 'store']);
