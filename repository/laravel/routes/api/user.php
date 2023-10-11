<?php

use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function (): void {
    Route::post('/create', [UserController::class, 'store'])->name('create');

    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store'])
        ->middleware('auth.login')
        ->can('user-access')
        ->name('login');

    Route::group(['middleware' => ['auth.jwt', 'can:user-access']], function (): void {
        Route::get('/', [UserController::class, 'index'])->name('account');
    });
});
