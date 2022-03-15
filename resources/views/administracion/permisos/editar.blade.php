@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar permiso</div>
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
                    <form action="{{ route('editarPermisoPost', $permiso->id) }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $permiso->nombre) }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug', $permiso->slug) }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" name="descripcion" rows="3" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">{{ old('descripcion', $permiso->descripcion) }}</textarea>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-sm btn-primary" value="GUARDAR">
                            <a class="btn btn-sm btn-danger" href="{{ route('listarPermisos') }}">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
