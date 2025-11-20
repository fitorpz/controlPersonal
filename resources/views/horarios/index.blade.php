@extends('layouts.app')

@section('title', 'Listado de Horarios')

@section('content')

<div class="container" style="max-width: 1000px;">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 text-center text-md-start">
        <h2 class="mb-3 mb-md-0" style="color:#FCCB00;">Listado de Horarios</h2>
        <a href="{{ route('horarios.create') }}" class="btn btn-primary">+ Crear nuevo horario</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table mg-table table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Hora Entrada</th>
                    <th>Hora Salida</th>
                    <th>Nombre Turno</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($horarios as $horario)
                <tr>
                    <td>
                        {{ $horario->empleado?->user?->nombres ?? 'General' }}
                        {{ $horario->empleado?->user?->apellido_paterno ?? '' }}
                    </td>

                    <td>{{ $horario->hora_entrada }}</td>
                    <td>{{ $horario->hora_salida }}</td>
                    <td>{{ $horario->nombre_turno ?? '-' }}</td>

                    <td>
                        <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('horarios.destroy', $horario) }}"
                            method="POST"
                            style="display:inline-block;"
                            onsubmit="return confirm('¿Eliminar este horario?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No hay horarios registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection