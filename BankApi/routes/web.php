<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PreguntaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoriaController::class);
Route::resource('preguntes', PreguntaController::class);