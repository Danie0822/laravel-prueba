<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';
    protected $fillable = [
        'nombre',
        'correo_electronico',
        'usuario',
        'clave',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'rol',
        'estado',
    ];
}
