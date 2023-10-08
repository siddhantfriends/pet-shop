<?php

use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users'], function () {
    Route::post('/create', [UserController::class, 'store']);
});
