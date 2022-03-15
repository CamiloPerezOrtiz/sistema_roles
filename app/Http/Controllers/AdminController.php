<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Seguimiento;
use Swift_SwiftException;
use App\Models\Usuario;
use App\Models\Permiso;
use App\Models\Rol;
use DateTime;
use Redirect;
use Config;
use Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |--------------------------------------------------------------------------
    | Administracion permisos
    |--------------------------------------------------------------------------
    |
    */

    public function listarPermisos()
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'LISTAR.PERMISO');

        # Seguimiento #
        $accion = 'LISTAR PERMISOS <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 7, $accion);

        $permisos = Permiso::orderBy('id', 'DESC')->paginate(10);

        return view('administracion.permisos.lista', compact('permisos'));
    }

    public function registroPermiso()
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'CREAR.PERMISO');

        # Seguimiento #
        $accion = 'REGISTRAR NUEVO PERMISO (FORMULARIO) <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 1, $accion);

        return view('administracion.permisos.registro');
    }

    public function registroPermisoPost(Request $request)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'CREAR.PERMISO');

        $this->validate($request,[
            'nombre' => 'required|min:3|max:255|unique:permisos,nombre',
            'slug' => 'required|max:255|unique:permisos,slug',
            'descripcion' => 'nullable|min:10|max:2147483647',
        ]);

        $permiso = new Permiso;
        $permiso->nombre = $request->nombre;
        $permiso->slug = $request->slug;
        $permiso->descripcion = $request->descripcion;
        $permiso->save();

        # Seguimiento #
        $accion = 'REGISTRAR NUEVO PERMISO (GUARDAR INFORMACIÓN) <br>' .
            'NOMBRE DEL PERMISO: ' . $permiso->nombre . '<br>' .
            'SLUG: ' . $permiso->slug . '<br>' .
            'DESCRIPCION: ' . $permiso->descripcion . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 1, $accion);

        return redirect()->route('listarPermisos')->with('correcto','Registro agregado correctamente.');
    }

    public function verPermiso($permisos_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'VER.PERMISO');

        $permiso = Permiso::where('id', '=', $permisos_id)->firstOrFail();

        # Seguimiento #
        $accion = 'VISUALIZACIÓN DE LA INFORMACIÓN DEL PERMISO <br> ID PERMISO ' . $permiso->id . ' <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 2, $accion);

        return view('administracion.permisos.ver', compact('permiso'));
    }

    public function editarPermiso($permisos_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'EDITAR.PERMISO');

        $permiso = Permiso::where('id', '=', $permisos_id)->firstOrFail();

        # Seguimiento #
        $accion = 'EDITAR INFORMACIÓN DEL PERMISO (FORMULARIO) <br> ID PERMISO ' . $permiso->id . ' <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 3, $accion);

        return view('administracion.permisos.editar', compact('permiso'));
    }

    public function editarPermisoPost(Request $request, $permisos_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'EDITAR.PERMISO');

        $this->validate($request,[
            'nombre' => 'required|max:255|unique:permisos,nombre,' . $permisos_id,
            'slug' => 'required|max:255|unique:permisos,slug,' . $permisos_id,
            'descripcion' => 'nullable|min:10|max:2147483647',
        ]);

        $permiso = Permiso::where('id', '=', $permisos_id)->firstOrFail();

        # Seguimiento #
        $accion = 'EDITAR INFORMACIÓN DEL PERMISO (GUARDAR INFORMACIÓN) ID PERMISO ' . $permiso->id . ' <br>' .  
            '------------------------------------------------------------------------- <br>' .
            'INFORMACIÓN ANTIGUA <br>' .
            'NOMBRE DEL PERMISO: ' . $permiso->nombre . '<br>' .
            'SLUG: ' . $permiso->slug . '<br>' .
            'DESCRIPCION: ' . $permiso->descripcion . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'INFORMACIÓN NUEVA <br>' .
            'NOMBRE DEL PERMISO: ' . $request->nombre . '<br>' .
            'SLUG: ' . $request->slug . '<br>' .
            'DESCRIPCION: ' . $request->descripcion . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 3, $accion);

        $permiso->nombre = $request->nombre;
        $permiso->slug = $request->slug;
        $permiso->descripcion = $request->descripcion;
        $permiso->save();

        return redirect()->route('listarPermisos')->with('correcto','Registro actualizado correctamente.');
    }

    public function eliminarPermisoPost(Request $request, $permisos_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'ELIMINAR.PERMISO');

        $permiso = Permiso::where('id', '=', $permisos_id)->firstOrFail();

        # Seguimiento #
        $accion = 'ELIMINACION DEL PERMISO <br>' .  'ID PERMISO: ' . $permiso->id . '<br>' . 
            'NOMBRE DEL PERMISO: ' . $permiso->nombre . '<br>' .
            'SLUG: ' . $permiso->slug . '<br>' .
            'DESCRIPCION: ' . $permiso->descripcion . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 4, $accion);

        $permiso->delete();

        return redirect()->route('listarPermisos')->with('correcto','Registro eliminado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | Administracion Roles
    |--------------------------------------------------------------------------
    |
    */

    public function listarRoles()
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'LISTAR.ROL');

        $roles = Rol::orderBy('id', 'DESC')->paginate(10);

        # Seguimiento #
        $accion = 'LISTAR ROLES <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 7, $accion);

        return view('administracion.roles.lista', compact('roles'));
    }

    public function registroRol()
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'CREAR.ROL');

        # Seguimiento #
        $accion = 'REGISTRAR NUEVO ROL (FORMULARIO) <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 1, $accion);

        $permisos = Permiso::orderBy('id', 'ASC')->get();

        return view('administracion.roles.registro', compact('permisos'));
    }

    public function registroRolPost(Request $request)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'CREAR.ROL');

        $this->validate($request,[
            'nombre' => 'required|min:3|max:255|unique:roles,nombre',
            'slug' => 'required|min:3|max:255|unique:roles,slug',
            'descripcion' => 'nullable|min:10|max:2147483647',
            'acceso_completo' =>'required|in:SI,NO',
        ]);

        $rol = new Rol;
        $rol->nombre = $request->nombre;
        $rol->slug = $request->slug;
        $rol->descripcion = $request->descripcion;
        $rol->acceso_completo = $request->acceso_completo;
        $rol->save();

        # Asignacion de permisos al rol #
        $rol->permisos()->sync($request->permisos);

        # Seguimiento #
        $accion = 'REGISTRAR NUEVO ROL (GUARDAR INFORMACIÓN) <br>' .
            'NOMBRE DEL ROL: ' . $rol->nombre . '<br>' .
            'SLUG: ' . $rol->slug . '<br>' .
            'DESCRIPCION: ' . $rol->descripcion . '<br>' .
            'ACCESO COMPLETO: ' . $rol->acceso_completo . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 1, $accion);

        return redirect()->route('listarRoles')->with('correcto','Registro agregado correctamente.');
    }

    public function verRol($roles_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'VER.ROL');

        $rol = Rol::where('id', '=', $roles_id)->firstOrFail();
        $permiso_rol = [];

        # Se accede a los permisos del rol a traves del modelo #
        foreach($rol->permisos as $permiso){
            $permiso_rol[] = $permiso->id;
        }

        $permisos = Permiso::orderBy('id', 'ASC')->get();

        # Seguimiento #
        $accion = 'VISUALIZACIÓN DE LA INFORMACIÓN DEL ROL <br> ID ROL ' . $rol->id . ' <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 2, $accion);

        return view('administracion.roles.ver', compact('rol', 'permisos', 'permiso_rol'));
    }

    public function editarRol($roles_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'EDITAR.ROL');

        $rol = Rol::where('id', '=', $roles_id)->firstOrFail();
        $permiso_rol = [];

        # Se accede a los permisos del rol a traves del modelo #
        foreach($rol->permisos as $permiso){
            $permiso_rol[] = $permiso->id;
        }

        $permisos = Permiso::orderBy('id', 'ASC')->get();

        # Seguimiento #
        $accion = 'EDITAR INFORMACIÓN DEL ROL (FORMULARIO) <br> ID ROL ' . $rol->id . ' <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 3, $accion);

        return view('administracion.roles.editar', compact('rol', 'permisos', 'permiso_rol'));
    }

    public function editarRolPost(Request $request, $roles_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'EDITAR.ROL');

        $this->validate($request,[
            'nombre' => 'required|min:3|max:255|unique:roles,nombre,' . $roles_id,
            'slug' => 'required|min:3|max:255|unique:roles,slug,' . $roles_id,
            'descripcion' => 'nullable|min:10|max:2147483647',
            'acceso_completo' =>'required|in:SI,NO'
        ]);

        $rol = Rol::where('id', '=', $roles_id)->firstOrFail();

        # Seguimiento #
        $accion = 'EDITAR INFORMACIÓN DEL ROL (GUARDAR INFORMACIÓN) ID ROL ' . $rol->id . ' <br>' .  
            '------------------------------------------------------------------------- <br>' .
            'INFORMACIÓN ANTIGUA <br>' .
            'NOMBRE DEL ROL: ' . $rol->nombre . '<br>' .
            'SLUG: ' . $rol->slug . '<br>' .
            'DESCRIPCION: ' . $rol->descripcion . '<br>' .
            'ACCESO COMPLETO: ' . $rol->acceso_completo . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'INFORMACIÓN NUEVA <br>' .
            'NOMBRE DEL ROL: ' . $request->nombre . '<br>' .
            'SLUG: ' . $request->slug . '<br>' .
            'DESCRIPCION: ' . $request->descripcion . '<br>' .
            'ACCESO COMPLETO: ' . $request->acceso_completo . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 3, $accion);

        $rol->nombre = $request->nombre;
        $rol->slug = $request->slug;
        $rol->descripcion = $request->descripcion;
        $rol->acceso_completo = $request->acceso_completo;
        $rol->save();
        
        # Asignacion de permisos al rol #
        $rol->permisos()->sync($request->permisos);

        return redirect()->route('listarRoles')->with('correcto','Registro actualizado correctamente.');
    }

    public function eliminarRolPost(Request $request, $roles_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'ELIMINAR.ROL');

        $rol = Rol::where('id', '=', $roles_id)->firstOrFail();

        # Seguimiento #
        $accion = 'ELIMINACION DEL ROL <br>' .  'ID ROL: ' . $rol->id . '<br>' . 
            'NOMBRE DEL ROL: ' . $rol->nombre . '<br>' .
            'SLUG: ' . $rol->slug . '<br>' .
            'DESCRIPCION: ' . $rol->descripcion . '<br>' .
            'ACCESO COMPLETO: ' . $rol->acceso_completo . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 4, $accion);

        $rol->delete();

        return redirect()->route('listarRoles')->with('correcto','Registro eliminado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | Administracion Usuarios
    |--------------------------------------------------------------------------
    |
    */
   
    public function listarUsuarios()
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'LISTAR.USUARIO');

        $usuarios = Usuario::orderBy('id', 'DESC')->paginate(10);
        
        # Seguimiento #
        $accion = 'LISTAR USUARIOS <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 7, $accion);

        return view('administracion.usuarios.lista', compact('usuarios'));
    }

    public function registroUsuario()
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'CREAR.USUARIO');

        $roles = Rol::orderBy('id', 'ASC')->get();

        # Seguimiento #
        $accion = 'REGISTRAR NUEVO USUARIOS (FORMULARIO) <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 1, $accion);

        return view('administracion.usuarios.registro', compact('roles'));
    }

    public function registroUsuarioPost(Request $request)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'CREAR.USUARIO');

        $this->validate($request,[
            'nombre' => 'required|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'apellido_paterno' => 'required|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'apellido_materno' => 'nullable|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|min:8|max:255|regex:/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/|unique:usuarios',
            'password' => 'required|min:7|max:15|confirmed',
            'rol' => 'required',
        ]);

        $usuario = new Usuario;
        $usuario->nombre = $request->nombre;
        $usuario->apellido_paterno = $request->apellido_paterno;
        $usuario->apellido_materno = $request->apellido_materno;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        # Asignacion de rol candidato #
        $usuario->roles()->sync([$request->rol]);

        # Seguimiento #
        $accion = 'REGISTRAR NUEVO USUARIO (GUARDAR INFORMACIÓN) <br>' .
            'NOMBRE DEL USUARIO: ' . $usuario->nombre . '<br>' .
            'APELLIDO PATERNO: ' . $usuario->apellido_paterno . '<br>' .
            'APELLIDO MATERNO: ' . $usuario->apellido_materno . '<br>' .
            'EMAIL: ' . $usuario->email . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 1, $accion);

        if($request->enviar_correo == 'SI'){
            if(config('app.debug') == false){
                # Eniviar correo #
                $datos = array(
                    'correo' => $request->email, 
                    'nombre_completo' => $request->nombre . ' ' .$request->apellido_paterno, 
                    'password' => $request->password
                );

                try{
                    dispatch(function() use($datos) {
                        Mail::send('correo.administracion.usuarios.registro', $datos, function($message) use ($datos){
                            $message->to($datos['correo'], $datos['nombre_completo'])->from('soporte@trebalant.com','Trebalant')->subject('Bienvenido a Trebalant');
                        });
                    })->delay(now()->addSeconds(10));

                    # Seguimiento #
                    $accion_2 = 'ENVIO DE CORREO AL NUEVO USUARIO REGISTRADO <br>' .
                        'ID USUARIO ' . $usuario->id . ' <br>' .
                        '------------------------------------------------------------------------- <br>' .
                        'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
                        'USUARIO: ' . Auth::user()->email;

                    $this->seguimiento($request->email, Auth::user()->roles[0]->nombre, 6, $accion_2);
                }
                catch(Swift_SwiftException $error){
                    # Seguimiento #
                    $accion_3 = '<strong>¡ERROR!</strong> NO SE LOGRO MANDAR EL CORREO ELECTRONICO AL NUEVO USUARIO POSIBLE ERROR: ' . $error->getMessage() .'<br>' .
                        'ID USUARIO ' . $usuario->id . ' <br>' .
                        '------------------------------------------------------------------------- <br>' . 
                        'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
                        'USUARIO: ' . Auth::user()->email;

                    $this->seguimiento($request->email, Auth::user()->roles[0]->nombre, 5, $accion_3);
                }
            }
        }

        return redirect()->route('listarUsuarios')->with('correcto','Registro agregado correctamente.');
    }

    public function verUsuario($usuarios_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'VER.USUARIO');

        $usuario = Usuario::where('id', '=', $usuarios_id)->firstOrFail();

        # Seguimiento #
        $accion = 'VISUALIZACIÓN DE LA INFORMACIÓN DEL USUARIO <br> ID USUARIO ' . $usuario->id . ' <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 2, $accion);

        return view('administracion.usuarios.ver', compact('usuario'));
    }

    public function editarUsuario($usuarios_id)
    {
        # Politica para saber si el usuario tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'EDITAR.USUARIO');

        $usuario = Usuario::where('id', '=', $usuarios_id)->firstOrFail();
        $roles = Rol::orderBy('id', 'ASC')->get();

        # Seguimiento #
        $accion = 'EDITAR INFORMACIÓN DEL USUARIO (FORMULARIO) <br> ID USUARIO ' . $usuario->id . ' <br> REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' . 'USUARIO: ' . Auth::user()->email;
        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 3, $accion);

        return view('administracion.usuarios.editar', compact('usuario', 'roles'));
    }

    public function editarUsuarioPost(Request $request, $usuarios_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'EDITAR.USUARIO');

        $this->validate($request,[
            'nombre' => 'required|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'apellido_paterno' => 'required|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'apellido_materno' => 'nullable|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|min:8|max:255|regex:/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/|unique:usuarios,email,' . $usuarios_id,
        ]);

        $usuario = Usuario::where('id', '=', $usuarios_id)->firstOrFail();

        # Seguimiento #
        $accion = 'EDITAR INFORMACIÓN DEL USUARIO (GUARDAR INFORMACIÓN) ID USUARIO ' . $usuario->id . ' <br>' .  
            '------------------------------------------------------------------------- <br>' .
            'INFORMACIÓN ANTIGUA <br>' .
            'NOMBRE DEL USUARIO: ' . $usuario->nombre . '<br>' .
            'APELLIDO PATERNO: ' . $usuario->apellido_paterno . '<br>' .
            'APELLIDO MATERNO: ' . $usuario->apellido_materno . '<br>' .
            'EMAIL: ' . $usuario->email . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'INFORMACIÓN NUEVA <br>' .
            'NOMBRE DEL USUARIO: ' . $request->nombre . '<br>' .
            'APELLIDO PATERNO: ' . $request->apellido_paterno . '<br>' .
            'APELLIDO MATERNO: ' . $request->apellido_materno . '<br>' .
            'EMAIL: ' . $request->email . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 3, $accion);

        $usuario->nombre = $request->nombre;
        $usuario->apellido_paterno = $request->apellido_paterno;
        $usuario->apellido_materno = $request->apellido_materno;
        $usuario->email = $request->email;
        $usuario->save();

        # Asignacion de rol candidato #
        $usuario->roles()->sync([$request->rol]);

        if($request->enviar_correo == 'SI'){
            if(config('app.debug') == false){
                # Eniviar correo #
                $datos = array(
                    'correo' => $request->email, 
                    'nombre_completo' => $request->nombre . ' ' .$request->apellido_paterno
                );

                try{
                    dispatch(function() use($datos) {
                        Mail::send('correo.administracion.usuarios.editar', $datos, function($message) use ($datos){
                            $message->to($datos['correo'], $datos['nombre_completo'])->from('soporte@trebalant.com','Trebalant')->subject('Actualización de datos Trebalant');
                        });
                    })->delay(now()->addSeconds(10));

                    # Seguimiento #
                    $accion_2 = 'ENVIO DE CORREO AL USUARIO EDITADO <br>' .
                        'ID USUARIO ' . $usuario->id . ' <br>' .
                        '------------------------------------------------------------------------- <br>' .
                        'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
                        'USUARIO: ' . Auth::user()->email;

                    $this->seguimiento($request->email, Auth::user()->roles[0]->nombre, 6, $accion_2);
                }
                catch(Swift_SwiftException $error){
                    # Seguimiento #
                    $accion_3 = '<strong>¡ERROR!</strong> NO SE LOGRO MANDAR EL CORREO ELECTRONICO AL USUARIO EDITADO POSIBLE ERROR: ' . $error->getMessage() .'<br>' .
                        'ID USUARIO ' . $usuario->id . ' <br>' .
                        '------------------------------------------------------------------------- <br>' . 
                        'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
                        'USUARIO: ' . Auth::user()->email;

                    $this->seguimiento($request->email, Auth::user()->roles[0]->nombre, 5, $accion_3);
                }
            }
        }

        return redirect()->route('listarUsuarios')->with('correcto','Registro actualizado correctamente.');
    }

    public function eliminarUsuarioPost(Request $request, $usuarios_id)
    {
        # Politica para saber si el rol tiene el permiso de ingresar a la funcion #
        Gate::authorize('tieneAcceso', 'ELIMINAR.USUARIO');

        $usuario = Usuario::where('id', '=', $usuarios_id)->firstOrFail();

        # Seguimiento #
        $accion = 'ELIMINACION DEL USUARIO <br>' .  'ID USUARIO: ' . $usuario->id . '<br>' . 
            'NOMBRE DEL USUARIO: ' . $usuario->nombre . '<br>' .
            'APELLIDO PATERNO: ' . $usuario->apellido_paterno . '<br>' .
            'APELLIDO MATERNO: ' . $usuario->apellido_materno . '<br>' .
            'EMAIL: ' . $usuario->email . '<br>' .
            '------------------------------------------------------------------------- <br>' .
            'REALIZADO POR ID USUARIO: ' . Auth::user()->id . '<br>' .
            'USUARIO: ' . Auth::user()->email;

        $this->seguimiento(Auth::user()->email, Auth::user()->roles[0]->nombre, 4, $accion);

        $usuario->delete();

        return redirect()->route('listarUsuarios')->with('correcto','Registro eliminado correctamente.');
    }
}
