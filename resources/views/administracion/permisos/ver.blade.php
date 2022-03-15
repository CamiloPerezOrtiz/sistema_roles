@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ver permiso</div>
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
                            <input type="text" class="form-control" name="nombre" value="{{ $permiso->nombre }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" value="{{ $permiso->slug }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <textarea class="form-control" name="descripcion" rows="3" readonly>{{ $permiso->descripcion }}</textarea>
                        </div>
                        <hr>
                        <a class="btn btn-sm btn-success" href="{{ route('editarPermiso', $permiso->id) }}">Editar</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('listarPermisos') }}">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
