<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    protected $table = "seguimientos";

    protected $fillable = [
        'usuario', 'rol', 'tipo_accion', 'accion', 'dispositivo', 'plataforma', 
        'plataforma_version', 'navegador', 'navegador_version', 'ip_address'
    ];
}
