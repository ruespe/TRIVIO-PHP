@extends('layout')
@section('title', 'Nova resposta')
@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Nova resposta</h1>

    <form method="POST" action="{{ route('respostes.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Text <span class="text-red-500">*</span></label>
            <input type="text" name="text" value="{{ old('text') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pregunta <span class="text-red-500">*</span></label>
            <select name="pregunta_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Selecciona --</option>
                @foreach($preguntes as $p)
                    <option value="{{ $p['id'] }}" {{ (old('pregunta_id', $preguntaId) == $p['id']) ? 'selected' : '' }}>
                        #{{ $p['id'] }} — {{ $p['enunciat'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="es_correcta" id="es_correcta" value="1" {{ old('es_correcta') ? 'checked' : '' }}
                class="w-4 h-4 accent-green-600">
            <label for="es_correcta" class="text-sm font-medium text-gray-700">És la resposta correcta</label>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">Crear</button>
            <a href="{{ route('preguntes.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">Cancel·lar</a>
        </div>
    </form>
</div>
@endsection
