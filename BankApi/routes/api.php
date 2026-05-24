<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespostaController;

// Autenticació
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// CRUD públic

Route::apiResource('categories', CategoriaController::class);
Route::apiResource('preguntes',  PreguntaController::class);
Route::apiResource('respostes',  RespostaController::class);

// Partides (creació i consulta pública)
Route::post('/partides',                          [PartidaController::class, 'store']);
Route::get('/partides/{id}',                      [PartidaController::class, 'show']);
Route::get('/partides/{id}/preguntes',            [PartidaController::class, 'getPreguntes']);
Route::post('/partides/{id}/puntuar',             [PartidaController::class, 'puntuar']);

// Estadístiques i rànquing (públics)
Route::get('/ranking',                            [PartidaController::class, 'ranking']);
Route::get('/estadistiques',                      [PartidaController::class, 'estadistiques']);

// Endpoints autenticats
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Partides per usuari autenticat
    Route::get('/partides',                           [PartidaController::class, 'index']);
    Route::post('/partides/{id}/respostes',           [PartidaController::class, 'guardarRespostes']);
});
