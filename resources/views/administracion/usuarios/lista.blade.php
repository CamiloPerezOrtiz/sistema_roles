@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Lista de usuarios</div>
                    <div class="card-body">
                        @if(Session::has('correcto'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <ul>
                                    <li>{{ Session::get('correcto') }}</li>
                                </ul>    
                            </div>
                        @endif
                        <a class="btn btn-sm btn-primary float-lefht" href="{{ route('home') }}">REGRESAR</a>
                        <a class="btn btn-sm btn-success float-right" href="{{ route('registroUsuario') }}">AGREGAR USUARIO</a>
                        <br><br>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>EMAIL</th>
                                    <th>ESTATUS</th>
                                    <th>ROL</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <th>{{ $usuario->id }}</th>
                                        <th>{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }} </th>
                                        <th>{{ $usuario->email }} </th>
                                        <th>
                                            @if ($usuario->estatus == 1)
                                                ACTIVADO
                                            @endif
                                            @if ($usuario->estatus == 2)
                                                DESACTIVADO
                                            @endif
                                        </th>
                                        <th>{{ $usuario->roles[0]->nombre }} </th>
                                        <th>
                                            <a class="btn btn-sm btn-info mt-1" href="{{ route('verUsuario', $usuario->id) }}">VER</a>
                                            <a class="btn btn-sm btn-warning mt-1" href="{{ route('editarUsuario', $usuario->id) }}">EDITAR</a>
                                            <form action="{{ route('eliminarUsuarioPost', $usuario->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-danger mt-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este elemento?')">ELIMINAR</button>
                                            </form>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>EMAIL</th>
                                    <th>ESTATUS</th>
                                    <th>ROL</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection