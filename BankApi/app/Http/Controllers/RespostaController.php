<?php

namespace App\Http\Controllers;

use App\Models\Resposta;
use Illuminate\Http\Request;

class RespostaController extends Controller
{
    public function index()
    {
        return response()->json(Resposta::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text'        => 'required|string|max:255',
            'es_correcta' => 'required|boolean',
            'pregunta_id' => 'required|exists:preguntes,id',
        ]);

        if (Resposta::where('pregunta_id', $validated['pregunta_id'])->count() >= 3) {
            return response()->json([
                'message' => 'Una pregunta només pot tenir un màxim de 3 respostes.',
                'errors'  => ['pregunta_id' => ['Límit de 3 respostes per pregunta assolit.']],
            ], 422);
        }

        $resposta = Resposta::create($validated);
        return response()->json($resposta, 201);
    }

    public function show(string $id)
    {
        return response()->json(Resposta::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $resposta = Resposta::findOrFail($id);

        $validated = $request->validate([
            'text'        => 'sometimes|required|string|max:255',
            'es_correcta' => 'sometimes|required|boolean',
            'pregunta_id' => 'sometimes|required|exists:preguntes,id',
        ]);

        $resposta->update($validated);
        return response()->json($resposta);
    }

    public function destroy(string $id)
    {
        Resposta::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
