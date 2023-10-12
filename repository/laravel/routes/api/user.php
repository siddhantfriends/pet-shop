<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\LoginController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function (): void {
    Route::post('/create', [UserController::class, 'store'])->name('create');

    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('auth.login')
        ->can('user-access')
        ->name('login');

    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::group(['middleware' => ['auth.jwt', 'can:user-access']], function (): void {
        Route::get('/', [UserController::class, 'index'])->name('account');

        Route::put('/edit', [UserController::class, 'update'])->name('update');
    });
});
