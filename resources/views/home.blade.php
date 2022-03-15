@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    HOLA {{ Auth::user()->nombre }} {{ Auth::user()->apellido_paterno }}
                    <br>
                    Opciones:
                    <br>
                    <a href="{{ route('listarUsuarios') }}">Usuarios</a>
                    <br>
                    <a href="{{ route('listarRoles') }}">Roles</a>
                    <br>
                    <a href="{{ route('listarPermisos') }}">Permisos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
