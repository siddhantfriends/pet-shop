<?php

use App\Http\Controllers\PaymentController;

Route::group(['middleware' => ['auth.jwt']], function (): void {
    Route::apiResource('/payments', PaymentController::class)->only('index');

    Route::apiResource('/payment/create', PaymentController::class)
        ->only('store')
        ->name('store', 'payment.store');

    Route::apiResource('/payment', PaymentController::class)
        ->except(['index', 'store']);
});
