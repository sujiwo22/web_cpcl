<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserLevelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/login', [LoginController::class, 'index'])->name('home');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route::resource('/user_level', UserLevelController::class);

    Route::get('/user_level', [UserLevelController::class, 'index'])->name('user_level');
    Route::post('/user_level', [UserLevelController::class, 'store'])->name('user_level.store');
    // Route::post('/user_level', [UserLevelController::class, 'update'])->name('user_level.update');
    // Route::get('/user_level/edit/{id}', [UserLevelController::class, 'edit'])->name('user_level.edit');
    Route::get('/user_level/{id}', [UserLevelController::class, 'show'])->name('user_level.show');
    Route::delete('/user_level/{id}', [UserLevelController::class, 'destroy'])->name('user_level.destroy');

});
