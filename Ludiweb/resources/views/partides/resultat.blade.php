@extends('layout')
@section('title', 'Resultat')
@section('content')
<div class="max-w-md mx-auto text-center">
    <div class="text-6xl mb-4"></div>

    @if($resultat)
    <h1 class="text-3xl font-bold text-indigo-700 mb-2">Resultat de la partida #{{ $id }}</h1>

    <div class="bg-white rounded-2xl shadow p-8 my-6">
        <div class="text-6xl font-bold text-indigo-600 mb-2">{{ $resultat['puntuacio'] }}%</div>
        <div class="text-gray-500">
            {{ $resultat['correctes'] }} de {{ $resultat['total'] }} respostes correctes
        </div>

        <div class="mt-6 w-full bg-gray-200 rounded-full h-4">
            <div class="bg-indigo-500 h-4 rounded-full transition-all"
                style="width: {{ $resultat['puntuacio'] }}%"></div>
        </div>
    </div>

    <div class="flex gap-4 justify-center mt-4">
        <a href="{{ route('partides.nova') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold">Jugar de nou</a>
        <a href="{{ route('home') }}" class="border border-gray-300 text-gray-600 hover:bg-gray-50 px-6 py-3 rounded-xl">Inici</a>
    </div>
    @else
    <h1 class="text-2xl font-bold text-red-500 mb-4">Error en calcular la puntuació</h1>
    <a href="{{ route('partides.nova') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl">Tornar a jugar</a>
    @endif
</div>
@endsection