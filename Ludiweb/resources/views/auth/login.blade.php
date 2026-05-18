@extends('layout')
@section('title', 'Iniciar sessió')
@section('content')
<div class="max-w-sm mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6 text-center">Iniciar sessió</h1>

    <form method="POST" action="{{ route('login') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contrasenya</label>
            <input type="password" name="password" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-medium">
            Entrar
        </button>
        <p class="text-center text-sm text-gray-500">
            No tens compte?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Registra't</a>
        </p>
    </form>
</div>
@endsection