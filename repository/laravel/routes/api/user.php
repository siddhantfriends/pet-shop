<?php

use App\Http\Controllers\UserController;

Route::group(['prefix' => 'user', 'name' => 'user.'], function (): void {
    Route::post('/create', [UserController::class, 'store'])->name('create');
});
