@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Lista de roles</div>
                    <div class="card-body">
                        @if(Session::has('correcto'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <ul>
                                    <li>{{ Session::get('correcto') }}</li>
                                </ul>    
                            </div>
                        @endif
                        <a class="btn btn-sm btn-primary float-lefht" href="{{ route('home') }}">REGRESAR</a>
                        <a class="btn btn-sm btn-success float-right" href="{{ route('registroPermiso') }}">AGREGAR PERMISO</a>
                        <br><br>
                        <table class="table table-bordered table-hover" id="lista-permisos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>SLUG</th>
                                    <th>DESCRIPCION</th>
                                    <th>FECHA DE REGISTRO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permisos as $permiso)
                                    <tr>
                                        <th>{{ $permiso->id }}</th>
                                        <th>{{ $permiso->nombre }} </th>
                                        <th>{{ $permiso->slug }} </th>
                                        <th>{{ $permiso->descripcion }} </th>
                                        <th>{{ $permiso->created_at->diffForHumans() }} </th>
                                        <th>
                                            <a class="btn btn-sm btn-info mt-1" href="{{ route('verPermiso', $permiso->id) }}">VER</a>
                                            <a class="btn btn-sm btn-warning mt-1" href="{{ route('editarPermiso', $permiso->id) }}">EDITAR</a>
                                            <form action="{{ route('eliminarPermisoPost', $permiso->id) }}" method="POST">
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
                                    <th>SLUG</th>
                                    <th>DESCRIPCION</th>
                                    <th>FECHA DE REGISTRO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $permisos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection