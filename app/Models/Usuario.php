<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";

    protected $fillable = [
        'nombre', 'apellido_paterno', 'apellido_materno', 'email', 'password', 'estatus',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    |
    */
   
    public function roles()
    {
        return $this->belongsToMany('App\Models\Rol', 'roles_usuarios', 'roles_id', 'usuarios_id')->withTimesTamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Validacion si el usuario tiene permisos para acceder a las funciones
    |--------------------------------------------------------------------------
    |
    */
   
    public function tienePermiso($permiso)
    {
        foreach($this->roles as $rol){
            if($rol->acceso_completo == 'SI'){
                return true;
            }

            foreach($rol->permisos as $rol_permiso){
                if($rol_permiso->slug == $permiso){
                    return true;
                }
            }
        }

        return false;
    }
}
