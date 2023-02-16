<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('students', [StudentController::class, 'index']);
Route::post('students', [StudentController::class, 'store']);
Route::get('students/{id}', [StudentController::class, 'edit']);
Route::put('update-student/{id}', [StudentController::class, 'update']);
Route::delete('student/{id}', [StudentController::class, 'delete']);
Route::get('fetch-students', [StudentController::class, 'fetch']);

Route::get('/', function () {
    return view('welcome');
});
