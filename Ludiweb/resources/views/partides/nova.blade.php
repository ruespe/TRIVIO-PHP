@extends('layout')
@section('title', 'Jugar - Nova partida')
@section('content')
<div class="max-w-md mx-auto text-center">
    <div class="text-6xl mb-4">🎮</div>
    <h1 class="text-3xl font-bold text-indigo-700 mb-2">Nova Partida</h1>
    <p class="text-gray-500 mb-8">Tria el nombre de preguntes i comença a jugar!</p>

    <form method="POST" action="{{ route('partides.store') }}" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf
        <div class="text-left">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de preguntes</label>
            <select name="num_preguntes"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @foreach([5, 10, 15, 20] as $n)
                <option value="{{ $n }}" {{ $n == 10 ? 'selected' : '' }}>{{ $n }} preguntes</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl text-lg font-semibold transition">
            Començar partida
        </button>
    </form>

    @if(session('api_token'))
    <p class="mt-4 text-sm text-gray-400">Les teves respostes es guardaran i podràs veure les teves partides.</p>
    @else
    <p class="mt-4 text-sm text-gray-400">
        <a href="{{ route('login') }}" class="text-indigo-600 underline">Inicia sessió</a> per guardar les teves partides i puntuacions.
    </p>
    @endif
</div>
@endsection