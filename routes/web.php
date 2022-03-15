<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@inicio')->name('inicio');

Auth::routes();

# Redireccionar la ruta de registro por defecto de laravel #
Route::get('/register', function () {
    return redirect('/');
});

# Redireccionar la ruta de restablecar la contraseña por defecto de laravel #
Route::get('/password/reset', function () {
    return redirect('/');
});

# Administracion #
Route::get('/home', 'HomeController@index')->name('home');

# Registro de permisos #
Route::get('/sr/listar-permisos', 'AdminController@listarPermisos')->name('listarPermisos');
Route::get('/sr/registro-permiso', 'AdminController@registroPermiso')->name('registroPermiso');
Route::post('/sr/registro-permiso', 'AdminController@registroPermisoPost')->name('registroPermisoPost');
Route::get('/sr/editar-permiso/{permisos_id}', 'AdminController@editarPermiso')->name('editarPermiso');
Route::post('/sr/editar-permiso/{permisos_id}', 'AdminController@editarPermisoPost')->name('editarPermisoPost');
Route::get('/sr/ver-permiso/{permisos_id}', 'AdminController@verPermiso')->name('verPermiso');
Route::post('/sr/eliminar-permiso/{permisos_id}', 'AdminController@eliminarPermisoPost')->name('eliminarPermisoPost');

# Registro de roles #
Route::get('/sr/listar-roles', 'AdminController@listarRoles')->name('listarRoles');
Route::get('/sr/registro-rol', 'AdminController@registroRol')->name('registroRol');
Route::post('/sr/registro-rol', 'AdminController@registroRolPost')->name('registroRolPost');
Route::get('/sr/editar-rol/{roles_id}', 'AdminController@editarRol')->name('editarRol');
Route::post('/sr/editar-rol/{roles_id}', 'AdminController@editarRolPost')->name('editarRolPost');
Route::get('/sr/ver-rol/{roles_id}', 'AdminController@verRol')->name('verRol');
Route::post('/sr/eliminar-rol/{roles_id}', 'AdminController@eliminarRolPost')->name('eliminarRolPost');

# Registro de usuarios #
Route::get('/sr/listar-usuarios', 'AdminController@listarUsuarios')->name('listarUsuarios');
Route::get('/sr/registro-usuario', 'AdminController@registroUsuario')->name('registroUsuario');
Route::post('/sr/registro-usuario', 'AdminController@registroUsuarioPost')->name('registroUsuarioPost');
Route::get('/sr/editar-usuario/{usuarios_id}', 'AdminController@editarUsuario')->name('editarUsuario');
Route::post('/sr/editar-usuario/{usuarios_id}', 'AdminController@editarUsuarioPost')->name('editarUsuarioPost');
Route::get('/sr/ver-usuario/{usuarios_id}', 'AdminController@verUsuario')->name('verUsuario');
Route::post('/sr/eliminar-usuario/{usuarios_id}', 'AdminController@eliminarUsuarioPost')->name('eliminarUsuarioPost');