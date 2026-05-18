@extends('layout')
@section('title', 'Categoria')
@section('content')
@if($categoria)
<div class="max-w-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-indigo-700">{{ $categoria['nom'] }}</h1>
        <span class="text-gray-400 text-sm">#{{ $categoria['id'] }}</span>
    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <div>
            <span class="text-xs text-gray-400 uppercase">Descripció</span>
            <p class="mt-1 text-gray-700">{{ $categoria['descripcio'] ?? 'Sense descripció' }}</p>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('categories.edit', $categoria['id']) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Editar</a>
            <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm">Tornar</a>
        </div>
    </div>
</div>
@else
<p class="text-red-500">Categoria no trobada.</p>
@endif
@endsection