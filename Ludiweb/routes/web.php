<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

// Pàgina d'inici amb llista d'endpoints
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autenticació
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Categories
Route::resource('categories', CategoriaController::class);

// Preguntes
Route::resource('preguntes', PreguntaController::class);

// Respostes
Route::get('/respostes',           [RespostaController::class, 'index'])->name('respostes.index');
Route::get('/respostes/create',    [RespostaController::class, 'create'])->name('respostes.create');
Route::post('/respostes',          [RespostaController::class, 'store'])->name('respostes.store');
Route::get('/respostes/{resposta}/edit',  [RespostaController::class, 'edit'])->name('respostes.edit');
Route::put('/respostes/{resposta}',       [RespostaController::class, 'update'])->name('respostes.update');
Route::delete('/respostes/{resposta}',    [RespostaController::class, 'destroy'])->name('respostes.destroy');

// Partides
Route::get('/partides/nova',              [PartidaController::class, 'nova'])->name('partides.nova');
Route::post('/partides',                  [PartidaController::class, 'store'])->name('partides.store');
Route::get('/partides/{id}/play',         [PartidaController::class, 'play'])->name('partides.play');
Route::post('/partides/{id}/puntuar',     [PartidaController::class, 'puntuar'])->name('partides.puntuar');
Route::get('/les-meves-partides',         [PartidaController::class, 'meuesPartides'])->name('partides.meues');

// Rànquing i Estadístiques
Route::get('/ranking',                    [StatsController::class, 'ranking'])->name('ranking');
Route::get('/estadistiques',              [StatsController::class, 'estadistiques'])->name('estadistiques');
