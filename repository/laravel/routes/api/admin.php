<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (): void {
    Route::post('/create', [AdminController::class, 'store'])->name('create');

    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('auth.login')
        ->can('admin-access')
        ->name('login');
});
