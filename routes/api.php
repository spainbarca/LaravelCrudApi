<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Models\Student;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/students', [StudentController::class, 'index']); 

Route::get('/students/{id}', function () {
    return 'Obteniendo un estudiante';
});

Route::post('/students', function () {
    return 'Creando estudiantes'; 
});

Route::put('/students/{id}', function () {
    return 'Actualizando estudiante';
});

Route::delete('/students/{id}', function () { 
    return 'Eliminando estudiante';
});