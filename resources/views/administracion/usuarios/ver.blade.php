@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ver usuario</div>
                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="container">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="{{ $usuario->nombre }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Apellido Paterno</label>
                            <input type="text" class="form-control" name="apellido_paterno" value="{{ $usuario->apellido_paterno }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Apellido Materno</label>
                            <input type="text" class="form-control" name="apellido_materno" value="{{ $usuario->apellido_materno }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $usuario->email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <input type="text" class="form-control" value="{{ $usuario->roles[0]->nombre }}" readonly>
                        </div>
                        <hr>
                        <a class="btn btn-sm btn-success" href="{{ route('editarUsuario', $usuario->id) }}">Editar</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('listarUsuarios') }}">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
