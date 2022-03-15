<?php

use Illuminate\Database\Seeder;
use App\Models\Permiso;
use App\Models\Usuario;
use App\Models\Rol;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol_admin = Rol::where('slug', '=', 'ADMIN')->first();
        if(!$rol_admin){
            $rol_admin = new Rol;
            $rol_admin->nombre = 'ADMIN';
            $rol_admin->slug = 'ADMIN';
            $rol_admin->descripcion = 'ROL TIPO ADMINISTRADOR TIENE ACCESO A TODO EL SISTEMA';
            $rol_admin->acceso_completo = 'SI';
            $rol_admin->save();
        }

        $usuario_admin = Usuario::where('email', '=', 'camilo.perez.ort@gmail.com')->first();
        if(!$usuario_admin){
            $usuario_admin = new Usuario;
            $usuario_admin->nombre = 'CAMILO';
            $usuario_admin->apellido_paterno = 'PEREZ';
            $usuario_admin->apellido_materno = 'ORTIZ';
            $usuario_admin->email = 'camilo.perez.ort@gmail.com';
            $usuario_admin->password = bcrypt('L@ravel2020');
            $usuario_admin->save();

            # Asignacion de rol administrador al usuario #
            $usuario_admin->roles()->sync([$rol_admin->id]);
        }

        $permisos_todos = [];

        /*
        |--------------------------------------------------------------------------
        | Permisos de roles
        |--------------------------------------------------------------------------
        |
        */

        $permiso = new Permiso;
        $permiso->nombre = 'LISTAR ROLES';
        $permiso->slug = 'LISTAR.ROL';
        $permiso->descripcion = 'EL USUARIO PUEDE LISTAR LOS ROLES';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'VER ROL';
        $permiso->slug = 'VER.ROL';
        $permiso->descripcion = 'EL USUARIO PUEDE VER EL ROL';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'CREAR ROL';
        $permiso->slug = 'CREAR.ROL';
        $permiso->descripcion = 'EL USUARIO PUEDE CREAR UN ROL';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'EDITAR ROL';
        $permiso->slug = 'EDITAR.ROL';
        $permiso->descripcion = 'EL USUARIO PUEDE EDITAR UN ROL';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'ELIMINAR ROL';
        $permiso->slug = 'ELIMINAR.ROL';
        $permiso->descripcion = 'EL USUARIO PUEDE ELIMINAR UN ROL';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        /*
        |--------------------------------------------------------------------------
        | Permisos de usuarios
        |--------------------------------------------------------------------------
        |
        */
       
        $permiso = new Permiso;
        $permiso->nombre = 'LISTAR USUARIOS';
        $permiso->slug = 'LISTAR.USUARIO';
        $permiso->descripcion = 'EL USUARIO PUEDE LISTAR LOS USUARIOS';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'VER USUARIO';
        $permiso->slug = 'VER.USUARIO';
        $permiso->descripcion = 'EL USUARIO PUEDE VER EL USUARIO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'CREAR USUARIO';
        $permiso->slug = 'CREAR.USUARIO';
        $permiso->descripcion = 'EL USUARIO PUEDE CREAR UN USUARIO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'EDITAR USUARIO';
        $permiso->slug = 'EDITAR.USUARIO';
        $permiso->descripcion = 'EL USUARIO PUEDE EDITAR UN USUARIO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'ELIMINAR USUARIO';
        $permiso->slug = 'ELIMINAR.USUARIO';
        $permiso->descripcion = 'EL USUARIO PUEDE ELIMINAR UN USUARIO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        /*
        |--------------------------------------------------------------------------
        | Permisos para acceder
        |--------------------------------------------------------------------------
        |
        */
        $permiso = new Permiso;
        $permiso->nombre = 'LISTAR PERMISOS';
        $permiso->slug = 'LISTAR.PERMISO';
        $permiso->descripcion = 'EL USUARIO PUEDE LISTAR LOS PERMISOS';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'VER PERMISO';
        $permiso->slug = 'VER.PERMISO';
        $permiso->descripcion = 'EL USUARIO PUEDE VER EL PERMISO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'CREAR PERMISO';
        $permiso->slug = 'CREAR.PERMISO';
        $permiso->descripcion = 'EL USUARIO PUEDE CREAR UN PERMISO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'EDITAR PERMISO';
        $permiso->slug = 'EDITAR.PERMISO';
        $permiso->descripcion = 'EL USUARIO PUEDE EDITAR UN PERMISO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        $permiso = new Permiso;
        $permiso->nombre = 'ELIMINAR PERMISO';
        $permiso->slug = 'ELIMINAR.PERMISO';
        $permiso->descripcion = 'EL USUARIO PUEDE ELIMINAR UN PERMISO';
        $permiso->save();

        $permisos_todos[] = $permiso->id;

        # Asignar todos los permisos al admin #
        $rol_admin->permisos()->sync($permisos_todos);
    }
}
