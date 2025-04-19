<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/students/upload-csv', [StudentController::class, 'uploadCsv']);


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-info', [UserController::class, 'getUserInfo']);

    Route::get('/students', [StudentController::class, 'show']);
    Route::post('/student', [StudentController::class, 'create']);
    Route::put('/student/{id}', [StudentController::class, 'update']);
    Route::delete('/student/{id}', [StudentController::class, 'delete']);
}); 

Route::middleware(['auth:sanctum','role:admin'])->group(function(){    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users', [UserController::class, 'show']);
    Route::get('/users/search', [UserController::class, 'search']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/update-user/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});




