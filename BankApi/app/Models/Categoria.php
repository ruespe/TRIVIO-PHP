<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'descripcio',
    ];

    public function preguntes(){
        return $this->hasMany(Pregunta::class);
    }
}
