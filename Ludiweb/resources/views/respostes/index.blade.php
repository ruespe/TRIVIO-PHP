@extends('layout')
@section('title', 'Respostes')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-indigo-700">Respostes</h1>
    <a href="{{ route('respostes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">+ Nova resposta</a>
</div>

@if(empty($respostes))
    <p class="text-gray-500">No hi ha respostes.</p>
@else
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">ID</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Text</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Correcta</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Pregunta</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Accions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($respostes as $r)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">{{ $r['id'] }}</td>
                <td class="px-4 py-3">{{ $r['text'] }}</td>
                <td class="px-4 py-3">
                    @if($r['es_correcta'])
                        <span class="text-green-600 font-semibold">✓ Sí</span>
                    @else
                        <span class="text-gray-400">No</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-500">
                    @if(isset($r['pregunta']))
                        <a href="{{ route('preguntes.show', $r['pregunta']['id']) }}" class="text-indigo-600 hover:underline">
                            {{ Str::limit($r['pregunta']['enunciat'], 40) }}
                        </a>
                    @else
                        #{{ $r['pregunta_id'] }}
                    @endif
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('respostes.edit', $r['id']) }}" class="text-yellow-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('respostes.destroy', ['resposta' => $r['id'], 'pregunta_id' => $r['pregunta_id']]) }}" onsubmit="return confirm('Eliminar resposta?')">
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
