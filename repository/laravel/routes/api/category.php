<?php

use App\Http\Controllers\CategoryController;

Route::group(['middleware' => 'auth.jwt'], function (): void {
    Route::apiResource('/category', CategoryController::class);
});
