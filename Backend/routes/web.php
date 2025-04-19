<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;

Route::get('/generate-qrcode', [QrCodeController::class, 'generate']);
