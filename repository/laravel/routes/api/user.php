<?php

use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function (): void {
    Route::post('/create', [UserController::class, 'store'])->name('create');
});
