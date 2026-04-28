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
}
