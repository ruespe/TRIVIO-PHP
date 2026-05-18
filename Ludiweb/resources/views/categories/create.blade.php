@extends('layout')
@section('title', 'Nova categoria')
@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Nova categoria</h1>

    <form method="POST" action="{{ route('categories.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="nom" value="{{ old('nom') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Descripció</label>
            <textarea name="descripcio" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('descripcio') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">Crear</button>
            <a href="{{ route('categories.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">Cancel·lar</a>
        </div>
    </form>
</div>
@endsection