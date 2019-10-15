<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'dt_nascimento',
        'ft',
        'thumb',
        'categoria_id',
    ];

    public function categoria() 
    {
        return $this->belongsTo('App\Categoria');
    }
}
