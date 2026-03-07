<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Mail\SendEmail;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});
// Route::get('/', [LoginController::class, 'index'])->name('home');

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

    // Provinsi
    Route::get('/provinsi', [ProvinsiController::class, 'index'])->name('provinsi');
    Route::post('/provinsi', [ProvinsiController::class, 'store'])->name('provinsi.store');
    Route::get('/provinsi/{id}', [ProvinsiController::class, 'show'])->name('provinsi.show');
    Route::delete('/provinsi/{id}', [ProvinsiController::class, 'destroy'])->name('provinsi.destroy');
    Route::get('/list_provinsi', [ProvinsiController::class, 'list'])->name('provinsi.list');

    // Kota
    Route::get('/kota', [KotaController::class, 'index'])->name('kota');
    Route::post('/kota', [KotaController::class, 'store'])->name('kota.store');
    Route::get('/kota/{id}', [KotaController::class, 'show'])->name('kota.show');
    Route::delete('/kota/{id}', [KotaController::class, 'destroy'])->name('kota.destroy');
    Route::get('/list_kota/{id}', [KotaController::class, 'list'])->name('kota.list');
    
    // Kecamatan
    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan');
    Route::post('/kecamatan', [KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::get('/kecamatan/{id}', [KecamatanController::class, 'show'])->name('kecamatan.show');
    Route::delete('/kecamatan/{id}', [KecamatanController::class, 'destroy'])->name('kecamatan.destroy');
    Route::get('/list_kecamatan/{id}', [KecamatanController::class, 'list'])->name('kecamatan.list');
    
    // Kelurahan
    Route::get('/kelurahan', [KelurahanController::class, 'index'])->name('kelurahan');
    Route::post('/kelurahan', [KelurahanController::class, 'store'])->name('kelurahan.store');
    Route::get('/kelurahan/{id}', [KelurahanController::class, 'show'])->name('kelurahan.show');
    Route::delete('/kelurahan/{id}', [KelurahanController::class, 'destroy'])->name('kelurahan.destroy');
    Route::get('/list_kelurahan/{id}', [KelurahanController::class, 'list'])->name('kelurahan.list');
});

Route::get('/send-email', function () {
    $data = [
        'name' => 'Sujiwo',
        'body' => 'Testing Kirim Email dari Laravel',
    ];

    Mail::to('massujiwo2288@gmail.com')->send(new SendEmail($data));

    dd('Email Berhasil dikirim.');
});
