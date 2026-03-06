<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/login', [LoginController::class, 'index'])->name('home');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // User Level
    Route::get('/user_level', [UserLevelController::class, 'index'])->name('user_level');
    Route::post('/user_level', [UserLevelController::class, 'store'])->name('user_level.store');
    Route::get('/user_level/{id}', [UserLevelController::class, 'show'])->name('user_level.show');
    Route::delete('/user_level/{id}', [UserLevelController::class, 'destroy'])->name('user_level.destroy');
    Route::post('/user_level', [UserLevelController::class, 'list'])->name('user_level.list');

    // User
    Route::get('/user_list', [UserController::class, 'index'])->name('user_list');
    Route::post('/user_list', [UserController::class, 'store'])->name('user_list.store');
    Route::get('/user_list/{id}', [UserController::class, 'show'])->name('user_list.show');
    Route::delete('/user_list/{id}', [UserController::class, 'destroy'])->name('user_list.destroy');
    Route::get('/user_list/lock/{id}', [UserController::class, 'lock_account'])->name('user_list.lock');
    Route::get('/user_list/unlock/{id}', [UserController::class, 'unlock_account'])->name('user_list.unlock');
});

Route::get('/send-email', function () {
    $data = [
        'name' => 'Sujiwo',
        'body' => 'Testing Kirim Email dari Laravel',
    ];

    Mail::to('massujiwo2288@gmail.com')->send(new SendEmail($data));

    dd('Email Berhasil dikirim.');
});
