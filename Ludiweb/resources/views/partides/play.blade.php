@extends('layout')
@section('title', 'Jugar')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Partida #{{ $id }}</h1>

    @if(empty($preguntes))
    <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 rounded-xl p-6 text-center">
        <p class="font-semibold mb-2">No hi ha prou preguntes disponibles.</p>
        <p class="text-sm">Afegeix preguntes i respostes des del gestor abans de jugar.</p>
        <a href="{{ route('preguntes.create') }}" class="inline-block mt-4 bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Afegir preguntes</a>
    </div>
    @else
    <form method="POST" action="{{ route('partides.puntuar', $id) }}">
        @csrf
        <div class="space-y-6">
            @foreach($preguntes as $i => $pregunta)
            <div class="bg-white rounded-xl shadow p-5">
                <p class="font-semibold text-gray-800 mb-3">{{ $i + 1 }}. {{ $pregunta['enunciat'] }}</p>
                <div class="space-y-2">
                    @foreach($pregunta['respostes'] ?? [] as $r)
                    <label class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-indigo-50 transition">
                        <input type="radio" name="resposta[{{ $pregunta['id'] }}]" value="{{ $r['id'] }}" required
                            class="accent-indigo-600 w-4 h-4">
                        <span class="text-gray-700">{{ $r['text'] }}</span>
                    </label>
                    @endforeach
                    @if(empty($pregunta['respostes']))
                    <p class="text-xs text-gray-400 italic">Aquesta pregunta no té respostes definides.</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl text-lg font-semibold transition">
                Enviar respostes
            </button>
        </div>
    </form>
    @endif
</div>
@endsection