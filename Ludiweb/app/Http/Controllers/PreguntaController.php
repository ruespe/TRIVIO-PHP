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
            return redirect()->route('preguntes.index')
                ->with('success', 'Pregunta creada correctament');
        }

        $catResponse = $this->api->getCategories();
        $categories  = $catResponse->successful() ? $catResponse->json() : [];
        return back()->withErrors($response->json('errors', []))->withInput()
            ->with(compact('categories'));
    }

    public function show(int $id)
    {
        $response  = $this->api->getPregunta($id);
        $pregunta  = $response->successful() ? $response->json() : null;

        $resResponse = $this->api->getRespostes();
        $totes       = $resResponse->successful() ? $resResponse->json() : [];
        $respostes   = array_filter($totes, fn($r) => ($r['pregunta_id'] ?? null) == $id);

        return view('preguntes.show', compact('pregunta', 'respostes'));
    }

    public function edit(int $id)
    {
        $response    = $this->api->getPregunta($id);
        $pregunta    = $response->successful() ? $response->json() : null;

        $catResponse = $this->api->getCategories();
        $categories  = $catResponse->successful() ? $catResponse->json() : [];

        return view('preguntes.edit', compact('pregunta', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $response = $this->api->updatePregunta(
            $id,
            $request->only('enunciat', 'dificultat', 'categoria_id')
        );

        if ($response->successful()) {
            return redirect()->route('preguntes.index')
                ->with('success', 'Pregunta actualitzada correctament');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function destroy(int $id)
    {
        $this->api->deletePregunta($id);
        return redirect()->route('preguntes.index')
            ->with('success', 'Pregunta eliminada correctament');
    }
}
