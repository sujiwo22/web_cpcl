<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/login', [LoginController::class, 'index'])->name('home');

Auth::routes();
// Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user_level', [UserLevelController::class, 'index'])->name('user_level');
// });
