<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesanWAController;

Route::post('/webhook/whatsapp', [PesanWAController::class, 'receiveWA']);
?>