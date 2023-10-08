<?php

use App\Http\Controllers\UserController;
use Illuminate\Routing\Router;

Route::group(['prefix' => 'users'], function (): void {
    Route::post('/create', [UserController::class, 'store']);
});
