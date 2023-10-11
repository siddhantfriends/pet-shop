<?php

use App\Http\Controllers\FileController;

Route::group(['prefix' => 'file', 'as' => 'file.'], function (): void {
    Route::post('upload', [FileController::class, 'store'])->name('upload');
});
