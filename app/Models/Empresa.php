<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";
    public $timestamps = true;


    protected $fillable = [
        'nombre',
        'status',
    ];
}
