<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;
class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preguntes = Pregunta::all();
        return response()->json($preguntes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pregunta = Pregunta::create($request->all());
        return response()->json($pregunta, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        return response()->json($pregunta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->update($request->all());
        return response()->json($pregunta, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->delete();
        return response()->json([
            'message' => 'Pregunta eliminada correctament '
        ], 200);
    }
}
