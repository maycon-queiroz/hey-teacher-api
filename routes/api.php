<?php

use App\Http\Controllers\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// region Authentication
Route::middleware('auth:sanctum')->group(function () {

    // region Questions
    Route::post('questions', Question\StoreController::class)->name('questions.store');
    Route::put('questions/{question}', Question\EditController::class)->name('questions.update');
    Route::delete('questions/destroy/{question}', Question\DeleteController::class)->name('questions.destroy');

});
// endregion
