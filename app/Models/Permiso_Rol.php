<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso_Rol extends Model
{
    protected $table = "permisos_roles";

    protected $fillable = [
        'roles_id', 'permisos_id'
    ];
}
