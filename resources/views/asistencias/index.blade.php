@extends('layouts.app')

@section('title', 'Asistencias Registradas')

@section('content')

<div class="container" style="max-width: 1000px;">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 text-center text-md-start">
        <h4 class="mb-3 mb-md-0" style="color:#FCCB00;">Asistencias</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table mg-table table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>C.I.</th>
                    <th>Fecha</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Estado</th>
                    <th>Ubicación</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($asistencias as $asistencia)
                <tr>
                    <td>
                        {{ $asistencia->empleado->user->nombres ?? 'Sin nombre' }}
                        {{ $asistencia->empleado->user->apellido_paterno ?? '' }}
                    </td>

                    <td>{{ $asistencia->empleado->ci }}</td>
                    <td>{{ $asistencia->fecha }}</td>
                    <td>{{ $asistencia->hora_entrada ?? '-' }}</td>
                    <td>{{ $asistencia->hora_salida ?? '-' }}</td>

                    <td>
                        @php
                        $badgeClass = match($asistencia->estado) {
                        'PRESENTE' => 'success',
                        'RETRASO' => 'warning',
                        'AUSENTE' => 'danger',
                        'SALIDA_ANTICIPADA' => 'secondary',
                        default => 'dark'
                        };
                        @endphp

                        <span class="badge bg-{{ $badgeClass }}">{{ $asistencia->estado }}</span>
                    </td>

                    <td>
                        @if($asistencia->ubicacion_marcaje)
                        <a href="{{ $asistencia->ubicacion_marcaje }}" target="_blank"
                            class="btn btn-sm btn-outline-secondary">
                            Ver mapa
                        </a>
                        @else
                        <span class="text-muted">No registrada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay asistencias registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection