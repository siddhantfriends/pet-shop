<?php

use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users'], function (): void {
    Route::post('/create', [UserController::class, 'store']);
});
