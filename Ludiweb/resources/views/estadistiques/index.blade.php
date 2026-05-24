@extends('layout')
@section('title', 'Estadístiques')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Estadístiques de joc</h1>

    @if(!$stats)
    <div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
        <p>No s'han pogut carregar les estadístiques.</p>
    </div>
    @else

    <!-- Cards principals -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['total_partides'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Partides jugades</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['avg_puntuacio'] }}%</div>
            <div class="text-sm text-gray-500 mt-1">Puntuació mitjana</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_jugadors'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Jugadors únics</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-indigo-500">{{ $stats['total_preguntes'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Preguntes al banc</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center col-span-2 md:col-span-1">
            <div class="text-3xl font-bold text-gray-600">{{ $stats['total_respostes'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Respostes al banc</div>
        </div>
    </div>

    <!-- Per dificultat -->
    @if(!empty($stats['per_dificultat']))
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Respostes per dificultat</h2>
        @php
            $total = array_sum($stats['per_dificultat']);
            $colors = ['Fàcil' => 'bg-green-500', 'Mitja' => 'bg-yellow-500', 'Difícil' => 'bg-red-500'];
            $textColors = ['Fàcil' => 'text-green-700', 'Mitja' => 'text-yellow-700', 'Difícil' => 'text-red-700'];
        @endphp
        <div class="space-y-3">
            @foreach(['Fàcil', 'Mitja', 'Difícil'] as $dif)
            @php
                $count = $stats['per_dificultat'][$dif] ?? 0;
                $pct   = $total > 0 ? round(($count / $total) * 100) : 0;
            @endphp
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium {{ $textColors[$dif] ?? 'text-gray-700' }}">{{ $dif }}</span>
                    <span class="text-gray-500">{{ $count }} ({{ $pct }}%)</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3">
                    <div class="{{ $colors[$dif] ?? 'bg-indigo-500' }} h-3 rounded-full transition-all"
                        style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @endif

    <div class="mt-6 flex gap-3 justify-center">
        <a href="{{ route('ranking') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">Veure rànquing</a>
        <a href="{{ route('partides.nova') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">Jugar ara</a>
    </div>
</div>
@endsection
