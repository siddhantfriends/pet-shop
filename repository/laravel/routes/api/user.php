<?php

use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function (): void {
    Route::post('/create', [UserController::class, 'store'])->name('create');

    Route::group(['middleware' => 'auth.jwt'], function (): void {
        Route::get('/', [UserController::class, 'index'])->name('account');
    });
});
