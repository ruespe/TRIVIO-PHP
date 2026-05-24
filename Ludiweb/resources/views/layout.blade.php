<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ludiweb - BankApi Client')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide">Ludiweb</a>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('categories.index') }}" class="hover:underline">Categories</a>
                <a href="{{ route('preguntes.index') }}" class="hover:underline">Preguntes</a>
                <a href="{{ route('respostes.index') }}" class="hover:underline">Respostes</a>
                <a href="{{ route('partides.nova') }}" class="hover:underline">Jugar</a>
                <a href="{{ route('ranking') }}" class="hover:underline">Rànquing</a>
                <a href="{{ route('estadistiques') }}" class="hover:underline">Estadístiques</a>
                @if(session('api_token'))
                <a href="{{ route('partides.meues') }}" class="hover:underline">Les meves partides</a>
                <span class="text-indigo-200">{{ session('api_user.name', 'Usuari') }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">Tancar sessió</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="hover:underline">Entrar</a>
                <a href="{{ route('register') }}" class="bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">Registrar-se</a>
                @endif
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-xs text-gray-400 py-6">
        Ludiweb &mdash; Client de BankApi REST
    </footer>

    @stack('scripts')
</body>

</html>