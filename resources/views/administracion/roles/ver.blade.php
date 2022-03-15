@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ver rol</div>
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
                            <input type="text" class="form-control" name="nombre" value="{{ $rol->nombre }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" value="{{ $rol->slug }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <textarea class="form-control" name="descripcion" rows="3" readonly>{{ $rol->descripcion }}</textarea>
                        </div>
                        <hr>
                        <label>¿Acceso completo?</label> <br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="acceso_completo_si" name="acceso_completo" class="custom-control-input" value="SI" @if($rol->acceso_completo == 'SI') checked @elseif(old('acceso_completo') == 'SI') checked @endif disabled>
                            <label class="custom-control-label" for="acceso_completo_si">SI</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="acceso_completo_no" name="acceso_completo" class="custom-control-input" value="NO" @if($rol->acceso_completo == 'NO') checked @elseif(old('acceso_completo') == 'NO') checked @endif disabled>
                            <label class="custom-control-label" for="acceso_completo_no">NO</label>
                        </div>
                        <hr>
                        <label>Lista de permisos</label> <br>
                        @foreach ($permisos as $permiso)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck_{{ $permiso->id }}" name="permisos[]" value="{{ $permiso->id }}" @if(is_array(old('permisos')) && in_array("$permiso->id", old('permisos'))) checked @elseif(is_array($permiso_rol) && in_array("$permiso->id", $permiso_rol)) checked @endif disabled>
                                <label class="custom-control-label" for="customCheck_{{ $permiso->id }}">{{ $permiso->nombre }} <em><small>({{ $permiso->descripcion }})</small></em></label>
                            </div>
                        @endforeach
                        <hr>
                        <a class="btn btn-sm btn-success" href="{{ route('editarRol', $rol->id) }}">Editar</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('listarRoles') }}">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
