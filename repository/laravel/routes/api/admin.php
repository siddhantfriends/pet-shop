<?php

use App\Http\Controllers\Admin\AdminController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (): void {
    Route::post('/create', [AdminController::class, 'store'])->name('create');

    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store'])
        ->middleware('auth.login')
        ->can('admin-access')
        ->name('login');
});
