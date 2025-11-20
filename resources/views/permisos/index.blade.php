@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color:#FCCB00;">Listado de Permisos</h4>
        <a href="{{ route('permisos.create') }}" class="btn btn-primary">+ Nuevo Permiso</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table mg-table table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($permisos as $permiso)
                <tr>
                    <td>
                        {{ $permiso->empleado->user->nombres }}
                        {{ $permiso->empleado->user->apellido_paterno }}
                    </td>

                    <td>{{ $permiso->fecha_inicio }}</td>
                    <td>{{ $permiso->fecha_fin }}</td>
                    <td>{{ $permiso->motivo }}</td>

                    <td>
                        @php
                        $badgeClass = match ($permiso->estado) {
                        'PENDIENTE' => 'secondary',
                        'APROBADO' => 'success',
                        'RECHAZADO' => 'danger',
                        default => 'dark',
                        };
                        @endphp

                        <span class="badge bg-{{ $badgeClass }}">
                            {{ $permiso->estado }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('permisos.edit', $permiso) }}"
                            class="btn btn-sm btn-outline-secondary">
                            Editar
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No hay permisos registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection