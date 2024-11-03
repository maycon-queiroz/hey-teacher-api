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

});
// endregion
