@extends('layout')
@section('title', 'Nova pregunta')
@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Nova pregunta</h1>

    <form method="POST" action="{{ route('preguntes.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Enunciat <span class="text-red-500">*</span></label>
            <input type="text" name="enunciat" value="{{ old('enunciat') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dificultat <span class="text-red-500">*</span></label>
            <select name="dificultat" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Selecciona --</option>
                @foreach(['Fàcil', 'Mitja', 'Difícil'] as $d)
                <option value="{{ $d }}" {{ old('dificultat') == $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-red-500">*</span></label>
            <select name="categoria_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Selecciona --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat['id'] }}" {{ old('categoria_id') == $cat['id'] ? 'selected' : '' }}>{{ $cat['nom'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Respostes (màxim 3) -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium text-gray-700">Respostes</label>
                <div class="flex items-center gap-2">
                    <span id="answer-count" class="text-xs text-gray-400">3/3</span>
                    <button type="button" id="add-btn" disabled
                        class="text-sm text-gray-400 font-medium cursor-not-allowed">+ Afegir</button>
                </div>
            </div>
            <p class="text-xs text-gray-400 mb-2">Selecciona el cercle per marcar la resposta correcta.</p>
            <div id="respostes-container" class="space-y-2"></div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">Crear</button>
            <a href="{{ route('preguntes.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">Cancel·lar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const MAX_ANSWERS = 3;
    let counter = 0;

    function updateAddBtn() {
        const count = document.querySelectorAll('#respostes-container > div').length;
        document.getElementById('answer-count').textContent = count + '/' + MAX_ANSWERS;
        const btn = document.getElementById('add-btn');
        if (count >= MAX_ANSWERS) {
            btn.disabled = true;
            btn.className = 'text-sm text-gray-400 font-medium cursor-not-allowed';
        } else {
            btn.disabled = false;
            btn.className = 'text-sm text-indigo-600 hover:text-indigo-800 font-medium cursor-pointer';
        }
    }

    function addResposta(text = '') {
        if (document.querySelectorAll('#respostes-container > div').length >= MAX_ANSWERS) return;
        const i = counter++;
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2';
        row.innerHTML = `
            <input type="radio" name="correcta" value="${i}" title="Resposta correcta"
                class="w-4 h-4 accent-green-600 shrink-0 cursor-pointer">
            <input type="text" name="respostes[${i}][text]" value="${text}" placeholder="Escriu la resposta..."
                class="flex-1 border-0 bg-transparent focus:outline-none text-sm text-gray-800">
            <button type="button" onclick="removeResposta(this)"
                class="text-red-400 hover:text-red-600 text-xl leading-none shrink-0 font-bold">&times;</button>
        `;
        document.getElementById('respostes-container').appendChild(row);
        updateAddBtn();
    }

    function removeResposta(btn) {
        btn.closest('div').remove();
        updateAddBtn();
    }

    document.getElementById('add-btn').addEventListener('click', () => addResposta());

    // Start with 3 rows
    addResposta();
    addResposta();
    addResposta();
</script>
@endpush
@endsection