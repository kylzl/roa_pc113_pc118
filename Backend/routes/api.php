<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-info', [UserController::class, 'getUserInfo']);

}); 


Route::middleware(['auth:sanctum','role:admin'])->group(function(){    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});




