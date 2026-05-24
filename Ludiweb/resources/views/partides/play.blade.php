@extends('layout')
@section('title', 'Jugar')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-4">Partida #{{ $id }}</h1>

    @if(empty($preguntes))
    <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 rounded-xl p-6 text-center">
        <p class="font-semibold mb-2">No hi ha prou preguntes disponibles.</p>
        <p class="text-sm">Afegeix preguntes i respostes des del gestor abans de jugar.</p>
        <a href="{{ route('preguntes.create') }}" class="inline-block mt-4 bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Afegir preguntes</a>
    </div>
    @else

    <!-- Hidden form submitted at the end -->
    <form id="form-partida" method="POST" action="{{ route('partides.puntuar', $id) }}">
        @csrf
    </form>

    <!-- Header: pregunta counter + timer number -->
    <div class="flex items-center justify-between mb-1 text-sm">
        <span class="text-gray-500">Pregunta <span id="q-num" class="font-semibold text-gray-700">1</span> de {{ count($preguntes) }}</span>
        <span id="timer-num" class="text-2xl font-bold text-indigo-700 tabular-nums w-10 text-right">30</span>
    </div>

    <!-- Timer bar -->
    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
        <div id="timer-bar" class="bg-indigo-500 h-2 rounded-full" style="width:100%"></div>
    </div>

    <!-- Progress bar (questions answered) -->
    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-6">
        <div id="progress-bar" class="bg-green-500 h-1.5 rounded-full transition-all duration-500" style="width:0%"></div>
    </div>

    <!-- Question card -->
    <div class="bg-white rounded-xl shadow p-6 mb-5 min-h-[180px]">
        <p id="q-text" class="font-semibold text-gray-800 text-lg mb-4"></p>
        <div id="answers-container" class="space-y-2"></div>
        <p id="no-answers-msg" class="text-xs text-gray-400 italic hidden">Aquesta pregunta no té respostes definides.</p>
    </div>

    <!-- Next / Finish button -->
    <div class="text-center">
        <button id="next-btn" onclick="advance()"
            class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white px-10 py-3 rounded-xl text-lg font-semibold transition">
            Següent
        </button>
    </div>
    @endif
</div>

@push('scripts')
<script>
const preguntes = @json($preguntes);
const TIMER_SECS = 30;
let currentIdx   = 0;
let selectedId   = null;
let timerInterval = null;
let timeLeft     = TIMER_SECS;
let advancing    = false;

function showQuestion(idx) {
    advancing    = false;
    selectedId   = null;
    const q      = preguntes[idx];

    document.getElementById('q-num').textContent   = idx + 1;
    document.getElementById('q-text').textContent  = q.enunciat;
    document.getElementById('next-btn').textContent = (idx === preguntes.length - 1) ? 'Finalitzar' : 'Següent';

    // Progress (answered so far)
    document.getElementById('progress-bar').style.width = ((idx / preguntes.length) * 100) + '%';

    // Render answers
    const container = document.getElementById('answers-container');
    const noMsg     = document.getElementById('no-answers-msg');
    container.innerHTML = '';
    const respostes = q.respostes || [];

    if (respostes.length === 0) {
        noMsg.classList.remove('hidden');
    } else {
        noMsg.classList.add('hidden');
        respostes.forEach(r => {
            const btn = document.createElement('button');
            btn.type        = 'button';
            btn.dataset.rid = r.id;
            btn.className   = 'answer-btn w-full text-left flex items-center gap-3 p-3 rounded-lg border-2 border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 transition';
            btn.innerHTML   = `<span class="answer-dot w-5 h-5 rounded-full border-2 border-gray-300 shrink-0"></span>
                               <span class="text-gray-700">${r.text}</span>`;
            btn.addEventListener('click', () => selectAnswer(btn, r.id));
            container.appendChild(btn);
        });
    }

    startTimer();
}

function selectAnswer(btn, id) {
    selectedId = id;
    document.querySelectorAll('.answer-btn').forEach(b => {
        b.classList.remove('border-indigo-500', 'bg-indigo-50');
        b.querySelector('.answer-dot').className = 'answer-dot w-5 h-5 rounded-full border-2 border-gray-300 shrink-0';
    });
    btn.classList.add('border-indigo-500', 'bg-indigo-50');
    const dot = btn.querySelector('.answer-dot');
    dot.className = 'answer-dot w-5 h-5 rounded-full border-2 border-indigo-500 bg-indigo-500 shrink-0';
}

function startTimer() {
    clearInterval(timerInterval);
    timeLeft = TIMER_SECS;
    renderTimer();
    timerInterval = setInterval(() => {
        timeLeft--;
        renderTimer();
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            advance();
        }
    }, 1000);
}

function renderTimer() {
    document.getElementById('timer-num').textContent = timeLeft;
    const pct = (timeLeft / TIMER_SECS) * 100;
    const bar = document.getElementById('timer-bar');
    const num = document.getElementById('timer-num');
    bar.style.width = pct + '%';

    if (timeLeft <= 10) {
        bar.className = 'bg-red-500 h-2 rounded-full transition-all duration-1000';
        num.className = 'text-2xl font-bold text-red-600 tabular-nums w-10 text-right';
    } else if (timeLeft <= 20) {
        bar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-1000';
        num.className = 'text-2xl font-bold text-yellow-600 tabular-nums w-10 text-right';
    } else {
        bar.className = 'bg-indigo-500 h-2 rounded-full transition-all duration-1000';
        num.className = 'text-2xl font-bold text-indigo-700 tabular-nums w-10 text-right';
    }
}

function advance() {
    if (advancing) return;
    advancing = true;
    clearInterval(timerInterval);

    // Record answer
    if (selectedId !== null) {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = `resposta[${preguntes[currentIdx].id}]`;
        input.value = selectedId;
        document.getElementById('form-partida').appendChild(input);
    }

    currentIdx++;
    if (currentIdx >= preguntes.length) {
        document.getElementById('progress-bar').style.width = '100%';
        document.getElementById('next-btn').disabled = true;
        document.getElementById('next-btn').textContent = 'Calculant...';
        document.getElementById('form-partida').submit();
    } else {
        showQuestion(currentIdx);
    }
}

showQuestion(0);
</script>
@endpush
@endsection