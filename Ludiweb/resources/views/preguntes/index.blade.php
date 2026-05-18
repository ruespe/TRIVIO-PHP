@extends('layout')
@section('title', 'Preguntes')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-indigo-700">Preguntes</h1>
    <a href="{{ route('preguntes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">+ Nova pregunta</a>
</div>

@if(empty($preguntes))
    <p class="text-gray-500">No hi ha preguntes. <a href="{{ route('preguntes.create') }}" class="text-indigo-600 underline">Crea la primera!</a></p>
@else
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">ID</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Enunciat</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Dificultat</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Categoria</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Accions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($preguntes as $p)
            @php
                $dif = $p['dificultat'] ?? '';
                $difColor = match($dif) {
                    'Fàcil'   => 'bg-green-100 text-green-700',
                    'Mitja'   => 'bg-yellow-100 text-yellow-700',
                    'Difícil' => 'bg-red-100 text-red-700',
                    default   => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">{{ $p['id'] }}</td>
                <td class="px-4 py-3 font-medium">{{ $p['enunciat'] }}</td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 rounded text-xs {{ $difColor }}">{{ $dif }}</span></td>
                <td class="px-4 py-3 text-gray-500">{{ $p['categoria_id'] ?? '—' }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('preguntes.show', $p['id']) }}" class="text-blue-600 hover:underline">Veure</a>
                    <a href="{{ route('preguntes.edit', $p['id']) }}" class="text-yellow-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('preguntes.destroy', $p['id']) }}" onsubmit="return confirm('Eliminar pregunta i totes les seves respostes?')">
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
