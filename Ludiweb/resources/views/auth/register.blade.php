@extends('layout')
@section('title', 'Registrar-se')
@section('content')
<div class="max-w-sm mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6 text-center">Crear compte</h1>

    <form method="POST" action="{{ route('register') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contrasenya (mínim 8 caràcters)</label>
            <input type="password" name="password" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirma contrasenya</label>
            <input type="password" name="password_confirmation" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-medium">
            Crear compte
        </button>
        <p class="text-center text-sm text-gray-500">
            Ja tens compte?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Inicia sessió</a>
        </p>
    </form>
</div>
@endsection
