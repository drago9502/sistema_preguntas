<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaRespuesta extends Model
{
    use HasFactory;
     protected $table = "pregunta_respuestas";
    public $timestamps = true;

    protected $fillable = [
        'id_pregunta',
        'numero_respuesta',
        'respuesta',
    ];
}
