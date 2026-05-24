@extends('layout')
@section('title', 'Editar pregunta')
@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Editar pregunta #{{ $pregunta['id'] }}</h1>

    <form method="POST" action="{{ route('preguntes.update', $pregunta['id']) }}" id="edit-form" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Enunciat <span class="text-red-500">*</span></label>
            <input type="text" name="enunciat" value="{{ old('enunciat', $pregunta['enunciat']) }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dificultat <span class="text-red-500">*</span></label>
            <select name="dificultat" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @foreach(['Fàcil', 'Mitja', 'Difícil'] as $d)
                <option value="{{ $d }}" {{ old('dificultat', $pregunta['dificultat']) == $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-red-500">*</span></label>
            <select name="categoria_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @foreach($categories as $cat)
                <option value="{{ $cat['id'] }}" {{ old('categoria_id', $pregunta['categoria_id']) == $cat['id'] ? 'selected' : '' }}>{{ $cat['nom'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Respostes existents -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium text-gray-700">Respostes</label>
                <div class="flex items-center gap-2">
                    <span id="answer-count" class="text-xs text-gray-400"></span>
                    <button type="button" id="add-resposta-btn"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">+ Afegir resposta</button>
                </div>
            </div>
            <p class="text-xs text-gray-400 mb-2">Selecciona el cercle verd per marcar la resposta correcta.</p>

            <div id="respostes-container" class="space-y-2">
                @foreach($respostes as $r)
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 resposta-existent" data-id="{{ $r['id'] }}">
                    <input type="radio" name="correcta" value="e_{{ $r['id'] }}" title="Resposta correcta"
                        class="w-4 h-4 accent-green-600 shrink-0 cursor-pointer" {{ $r['es_correcta'] ? 'checked' : '' }}>
                    <input type="text" name="respostes_existents[{{ $r['id'] }}][text]" value="{{ old('respostes_existents.'.$r['id'].'.text', $r['text']) }}"
                        placeholder="Escriu la resposta..."
                        class="flex-1 border-0 bg-transparent focus:outline-none text-sm text-gray-800">
                    <button type="button" onclick="eliminarExistent(this, {{ $r['id'] }})"
                        class="text-red-400 hover:text-red-600 text-xl leading-none shrink-0 font-bold">&times;</button>
                </div>
                @endforeach
            </div>

            <!-- Respostes noves (afegides des de JS) -->
            <div id="noves-container" class="space-y-2 mt-2"></div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">Actualitzar</button>
            <a href="{{ route('preguntes.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">Cancel·lar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const MAX_ANSWERS = 3;
    let counter = 0;

    function getTotal() {
        return document.querySelectorAll('#respostes-container > div').length
             + document.querySelectorAll('#noves-container > div').length;
    }

    function updateAddBtn() {
        const total = getTotal();
        document.getElementById('answer-count').textContent = total + '/' + MAX_ANSWERS;
        const btn = document.getElementById('add-resposta-btn');
        if (total >= MAX_ANSWERS) {
            btn.disabled = true;
            btn.className = 'text-sm text-gray-400 font-medium cursor-not-allowed';
        } else {
            btn.disabled = false;
            btn.className = 'text-sm text-indigo-600 hover:text-indigo-800 font-medium cursor-pointer';
        }
    }

    function eliminarExistent(btn, id) {
        const row = btn.closest('.resposta-existent');
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'respostes_eliminar[]';
        hidden.value = id;
        document.getElementById('edit-form').appendChild(hidden);
        row.remove();
        updateAddBtn();
    }

    function addResposta() {
        if (getTotal() >= MAX_ANSWERS) return;
        const i = counter++;
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2';
        row.innerHTML = `
            <input type="radio" name="correcta" value="n_${i}" title="Resposta correcta"
                class="w-4 h-4 accent-green-600 shrink-0 cursor-pointer">
            <input type="text" name="respostes_noves[${i}][text]" value="" placeholder="Escriu la resposta..."
                class="flex-1 border-0 bg-transparent focus:outline-none text-sm text-gray-800">
            <button type="button" onclick="this.closest('div').remove(); updateAddBtn();"
                class="text-red-400 hover:text-red-600 text-xl leading-none shrink-0 font-bold">&times;</button>
        `;
        document.getElementById('noves-container').appendChild(row);
        updateAddBtn();
    }

    document.getElementById('add-resposta-btn').addEventListener('click', addResposta);

    updateAddBtn();
</script>
@endpush
@endsection