<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index()
    {
        $response  = $this->api->getPreguntes();
        $preguntes = $response->successful() ? $response->json() : [];
        return view('preguntes.index', compact('preguntes'));
    }

    public function create()
    {
        $catResponse = $this->api->getCategories();
        $categories  = $catResponse->successful() ? $catResponse->json() : [];
        return view('preguntes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $response = $this->api->createPregunta(
            $request->only('enunciat', 'dificultat', 'categoria_id')
        );

        if ($response->successful()) {
            $preguntaId   = $response->json('id');
            $correctaIdx  = $request->input('correcta', '');

            foreach ($request->input('respostes', []) as $i => $res) {
                if (!empty(trim($res['text'] ?? ''))) {
                    $this->api->createResposta([
                        'text'        => $res['text'],
                        'es_correcta' => ((string)$i === (string)$correctaIdx),
                        'pregunta_id' => $preguntaId,
                    ]);
                }
            }

            return redirect()->route('preguntes.index')
                ->with('success', 'Pregunta creada correctament');
        }

        $catResponse = $this->api->getCategories();
        $categories  = $catResponse->successful() ? $catResponse->json() : [];
        return back()->withErrors($response->json('errors', []))->withInput()
            ->with(compact('categories'));
    }

    public function show(int $pregunta)
    {
        $response  = $this->api->getPregunta($pregunta);
        $preguntaData  = $response->successful() ? $response->json() : null;

        $resResponse = $this->api->getRespostes();
        $totes       = $resResponse->successful() ? $resResponse->json() : [];
        $respostes   = array_filter($totes, fn($r) => ($r['pregunta_id'] ?? null) == $pregunta);

        return view('preguntes.show', ['pregunta' => $preguntaData, 'respostes' => $respostes]);
    }

    public function edit(int $pregunta)
    {
        $response    = $this->api->getPregunta($pregunta);
        $preguntaData    = $response->successful() ? $response->json() : null;

        $catResponse = $this->api->getCategories();
        $categories  = $catResponse->successful() ? $catResponse->json() : [];

        $resResponse = $this->api->getRespostes();
        $totes       = $resResponse->successful() ? $resResponse->json() : [];
        $respostes   = array_values(array_filter($totes, fn($r) => ($r['pregunta_id'] ?? null) == $pregunta));

        return view('preguntes.edit', ['pregunta' => $preguntaData, 'categories' => $categories, 'respostes' => $respostes]);
    }

    public function update(Request $request, int $pregunta)
    {
        $response = $this->api->updatePregunta(
            $pregunta,
            $request->only('enunciat', 'dificultat', 'categoria_id')
        );

        if ($response->successful()) {
            $correcta = $request->input('correcta', '');

            // Delete respostes marcades per eliminar
            foreach ($request->input('respostes_eliminar', []) as $id) {
                $this->api->deleteResposta((int)$id);
            }

            // Actualitzar respostes existents (les que no s'han eliminat)
            foreach ($request->input('respostes_existents', []) as $id => $res) {
                $this->api->updateResposta((int)$id, [
                    'text'        => $res['text'] ?? '',
                    'es_correcta' => ($correcta === "e_{$id}"),
                    'pregunta_id' => $pregunta,
                ]);
            }

            // Crear respostes noves
            foreach ($request->input('respostes_noves', []) as $i => $res) {
                if (!empty(trim($res['text'] ?? ''))) {
                    $this->api->createResposta([
                        'text'        => $res['text'],
                        'es_correcta' => ($correcta === "n_{$i}"),
                        'pregunta_id' => $pregunta,
                    ]);
                }
            }

            return redirect()->route('preguntes.show', $pregunta)
                ->with('success', 'Pregunta actualitzada correctament');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function destroy(int $pregunta)
    {
        $this->api->deletePregunta($pregunta);
        return redirect()->route('preguntes.index')
            ->with('success', 'Pregunta eliminada correctament');
    }
}
