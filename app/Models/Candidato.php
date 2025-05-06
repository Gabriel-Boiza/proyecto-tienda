<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidatos';
    protected $fillable = [
        'DNI',
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'javascript',
        'php',
        'html',
        'css',
        'curriculum'
    ];
}
