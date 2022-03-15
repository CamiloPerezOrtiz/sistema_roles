@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar usuario</div>
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
                    <form action="{{ route('editarUsuarioPost', $usuario->id) }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                            </div>
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input type="text" class="form-control" name="apellido_paterno" value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                            </div>
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" class="form-control" name="apellido_materno" value="{{ old('apellido_materno', $usuario->apellido_materno) }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $usuario->email) }}">
                            </div>
                            <div class="form-group">
                                <label>Rol</label>
                                <select class="form-control" name="rol" required>
                                    <option selected="true" disabled="disabled">Seleccione una opción...</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" @if(old('rol', $usuario->roles[0]->id) == $rol->id) selected @endif>{{ $rol->nombre }} ({{ $rol->descripcion }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <label>¿Enviar correo?</label> <br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="enviar_correo_si" name="enviar_correo" class="custom-control-input" value="SI" @if(old('enviar_correo') == 'SI') checked @endif>
                                <label class="custom-control-label" for="enviar_correo_si">SI</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="enviar_correo_no" name="enviar_correo" class="custom-control-input" value="NO" @if(old('enviar_correo') == 'NO') checked @endif @if(old('enviar_correo') === null) checked @endif>
                                <label class="custom-control-label" for="enviar_correo_no">NO</label>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-sm btn-primary" value="GUARDAR">
                            <a class="btn btn-sm btn-danger" href="{{ route('listarUsuarios') }}">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
