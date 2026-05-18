@extends('layout')
@section('title', 'Categories')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-indigo-700">Categories</h1>
    <a href="{{ route('categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">+ Nova categoria</a>
</div>

@if(empty($categories))
    <p class="text-gray-500">No hi ha categories. <a href="{{ route('categories.create') }}" class="text-indigo-600 underline">Crea la primera!</a></p>
@else
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">ID</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Nom</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Descripció</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Accions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">{{ $cat['id'] }}</td>
                <td class="px-4 py-3 font-medium">{{ $cat['nom'] }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $cat['descripcio'] ?? '—' }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('categories.show', $cat['id']) }}" class="text-blue-600 hover:underline">Veure</a>
                    <a href="{{ route('categories.edit', $cat['id']) }}" class="text-yellow-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('categories.destroy', $cat['id']) }}" onsubmit="return confirm('Eliminar categoria?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
