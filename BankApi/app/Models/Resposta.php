<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $table = 'respostes';

    protected $fillable = [
        'text',
        'es_correcta',
        'pregunta_id'
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}
