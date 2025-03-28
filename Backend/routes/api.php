<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-info', [UserController::class, 'getUserInfo']);

    Route::get('/employee', [EmployeeController::class, 'show']);
    Route::post('/employee', [EmployeeController::class, 'create']);
    Route::put('/employee/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employee/{id}', [EmployeeController::class, 'delete']);
}); 

Route::middleware(['auth:sanctum','role:admin'])->group(function(){    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});




