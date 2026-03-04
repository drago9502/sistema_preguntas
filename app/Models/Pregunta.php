<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = "preguntas";
    public $timestamps = true;

    protected $fillable = [
        'id_evento',
        'numero',
        'pregunta',
        'status',
    ];
}
