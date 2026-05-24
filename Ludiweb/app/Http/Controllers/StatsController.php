<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class StatsController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function ranking()
    {
        $response = $this->api->getRanking();
        $ranking  = $response->successful() ? $response->json() : [];
        return view('ranking.index', compact('ranking'));
    }

    public function estadistiques()
    {
        $response = $this->api->getEstadistiques();
        $stats    = $response->successful() ? $response->json() : null;
        return view('estadistiques.index', compact('stats'));
    }
}
