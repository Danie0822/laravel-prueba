<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usuarioController;
// Definir las rutas para el controlador de estudiantes
Route::get('/usuario', [usuarioController::class, 'index']);
Route::get('/usuario/{id}', [usuarioController::class, 'show']);
Route::post('/usuario', [usuarioController::class, 'store']);
Route::put('/usuario', [usuarioController::class, 'update']);
Route::delete('/usuario/{id}', [usuarioController::class, 'destroy']);
