<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\PartidaPregunta;
use App\Models\Pregunta;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartidaController extends Controller
{
    // GET /api/partides (auth: only own partides)
    public function index(Request $request)
    {
        if (Auth::check()) {
            $partides = Partida::where('user_id', Auth::id())
                ->with('preguntes')
                ->get();
        } else {
            $partides = Partida::all();
        }
        return response()->json($partides);
    }

    // POST /api/partides — crea una partida i assigna preguntes aleatòries
    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_preguntes' => 'nullable|integer|min:1|max:50',
        ]);

        $partida = Partida::create([
            'user_id'   => Auth::id(),
            'puntuacio' => null,
        ]);

        $numPreguntes = $validated['num_preguntes'] ?? 10;
        $preguntes = Pregunta::inRandomOrder()->limit($numPreguntes)->pluck('id');

        foreach ($preguntes as $preguntaId) {
            PartidaPregunta::create([
                'partida_id'  => $partida->id,
                'pregunta_id' => $preguntaId,
                'resposta_id' => null,
            ]);
        }

        return response()->json($partida->load('preguntes'), 201);
    }

    // GET /api/partides/{id} — detalls de la partida
    public function show(string $id)
    {
        $partida = Partida::with('preguntes')->findOrFail($id);
        return response()->json($partida);
    }

    // GET /api/partides/{id}/preguntes — preguntes amb opcions (sense revelar la correcta)
    public function getPreguntes(string $id)
    {
        $partida = Partida::findOrFail($id);

        $preguntes = $partida->preguntes()->with(['respostes' => function ($q) {
            $q->select('id', 'text', 'pregunta_id');
        }])->get();

        return response()->json($preguntes);
    }

    // POST /api/partides/{id}/respostes — desa les respostes (requereix auth)
    public function guardarRespostes(Request $request, string $id)
    {
        $partida = Partida::findOrFail($id);

        $validated = $request->validate([
            'respostes'               => 'required|array',
            'respostes.*.pregunta_id' => 'required|exists:preguntes,id',
            'respostes.*.resposta_id' => 'required|exists:respostes,id',
        ]);

        foreach ($validated['respostes'] as $item) {
            PartidaPregunta::where('partida_id', $partida->id)
                ->where('pregunta_id', $item['pregunta_id'])
                ->update(['resposta_id' => $item['resposta_id']]);
        }

        return response()->json(['message' => 'Respostes desades correctament']);
    }

    // POST /api/partides/{id}/puntuar — calcula i desa la puntuació
    public function puntuar(Request $request, string $id)
    {
        $partida = Partida::findOrFail($id);

        // Si s'envien respostes en la petició, les desem primer
        if ($request->has('respostes')) {
            $validated = $request->validate([
                'respostes'               => 'required|array',
                'respostes.*.pregunta_id' => 'required|exists:preguntes,id',
                'respostes.*.resposta_id' => 'required|exists:respostes,id',
            ]);

            foreach ($validated['respostes'] as $item) {
                PartidaPregunta::where('partida_id', $partida->id)
                    ->where('pregunta_id', $item['pregunta_id'])
                    ->update(['resposta_id' => $item['resposta_id']]);
            }
        }

        $partidaPreguntes = PartidaPregunta::where('partida_id', $partida->id)
            ->with('resposta')
            ->get();

        $correctes = $partidaPreguntes->filter(
            fn($pp) => $pp->resposta && $pp->resposta->es_correcta
        )->count();

        $total = $partidaPreguntes->count();
        $puntuacio = $total > 0 ? (int) round(($correctes / $total) * 100) : 0;

        $partida->update(['puntuacio' => $puntuacio]);

        return response()->json([
            'puntuacio'  => $puntuacio,
            'correctes'  => $correctes,
            'total'      => $total,
        ]);
    }

    public function create() {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
