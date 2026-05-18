@extends('layout')
@section('title', 'Editar pregunta')
@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Editar pregunta #{{ $pregunta['id'] }}</h1>

    <form method="POST" action="{{ route('preguntes.update', $pregunta['id']) }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Enunciat <span class="text-red-500">*</span></label>
            <input type="text" name="enunciat" value="{{ old('enunciat', $pregunta['enunciat']) }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dificultat <span class="text-red-500">*</span></label>
            <select name="dificultat" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @foreach(['Fàcil', 'Mitja', 'Difícil'] as $d)
                    <option value="{{ $d }}" {{ old('dificultat', $pregunta['dificultat']) == $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-red-500">*</span></label>
            <select name="categoria_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @foreach($categories as $cat)
                    <option value="{{ $cat['id'] }}" {{ old('categoria_id', $pregunta['categoria_id']) == $cat['id'] ? 'selected' : '' }}>{{ $cat['nom'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">Actualitzar</button>
            <a href="{{ route('preguntes.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">Cancel·lar</a>
        </div>
    </form>
</div>
@endsection
