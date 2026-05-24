@extends('layout')
@section('title', 'Les meves partides')
@section('content')
<h1 class="text-2xl font-bold text-indigo-700 mb-6">Les meves partides</h1>

@if(empty($partides))
<div class="text-center py-12 text-gray-400">
    <div class="text-4xl mb-3"></div>
    <p>Encara no has jugat cap partida.</p>
    <a href="{{ route('partides.nova') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Jugar ara</a>
</div>
@else
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">ID</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Puntuació</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Data</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($partides as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">#{{ $p['id'] }}</td>
                <td class="px-4 py-3 font-semibold text-indigo-700">
                    {{ $p['puntuacio'] !== null ? $p['puntuacio'] . '%' : '—' }}
                </td>
                <td class="px-4 py-3 text-gray-500">
                    {{ isset($p['created_at']) ? \Carbon\Carbon::parse($p['created_at'])->format('d/m/Y H:i') : '' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection