<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class RespostaController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index()
    {
        $response  = $this->api->getRespostes();
        $respostes = $response->successful() ? $response->json() : [];
        return view('respostes.index', compact('respostes'));
    }

    public function create(Request $request)
    {
        $preguntaId  = $request->query('pregunta_id');
        $pregResponse = $this->api->getPreguntes();
        $preguntes   = $pregResponse->successful() ? $pregResponse->json() : [];
        return view('respostes.create', compact('preguntes', 'preguntaId'));
    }

    public function store(Request $request)
    {
        $data = $request->only('text', 'pregunta_id');
        $data['es_correcta'] = $request->boolean('es_correcta');

        $response = $this->api->createResposta($data);

        if ($response->successful()) {
            $preguntaId = $request->input('pregunta_id');
            return redirect()->route('preguntes.show', $preguntaId)
                ->with('success', 'Resposta creada correctament');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function edit(int $id)
    {
        $response  = $this->api->getResposta($id);
        $resposta  = $response->successful() ? $response->json() : null;

        $pregResponse = $this->api->getPreguntes();
        $preguntes   = $pregResponse->successful() ? $pregResponse->json() : [];

        return view('respostes.edit', compact('resposta', 'preguntes'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->only('text', 'pregunta_id');
        $data['es_correcta'] = $request->boolean('es_correcta');

        $response = $this->api->updateResposta($id, $data);

        if ($response->successful()) {
            $preguntaId = $request->input('pregunta_id');
            return redirect()->route('preguntes.show', $preguntaId)
                ->with('success', 'Resposta actualitzada correctament');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function destroy(int $id, Request $request)
    {
        $preguntaId = $request->query('pregunta_id');
        $this->api->deleteResposta($id);

        if ($preguntaId) {
            return redirect()->route('preguntes.show', $preguntaId)
                ->with('success', 'Resposta eliminada correctament');
        }

        return redirect()->route('respostes.index')
            ->with('success', 'Resposta eliminada correctament');
    }
}
