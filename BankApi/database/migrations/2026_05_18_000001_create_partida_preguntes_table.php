<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partida_preguntes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained('partides')->onDelete('cascade');
            $table->foreignId('pregunta_id')->constrained('preguntes')->onDelete('cascade');
            $table->foreignId('resposta_id')->nullable()->constrained('respostes')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partida_preguntes');
    }
};
