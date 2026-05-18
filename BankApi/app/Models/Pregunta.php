<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntes';

    protected $fillable = [
        'enunciat',
        'dificultat',
        'categoria_id'
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function respostes(){
        return $this->hasMany(Resposta::class);
    }
}
