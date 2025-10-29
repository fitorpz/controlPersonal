@extends('layouts.app')

@section('title', 'Registrar Permiso')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow p-4 w-100" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Registrar Permiso</h5>
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

        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf

            {{-- Empleado --}}
            <div class="mb-3">
                <label for="empleado_id" class="form-label">Empleado</label>
                <select name="empleado_id" id="empleado_id" class="form-select" required>
                    <option value="">-- Selecciona un empleado --</option>
                    @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}">
                        {{ $empleado->user->nombres }} {{ $empleado->user->apellido_paterno }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha inicio y fin --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                </div>
            </div>

            {{-- Motivo --}}
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo del Permiso</label>
                <textarea name="motivo" id="motivo" class="form-control" rows="3" required>{{ old('motivo') }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar Permiso</button>
            </div>
        </form>
    </div>
</div>
@endsection