<?php

use App\Http\Controllers\FileController;

Route::group(['prefix' => 'file', 'as' => 'file.', 'middleware' => 'auth.jwt'], function (): void {
    Route::post('upload', [FileController::class, 'store'])->name('upload');
});
