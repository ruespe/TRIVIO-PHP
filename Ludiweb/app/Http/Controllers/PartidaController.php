<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class PartidaController extends Controller
{
    public function __construct(protected ApiService $api) {}

    // GET /partides/nova — formulari per iniciar una partida
    public function nova()
    {
        return view('partides.nova');
    }

    // POST /partides — crear partida i redirigir a joc
    public function store(Request $request)
    {
        $num = $request->integer('num_preguntes', 10);
        $response = $this->api->createPartida(['num_preguntes' => $num]);

        if ($response->successful()) {
            $partida = $response->json();
            return redirect()->route('partides.play', $partida['id']);
        }

        return back()->with('error', 'No s\'ha pogut crear la partida');
    }

    // GET /partides/{id}/play — mostrar preguntes
    public function play(int $id)
    {
        $pregResponse = $this->api->getPartidaPreguntes($id);
        $preguntes    = $pregResponse->successful() ? $pregResponse->json() : [];
        return view('partides.play', compact('id', 'preguntes'));
    }

    // POST /partides/{id}/puntuar — enviar respostes i obtenir puntuació
    public function puntuar(Request $request, int $id)
    {
        $respostes = [];
        foreach ($request->input('resposta', []) as $preguntaId => $respostaId) {
            $respostes[] = [
                'pregunta_id' => (int) $preguntaId,
                'resposta_id' => (int) $respostaId,
            ];
        }

        $response = $this->api->puntuarPartida($id, ['respostes' => $respostes]);
        $resultat = $response->successful() ? $response->json() : null;

        return view('partides.resultat', compact('resultat', 'id'));
    }

    // GET /les-meves-partides — partides de l'usuari autenticat
    public function meuesPartides()
    {
        $response = $this->api->getPartidesUsuari();
        $partides = $response->successful() ? $response->json() : [];
        return view('partides.meues', compact('partides'));
    }
}
