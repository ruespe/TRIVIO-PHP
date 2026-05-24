@extends('layout')
@section('title', 'Rànquing global')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Rànquing global de jugadors</h1>

    @if(empty($ranking))
    <div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
        <p class="text-lg">Encara no hi ha partides finalitzades.</p>
        <a href="{{ route('partides.nova') }}" class="inline-block mt-4 bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Jugar ara</a>
    </div>
    @else
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold w-12">#</th>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold">Jugador</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold">Millor</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold">Mitjana</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold">Partides</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($ranking as $i => $jugador)
                @php
                    $pos = $i + 1;
                    $rowClass = match($pos) {
                        1 => 'bg-yellow-50',
                        2 => 'bg-gray-50',
                        3 => 'bg-orange-50',
                        default => ''
                    };
                    $badgeClass = match($pos) {
                        1 => 'bg-yellow-400 text-yellow-900',
                        2 => 'bg-gray-300 text-gray-700',
                        3 => 'bg-orange-300 text-orange-900',
                        default => 'bg-indigo-100 text-indigo-700'
                    };
                @endphp
                <tr class="hover:bg-indigo-50 transition {{ $rowClass }}">
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold {{ $badgeClass }}">
                            {{ $pos }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $jugador['name'] }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-bold text-indigo-700">{{ $jugador['millor_puntuacio'] }}%</span>
                    </td>
                    <td class="px-4 py-3 text-center text-gray-500">{{ $jugador['avg_puntuacio'] }}%</td>
                    <td class="px-4 py-3 text-center text-gray-500">{{ $jugador['total_partides'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('partides.nova') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg inline-block">Jugar ara</a>
    </div>
</div>
@endsection
