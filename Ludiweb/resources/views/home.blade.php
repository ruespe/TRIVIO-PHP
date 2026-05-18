@extends('layout')

@section('title', 'Inici - Ludiweb')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-indigo-700 mb-2">BankApi REST &mdash; Endpoints disponibles</h1>
    <p class="text-gray-600">Aplicació web client que consumeix la BankApi. A continuació trobaràs tots els endpoints de l'API.</p>
</div>

<div class="grid grid-cols-1 gap-3">
    @php
    $methodColors = [
    'GET' => 'bg-blue-100 text-blue-800',
    'POST' => 'bg-green-100 text-green-800',
    'PUT' => 'bg-yellow-100 text-yellow-800',
    'DELETE' => 'bg-red-100 text-red-800',
    ];
    @endphp

    @foreach($endpoints as $ep)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex items-center gap-4 px-5 py-3">
        <span class="font-mono font-bold text-xs px-2 py-1 rounded {{ $methodColors[$ep['method']] ?? 'bg-gray-100 text-gray-700' }} min-w-[64px] text-center">
            {{ $ep['method'] }}
        </span>
        <code class="text-sm text-gray-700 font-mono flex-1">{{ $ep['url'] }}</code>
        <span class="text-gray-500 text-sm">{{ $ep['desc'] }}</span>
    </div>
    @endforeach
</div>

<div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="{{ route('categories.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-5 text-center shadow transition">
        <div class="text-2xl mb-2">📂</div>
        <div class="font-semibold">Categories</div>
    </a>
    <a href="{{ route('preguntes.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-5 text-center shadow transition">
        <div class="text-2xl mb-2">❓</div>
        <div class="font-semibold">Preguntes</div>
    </a>
    <a href="{{ route('respostes.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-5 text-center shadow transition">
        <div class="text-2xl mb-2">✅</div>
        <div class="font-semibold">Respostes</div>
    </a>
    <a href="{{ route('partides.nova') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-5 text-center shadow transition">
        <div class="text-2xl mb-2">🎮</div>
        <div class="font-semibold">Jugar!</div>
    </a>
</div>
@endsection