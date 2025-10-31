@extends('layouts.app')

@section('title', 'Registrar Nuevo Empleado')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow p-4 w-100" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Registrar Nuevo Empleado</h5>
            <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
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

        <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Usuario --}}
            <div class="mb-3">
                <label for="user_id" class="form-label">Usuario del Sistema</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Selecciona un usuario --</option>
                    @foreach ($usuarios as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Foto --}}
            <div class="mb-3">
                <label for="foto" class="form-label">Foto del Empleado (opcional)</label>
                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
            </div>

            {{-- Edad --}}
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad') }}" required>
            </div>

            {{-- CI --}}
            <div class="mb-3">
                <label for="ci" class="form-label">Cédula de Identidad</label>
                <input type="text" name="ci" id="ci" class="form-control" value="{{ old('ci') }}" required>
            </div>

            {{-- Codigo --}}
            <div class="form-group">
                <label for="codigo">Código (autogenerado)</label>
                <input type="text" class="form-control" name="codigo_visible" id="codigo_visible" value="{{ $codigo }}" disabled>
                <input type="hidden" name="codigo" value="{{ $codigo }}">
            </div>

            {{-- Celular --}}
            <div class="mb-3">
                <label for="celular" class="form-label">Número de Celular</label>
                <input type="text" name="celular" id="celular" class="form-control" value="{{ old('celular') }}" required>
            </div>

            {{-- salario --}}
            <div class="mb-3">
                <label for="salario_mensual" class="form-label">Salario Mensual</label>
                <input type="number" name="salario_mensual" class="form-control" id="salario_mensual"
                    value="{{ old('salario_mensual', $empleado->salario_mensual ?? '') }}" step="0.01" required>
            </div>

            {{-- Fechas --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_retiro" class="form-label">Fecha de Retiro (opcional)</label>
                    <input type="date" name="fecha_retiro" id="fecha_retiro" class="form-control">
                </div>
            </div>

            {{-- Referencia 1 --}}
            <div class="mb-3">
                <label for="referencia_1_nombre" class="form-label">Nombre Completo Referencia Familiar 1</label>
                <input type="text" name="referencia_1_nombre" id="referencia_1_nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="referencia_1_celular" class="form-label">Celular Referencia 1</label>
                <input type="text" name="referencia_1_celular" id="referencia_1_celular" class="form-control" required>
            </div>

            {{-- Referencia 2 --}}
            <div class="mb-3">
                <label for="referencia_2_nombre" class="form-label">Nombre Completo Referencia Familiar 2 (opcional)</label>
                <input type="text" name="referencia_2_nombre" id="referencia_2_nombre" class="form-control">
            </div>

            <div class="mb-3">
                <label for="referencia_2_celular" class="form-label">Celular Referencia 2 (opcional)</label>
                <input type="text" name="referencia_2_celular" id="referencia_2_celular" class="form-control">
            </div>

            {{-- Ubicación por enlace --}}
            <div class="mb-3">
                <label for="ubicacion_domicilio" class="form-label">Ubicación de Domicilio (enlace de Google Maps)</label>
                <input type="url" name="ubicacion_domicilio" id="ubicacion_domicilio" class="form-control"
                    placeholder="https://maps.app.goo.gl/..." value="{{ old('ubicacion_domicilio') }}" required>
                <small class="text-muted">
                    Desde tu celular: abre Google Maps → mantén presionado tu domicilio → presiona “Compartir” → “Copiar enlace” → pega aquí.
                </small>
            </div>


            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar Empleado</button>
            </div>
        </form>
    </div>
</div>
@endsection