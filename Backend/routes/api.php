<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','role:admin'])->group(function(){    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users', [UserController::class, 'read']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::post('/logout', action: [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum','role:employee'])->group(function(){
    Route::post('/logout', action: [AuthController::class, 'logout']);

});



