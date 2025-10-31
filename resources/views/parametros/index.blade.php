@extends('layouts.app')

@section('title', 'Parámetros del Sistema')

@section('content')
<div class="container mt-4">
    {{-- Título y botón de nuevo parámetro --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Parámetros Generales del Sistema</h3>
        <a href="{{ route('parametros.create') }}" class="btn btn-success">
            + Nuevo Parámetro
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabla de parámetros generales --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Clave</th>
                    <th>Descripción</th>
                    <th>Valor Actual</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parametros as $parametro)
                <tr>
                    <td><strong>{{ $parametro->clave }}</strong></td>
                    <td>{{ $parametro->descripcion ?? 'Sin descripción' }}</td>
                    <td>
                        @if($parametro->valor !== null)
                        {{ number_format($parametro->valor, 2) }} Bs
                        @else
                        <em class="text-muted">No asignado</em>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('parametros.edit', $parametro) }}" class="btn btn-sm btn-primary">
                            Editar
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No hay parámetros configurados aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Sección de parámetros personalizados --}}
    <h4 class="mt-5 mb-3">Parámetros Personalizados por Empleado</h4>
    <p class="text-muted">Haz clic en un empleado para configurar valores específicos que sobreescriban los generales.</p>

    <div class="row row-cols-1 row-cols-md-3 g-3">
        @forelse ($empleados as $empleado)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">{{ $empleado->user->nombres ?? 'Sin nombre' }}</h6>
                    <p class="card-text mb-1">
                        <strong>CI:</strong> {{ $empleado->ci }}<br>
                        <strong>Código:</strong> {{ $empleado->codigo }}<br>
                        <strong>Salario:</strong> {{ number_format($empleado->salario_mensual ?? 0, 2) }} Bs
                    </p>
                    <a href="{{ route('parametros.empleado', $empleado) }}" class="btn btn-sm btn-outline-secondary mt-2">
                        Configurar Parámetros
                    </a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">No hay empleados registrados.</p>
        @endforelse
    </div>
</div>
@endsection