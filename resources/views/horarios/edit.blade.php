@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Horario</h2>

    <form action="{{ route('horarios.update', $horario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Empleado (opcional)</label>
            <select name="empleado_id" class="form-control">
                <option value="">Horario general</option>
                @foreach($empleados as $empleado)
                <option value="{{ $empleado->id }}" {{ $horario->empleado_id == $empleado->id ? 'selected' : '' }}>
                    {{ $empleado->user->name ?? 'Sin nombre' }} ({{ $empleado->ci }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Hora de Entrada</label>
            <input type="time" name="hora_entrada" class="form-control" value="{{ $horario->hora_entrada }}" required>
        </div>

        <div class="mb-3">
            <label>Hora de Salida</label>
            <input type="time" name="hora_salida" class="form-control" value="{{ $horario->hora_salida }}" required>
        </div>

        <div class="mb-3">
            <label>Nombre del Turno (opcional)</label>
            <input type="text" name="nombre_turno" class="form-control" value="{{ $horario->nombre_turno }}">
        </div>

        <button type="submit" class="btn btn-success">Actualizar Horario</button>
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection