<?php

use App\Http\Controllers\{Question};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Route};

Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');

// region Questions
Route::post('questions', Question\StoreController::class)->name('questions.store');
Route::put('questions/{question}', Question\EditController::class)->name('questions.update');
Route::delete('questions/{question}', Question\DeleteController::class)->name('questions.delete');
Route::delete('questions/{question}/archive', Question\ArchiveController::class)->name('questions.archive');
Route::put('questions/{question}/restore', Question\RestoreController::class)->name('questions.restore');
Route::put('questions/{question}/publish', Question\PublishController::class)->name('questions.publish');
