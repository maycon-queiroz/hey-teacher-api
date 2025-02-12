<?php

use App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Route;

Route::get('/', function () { echo "404";});

Route::post('/register', Auth\RegisterController::class)->name('register');
Route::post('/login', Auth\LoginController::class)->name('login');
Route::post('/logout', Auth\LogoutController::class)
    ->middleware('auth', 'auth:sanctum')
    ->name('logout');
