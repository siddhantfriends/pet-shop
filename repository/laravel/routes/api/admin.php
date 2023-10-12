<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserEditController;
use App\Http\Controllers\Admin\UserListingController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (): void {
    Route::post('/create', [AdminController::class, 'store'])->name('create');

    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('auth.login')
        ->can('admin-access')
        ->name('login');

    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::group(['middleware' => ['auth.jwt', 'can:admin-access']], function (): void {
        Route::get('/user-listing', [UserListingController::class, 'index'])->name('user-listing');

        Route::put('/user-edit/{user:uuid}', UserEditController::class)->name('user-edit');
    });
});
