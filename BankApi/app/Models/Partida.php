<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partides';

    protected $fillable = [
        'user_id',
        'puntuacio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partidaPreguntes()
    {
        return $this->hasMany(PartidaPregunta::class);
    }

    public function preguntes()
    {
        return $this->belongsToMany(Pregunta::class, 'partida_preguntes')
            ->withPivot('resposta_id')
            ->withTimestamps();
    }
}
