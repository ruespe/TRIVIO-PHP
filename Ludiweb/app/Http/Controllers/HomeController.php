<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index()
    {
        $endpoints = [
            ['method' => 'POST', 'url' => '/api/register',              'desc' => 'Registrar nou usuari'],
            ['method' => 'POST', 'url' => '/api/login',                 'desc' => 'Iniciar sessió'],
            ['method' => 'POST', 'url' => '/api/logout',                'desc' => 'Tancar sessió (auth)'],
            ['method' => 'GET',  'url' => '/api/me',                    'desc' => 'Dades usuari autenticat'],
            ['method' => 'GET',  'url' => '/api/categories',            'desc' => 'Llistar categories'],
            ['method' => 'POST', 'url' => '/api/categories',            'desc' => 'Crear categoria'],
            ['method' => 'GET',  'url' => '/api/categories/{id}',       'desc' => 'Consultar categoria'],
            ['method' => 'PUT',  'url' => '/api/categories/{id}',       'desc' => 'Actualitzar categoria'],
            ['method' => 'DELETE','url'=> '/api/categories/{id}',       'desc' => 'Eliminar categoria'],
            ['method' => 'GET',  'url' => '/api/preguntes',             'desc' => 'Llistar preguntes'],
            ['method' => 'POST', 'url' => '/api/preguntes',             'desc' => 'Crear pregunta'],
            ['method' => 'GET',  'url' => '/api/preguntes/{id}',        'desc' => 'Consultar pregunta'],
            ['method' => 'PUT',  'url' => '/api/preguntes/{id}',        'desc' => 'Actualitzar pregunta'],
            ['method' => 'DELETE','url'=> '/api/preguntes/{id}',        'desc' => 'Eliminar pregunta'],
            ['method' => 'GET',  'url' => '/api/respostes',             'desc' => 'Llistar respostes'],
            ['method' => 'POST', 'url' => '/api/respostes',             'desc' => 'Crear resposta'],
            ['method' => 'GET',  'url' => '/api/respostes/{id}',        'desc' => 'Consultar resposta'],
            ['method' => 'PUT',  'url' => '/api/respostes/{id}',        'desc' => 'Actualitzar resposta'],
            ['method' => 'DELETE','url'=> '/api/respostes/{id}',        'desc' => 'Eliminar resposta'],
            ['method' => 'POST', 'url' => '/api/partides',              'desc' => 'Crear partida'],
            ['method' => 'GET',  'url' => '/api/partides/{id}',         'desc' => 'Consultar partida'],
            ['method' => 'GET',  'url' => '/api/partides/{id}/preguntes','desc' => 'Obtenir preguntes de la partida'],
            ['method' => 'POST', 'url' => '/api/partides/{id}/puntuar', 'desc' => 'Puntuar partida'],
            ['method' => 'GET',  'url' => '/api/partides',              'desc' => 'Partides de l\'usuari (auth)'],
            ['method' => 'POST', 'url' => '/api/partides/{id}/respostes','desc' => 'Guardar respostes (auth)'],
        ];

        return view('home', compact('endpoints'));
    }
}
