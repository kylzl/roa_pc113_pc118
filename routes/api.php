<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/employees/search', [EmployeeController::class, 'search']);
Route::get('/employees', [EmployeeController::class, 'read']);
Route::post('/employees', [EmployeeController::class, 'create']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees{id}', [EmployeeController::class, 'delete']);

Route::get('/students/search', [StudentController::class, 'search']);
Route::get('/students', [StudentController::class, 'read']);
Route::post('/students', [StudentController::class, 'create']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'delete']);
