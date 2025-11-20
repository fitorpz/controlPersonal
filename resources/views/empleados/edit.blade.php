@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')

<div class="container d-flex justify-content-center">
    <div class="card shadow p-4 mg-card w-100" style="max-width: 700px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Editar Empleado</h5>
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

        <form action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data" class="mg-form">
            @csrf
            @method('PUT')

            {{-- Usuario --}}
            <div class="mb-3">
                <label class="form-label">Usuario del Sistema</label>
                <input type="text" class="form-control" value="{{ $empleado->user->nombres ?? 'Sin nombre' }} {{ $empleado->user->apellido_paterno ?? '' }}" disabled>
                <input type="hidden" name="user_id" value="{{ $empleado->user_id }}">
            </div>

            {{-- Foto --}}
            <div class="mb-3">
                <label class="form-label">Foto Actual</label><br>
                @if($empleado->foto)
                <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto" width="80" class="rounded mb-2">
                @else
                <p class="text-muted">Sin foto</p>
                @endif
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted">Dejar en blanco si no deseas cambiar la foto.</small>
            </div>

            {{-- Edad --}}
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad', $empleado->edad) }}" required>
            </div>

            {{-- CI --}}
            <div class="mb-3">
                <label for="ci" class="form-label">Cédula de Identidad</label>
                <input type="text" name="ci" id="ci" class="form-control" value="{{ old('ci', $empleado->ci) }}" required>
            </div>

            {{-- Codigo --}}
            <div class="mb-3">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" class="form-control" value="{{ $empleado->codigo }}" readonly>
            </div>

            {{-- Celular --}}
            <div class="mb-3">
                <label for="celular" class="form-label">Celular</label>
                <input type="text" name="celular" id="celular" class="form-control" value="{{ old('celular', $empleado->celular) }}" required>
            </div>

            {{-- salario --}}
            <div class="mb-3">
                <label for="salario_mensual" class="form-label">Salario Mensual</label>
                <input type="number" name="salario_mensual" class="form-control" id="salario_mensual"
                    value="{{ old('salario_mensual', $empleado->salario_mensual ?? '') }}" step="0.01" required>
            </div>

            {{-- Fechas --}}
            <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', $empleado->fecha_ingreso) }}" required>
            </div>

            <div class="mb-3">
                <label for="fecha_retiro" class="form-label">Fecha de Retiro (opcional)</label>
                <input type="date" name="fecha_retiro" id="fecha_retiro" class="form-control" value="{{ old('fecha_retiro', $empleado->fecha_retiro) }}">
            </div>

            {{-- Referencia 1 --}}
            <div class="mb-3">
                <label for="referencia_1_nombre" class="form-label">Nombre Referencia Familiar 1</label>
                <input type="text" name="referencia_1_nombre" id="referencia_1_nombre" class="form-control" value="{{ old('referencia_1_nombre', $empleado->referencia_1_nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="referencia_1_celular" class="form-label">Celular Referencia 1</label>
                <input type="text" name="referencia_1_celular" id="referencia_1_celular" class="form-control" value="{{ old('referencia_1_celular', $empleado->referencia_1_celular) }}" required>
            </div>

            {{-- Referencia 2 --}}
            <div class="mb-3">
                <label for="referencia_2_nombre" class="form-label">Nombre Referencia Familiar 2</label>
                <input type="text" name="referencia_2_nombre" id="referencia_2_nombre" class="form-control" value="{{ old('referencia_2_nombre', $empleado->referencia_2_nombre) }}">
            </div>

            <div class="mb-3">
                <label for="referencia_2_celular" class="form-label">Celular Referencia 2</label>
                <input type="text" name="referencia_2_celular" id="referencia_2_celular" class="form-control" value="{{ old('referencia_2_celular', $empleado->referencia_2_celular) }}">
            </div>

            {{-- Ubicación --}}
            <div class="mb-3">
                <label for="ubicacion_domicilio" class="form-label">Ubicación de Domicilio</label>
                <textarea name="ubicacion_domicilio" id="ubicacion_domicilio" class="form-control" rows="2">{{ old('ubicacion_domicilio', $empleado->ubicacion_domicilio) }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
            </div>
        </form>

    </div>
</div>

@endsection