<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = "eventos";
    public $timestamps = true;


    // status 1=registrado, 2=activo, 3= cerrado
    protected $fillable = [
        'id_empresa',
        'nombre',
        'fecha_inicio',
        'fecha_termino',
        'status',
    ];
}
