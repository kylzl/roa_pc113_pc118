<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AllowedRolesMiddleware;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware([AllowedRolesMiddleware::class, 'auth:sanctum'])->group(function () {
    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users', [UserController::class, 'read']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});

Route::get('/users', [UserController::class, 'read']);


