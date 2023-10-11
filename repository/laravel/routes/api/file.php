<?php

use App\Http\Controllers\FileController;

Route::group(['prefix' => 'file', 'as' => 'file.'], function (): void {
    Route::post('upload', [FileController::class, 'store'])->middleware('auth.jwt')->name('upload');
    Route::get('{file:uuid}', [FileController::class, 'show'])->name('read');
});
