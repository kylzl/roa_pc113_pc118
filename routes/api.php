<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/employees', [Controller::class, 'ShowEmployees']);
