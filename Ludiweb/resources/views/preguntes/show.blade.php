@extends('layout')
@section('title', 'Pregunta')
@section('content')
@if($pregunta)
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-indigo-700">{{ $pregunta['enunciat'] }}</h1>
        <span class="text-gray-400 text-sm">#{{ $pregunta['id'] }}</span>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-6 space-y-3">
        <div><span class="text-xs text-gray-400 uppercase">Dificultat</span>
            <p class="font-medium">{{ $pregunta['dificultat'] }}</p>
        </div>
        <div><span class="text-xs text-gray-400 uppercase">Categoria ID</span>
            <p class="font-medium">{{ $pregunta['categoria_id'] ?? '—' }}</p>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('preguntes.edit', $pregunta['id']) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Editar</a>
            <a href="{{ route('preguntes.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm">Tornar</a>
        </div>
    </div>

    <div class="flex items-center justify-between mb-3">
        <h2 class="text-lg font-semibold text-gray-700">Respostes ({{ count($respostes) }}/3)</h2>
        @if(count($respostes) < 3)
        <a href="{{ route('respostes.create', ['pregunta_id' => $pregunta['id']]) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm">+ Afegir resposta</a>
        @endif
    </div>

    @if(empty($respostes))
        <p class="text-gray-400 text-sm">Sense respostes. Afegeix-ne fins a 3.</p>
    @else
    <div class="space-y-2">
        @foreach($respostes as $r)
        <div class="bg-white rounded-lg border {{ $r['es_correcta'] ? 'border-green-400' : 'border-gray-200' }} px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($r['es_correcta'])
                    <span class="text-green-500 font-bold">✓</span>
                @else
                    <span class="text-gray-300">○</span>
                @endif
                <span class="text-gray-800">{{ $r['text'] }}</span>
            </div>
            <div class="flex gap-2 text-sm">
                <a href="{{ route('respostes.edit', $r['id']) }}" class="text-yellow-600 hover:underline">Editar</a>
                <form method="POST" action="{{ route('respostes.destroy', ['resposta' => $r['id'], 'pregunta_id' => $pregunta['id']]) }}" onsubmit="return confirm('Eliminar resposta?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@else
<p class="text-red-500">Pregunta no trobada.</p>
@endif
@endsection
