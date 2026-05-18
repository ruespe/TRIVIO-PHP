<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartidaPregunta extends Model
{
    protected $table = 'partida_preguntes';

    protected $fillable = [
        'partida_id',
        'pregunta_id',
        'resposta_id',
    ];

    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function resposta()
    {
        return $this->belongsTo(Resposta::class);
    }
}
