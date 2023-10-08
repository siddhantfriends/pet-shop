<?php

use App\Http\Controllers\UserController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function (): void {
    Route::post('/create', [UserController::class, 'store'])->name('create');
});
