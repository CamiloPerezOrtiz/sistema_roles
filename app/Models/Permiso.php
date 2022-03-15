<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = "permisos";

    protected $fillable = [
        'nombre', 'slug', 'descripcion'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    |
    */
   
    public function roles()
    {
        return $this->belongsToMany('App\Models\Rol')->withTimesTamps();
    }
}
