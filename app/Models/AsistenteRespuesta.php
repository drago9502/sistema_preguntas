<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenteRespuesta extends Model
{
    use HasFactory;

    protected $table = "asistente_respuestas";
    public $timestamps = true;

    protected $fillable = [
        'id_evento',
        'id_pregunta',
        'id_respuesta',
        'id_asistente',
    ];
}
