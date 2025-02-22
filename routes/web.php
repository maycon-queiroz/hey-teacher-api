<?php

use App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Route;

Route::get('/', function () { echo "404";});

Route::post('/register', Auth\RegisterController::class)
    ->middleware('guest')
    ->name('register');
Route::post('/login', Auth\LoginController::class)
    ->middleware('guest')
    ->name('login');
Route::post('/logout', Auth\LogoutController::class)
    ->middleware(['auth'])
    ->name('logout');
