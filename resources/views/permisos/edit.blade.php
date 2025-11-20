@extends('layouts.app')

@section('title', 'Editar Permiso')

@section('content')

<div class="container d-flex justify-content-center">

    <div class="card shadow p-4 w-100 mg-card" style="max-width: 700px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Editar Permiso</h5>
            <a href="{{ route('permisos.index') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('permisos.update', $permiso) }}" method="POST" class="mg-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Empleado</label>
                <input type="text"
                    class="form-control"
                    value="{{ $permiso->empleado->user->nombres }} {{ $permiso->empleado->user->apellido_paterno }}"
                    disabled>
                <input type="hidden" name="empleado_id" value="{{ $permiso->empleado_id }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date"
                        name="fecha_inicio"
                        id="fecha_inicio"
                        class="form-control"
                        value="{{ $permiso->fecha_inicio }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input type="date"
                        name="fecha_fin"
                        id="fecha_fin"
                        class="form-control"
                        value="{{ $permiso->fecha_fin }}"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo del Permiso</label>
                <textarea name="motivo"
                    id="motivo"
                    class="form-control"
                    rows="3"
                    required>{{ $permiso->motivo }}</textarea>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="PENDIENTE" {{ $permiso->estado == 'PENDIENTE'  ? 'selected' : '' }}>PENDIENTE</option>
                    <option value="APROBADO" {{ $permiso->estado == 'APROBADO'   ? 'selected' : '' }}>APROBADO</option>
                    <option value="RECHAZADO" {{ $permiso->estado == 'RECHAZADO'  ? 'selected' : '' }}>RECHAZADO</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario (opcional)</label>
                <textarea name="comentario"
                    id="comentario"
                    class="form-control"
                    rows="2">{{ $permiso->comentario }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Actualizar Permiso</button>
            </div>

        </form>

    </div>

</div>

@endsection