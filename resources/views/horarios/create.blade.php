@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear nuevo Horario</h2>

    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Empleado (opcional)</label>
            <select name="empleado_id" class="form-control">
                <option value="">Horario general</option>
                @foreach($empleados as $empleado)
                <option value="{{ $empleado->id }}">
                    {{ $empleado->user->nombres ?? 'Sin nombre' }}
                    {{ $empleado->user->apellido_paterno ?? '' }}
                    {{ $empleado->user->apellido_materno ?? '' }}
                    ({{ $empleado->ci }})
                </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Hora de Entrada</label>
            <input type="time" name="hora_entrada" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Hora de Salida</label>
            <input type="time" name="hora_salida" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nombre del Turno (opcional)</label>
            <input type="text" name="nombre_turno" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar Horario</button>
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection