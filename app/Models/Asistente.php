<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistente extends Authenticatable
{
    use HasFactory;


    protected $table = "asistentes";
    public $timestamps = true;


    protected $fillable = [
        'id_evento',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'status'
    ];
}
