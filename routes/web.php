<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\KementrianController;
use App\Http\Controllers\DirjenController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ProgramAlokasiController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ReportRekapUsulanProgramController;
use App\Mail\SendEmail;
use App\Models\Anggota;
use App\Models\Jabatan;
use App\Models\Kecamatan;
use App\Models\Kementrian;
use App\Models\ProgramAlokasi;
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

    // TPS
    Route::get('/tps', [TpsController::class, 'index'])->name('tps');
    Route::post('/tps', [TpsController::class, 'store'])->name('tps.store');
    Route::get('/tps/{id}', [TpsController::class, 'show'])->name('tps.show');
    Route::delete('/tps/{id}', [TpsController::class, 'destroy'])->name('tps.destroy');
    Route::post('/list_tps', [TpsController::class, 'list'])->name('tps.list');

    // Kementrian
    Route::get('/kementrian', [KementrianController::class, 'index'])->name('kementrian');
    Route::post('/kementrian', [KementrianController::class, 'store'])->name('kementrian.store');
    Route::get('/kementrian/{id}', [KementrianController::class, 'show'])->name('kementrian.show');
    Route::delete('/kementrian/{id}', [KementrianController::class, 'destroy'])->name('kementrian.destroy');
    Route::get('/list_kementrian', [KementrianController::class, 'list'])->name('kementrian.list');

    // Dirjen
    Route::get('/dirjen', [DirjenController::class, 'index'])->name('dirjen');
    Route::post('/dirjen', [DirjenController::class, 'store'])->name('dirjen.store');
    Route::get('/dirjen/{id}', [DirjenController::class, 'show'])->name('dirjen.show');
    Route::delete('/dirjen/{id}', [DirjenController::class, 'destroy'])->name('dirjen.destroy');
    Route::get('/list_dirjen/{id}', [DirjenController::class, 'list'])->name('dirjen.list');

    // Program
    Route::get('/program', [ProgramController::class, 'index'])->name('program');
    Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
    Route::get('/program/{id}', [ProgramController::class, 'show'])->name('program.show');
    Route::delete('/program/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
    Route::get('/list_program', [ProgramController::class, 'list'])->name('program.list');

    // Kelompok Masyarakat
    Route::get('/kelompok_daftar', [KelompokController::class, 'index'])->name('kelompok_daftar');
    Route::post('/kelompok_daftar', [KelompokController::class, 'store'])->name('kelompok_daftar.store');
    Route::get('/kelompok_daftar/{id}', [KelompokController::class, 'show'])->name('kelompok_daftar.show');
    Route::delete('/kelompok_daftar/{id}', [KelompokController::class, 'destroy'])->name('kelompok_daftar.destroy');
    Route::get('/list_kelompok_daftar/{id}', [KelompokController::class, 'list'])->name('kelompok_daftar.list');

    // Kelompok Anggota
    Route::get('/kelompok_anggota', [AnggotaController::class, 'index'])->name('kelompok_anggota');
    // Route::get('/kelompok_anggota_utama', [AnggotaController::class, 'index'])->name('kelompok_anggota');
    Route::post('/kelompok_anggota', [AnggotaController::class, 'store'])->name('kelompok_anggota.store');
    Route::get('/kelompok_anggota_show/{id}', [AnggotaController::class, 'show'])->name('kelompok_anggota.show');
    Route::delete('/kelompok_anggota/{id}', [AnggotaController::class, 'destroy'])->name('kelompok_anggota.destroy');
    Route::get('/list_kelompok_anggota', [AnggotaController::class, 'list'])->name('kelompok_anggota.list');
    Route::post('/upload_data_anggota', [AnggotaController::class, 'previewDataExcel'])->name('kelompok_anggota.upload_data');
    Route::post('/upload_data_anggota_process', [AnggotaController::class, 'uploadDataExcel'])->name('kelompok_anggota.upload_data_process');

    // Jabatan
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::post('/jabatan', [JabatanController::class, 'store'])->name('jabatan.store');
    Route::get('/jabatan/{id}', [JabatanController::class, 'show'])->name('jabatan.show');
    Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
    Route::get('/list_jabatan', [JabatanController::class, 'list'])->name('jabatan.list');

    // Alokasi Program
    Route::get('/alokasi_program', [ProgramAlokasiController::class, 'index'])->name('alokasi_program');
    Route::post('/alokasi_program', [ProgramAlokasiController::class, 'store'])->name('alokasi_program.store');
    Route::get('/alokasi_program/{id}', [ProgramAlokasiController::class, 'show'])->name('alokasi_program.show');
    Route::delete('/alokasi_program/{id}', [ProgramAlokasiController::class, 'destroy'])->name('alokasi_program.destroy');
    Route::get('/list_alokasi_program', [ProgramAlokasiController::class, 'list'])->name('alokasi_program.list');

    // PIC
    Route::get('/pic', [PicController::class, 'index'])->name('pic');
    Route::post('/pic', [PicController::class, 'store'])->name('pic.store');
    Route::get('/pic/{id}', [PicController::class, 'show'])->name('pic.show');
    Route::delete('/pic/{id}', [PicController::class, 'destroy'])->name('pic.destroy');
    Route::get('/list_pic', [PicController::class, 'list'])->name('pic.list');

    // Proposal
    Route::get('/proposal', [ProposalController::class, 'index'])->name('proposal');
    Route::post('/proposal', [ProposalController::class, 'store'])->name('proposal.store');
    Route::get('/proposal/{id}', [ProposalController::class, 'show'])->name('proposal.show');
    Route::delete('/proposal/{id}', [ProposalController::class, 'destroy'])->name('proposal.destroy');
    Route::get('/list_proposal', [ProposalController::class, 'list'])->name('proposal.list');
    Route::get('/proposal_generate_excel/{id}', [ProposalController::class, 'downloadExcel'])->name('proposal.download_excel');


    Route::get('/view-file/{filename}', [FileController::class, 'viewFile'])->name('view.file');
    Route::get('/download-file/{filename}', [FileController::class, 'downloadFile'])->name('download.file');

    // Report Rekap Usulan Program
    Route::get('/report_rekap_usulan_program', [ReportRekapUsulanProgramController::class, 'index'])->name('report_rekap_usulan_program');
    Route::post('/report_rekap_usulan_program_view', [ReportRekapUsulanProgramController::class, 'viewReport'])->name('report_rekap_usulan_program_view');
});

Route::get('/send-email', function () {
    $data = [
        'name' => 'Sujiwo',
        'body' => 'Testing Kirim Email dari Laravel',
    ];

    Mail::to('massujiwo2288@gmail.com')->send(new SendEmail($data));

    dd('Email Berhasil dikirim.');
});
