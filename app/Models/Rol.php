<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "roles";

    protected $fillable = [
        'nombre', 'slug', 'descripcion', 'acceso_completo'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    |
    */

    public function usuarios()
    {
        return $this->belongsToMany('App\Models\Usuario')->withTimesTamps();
    }

    public function permisos()
    {
        return $this->belongsToMany('App\Models\Permiso', 'permisos_roles', 'roles_id', 'permisos_id')->withTimesTamps();
    }
}
