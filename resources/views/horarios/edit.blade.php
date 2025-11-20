@extends('layouts.app')

@section('title', 'Editar Horario')

@section('content')

<div class="container d-flex justify-content-center">
    <div class="card shadow p-4 mg-card w-100" style="max-width: 700px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Editar Horario</h5>
            <a href="{{ route('horarios.index') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
        </div>

        <form action="{{ route('horarios.update', $horario) }}" method="POST" class="mg-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Empleado (opcional)</label>
                <select name="empleado_id" class="form-select">
                    <option value="">Horario general</option>

                    @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}"
                        {{ $horario->empleado_id == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->user->nombres ?? 'Sin nombre' }}
                        {{ $empleado->user->apellido_paterno ?? '' }}
                        {{ $empleado->user->apellido_materno ?? '' }}
                        ({{ $empleado->ci }})
                    </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Hora de Entrada</label>
                <input type="time" name="hora_entrada" class="form-control"
                    value="{{ $horario->hora_entrada }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hora de Salida</label>
                <input type="time" name="hora_salida" class="form-control"
                    value="{{ $horario->hora_salida }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre del Turno (opcional)</label>
                <input type="text" name="nombre_turno" class="form-control"
                    value="{{ $horario->nombre_turno }}">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Actualizar Horario</button>
                <a href="{{ route('horarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>

    </div>
</div>

@endsection