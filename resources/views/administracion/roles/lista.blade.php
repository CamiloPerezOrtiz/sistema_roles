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
                    <a class="btn btn-sm btn-success float-right" href="{{ route('registroRol') }}">CREAR ROL</a>
                    <br><br>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>SLUG</th>
                                <th>DESCRIPCION</th>
                                <th>ACCESO COMPLETO</th>
                                <th>DETALLES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <th>{{ $rol->id }}</th>
                                    <th>{{ $rol->nombre }} </th>
                                    <th>{{ $rol->slug }} </th>
                                    <th>{{ $rol->descripcion }} </th>
                                    <th>{{ $rol->acceso_completo }} </th>
                                    <th>
                                        <a class="btn btn-sm btn-info mt-1" href="{{ route('verRol', $rol->id) }}">VER</a>
                                        <a class="btn btn-sm btn-warning mt-1" href="{{ route('editarRol', $rol->id) }}">EDITAR</a>
                                        <form action="{{ route('eliminarRolPost', $rol->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-danger mt-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este elemento?')">ELIMINAR</button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
