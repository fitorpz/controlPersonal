@extends('layouts.app')

@section('title', 'Parámetros del Sistema')

@section('content')

<div class="container mt-4" style="max-width: 1100px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0" style="color:#FCCB00;">Parámetros Generales del Sistema</h3>
        <a href="{{ route('parametros.create') }}" class="btn btn-primary">
            + Nuevo Parámetro
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table mg-table table-bordered table-hover align-middle text-center">
            <thead>
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
                        <a href="{{ route('parametros.edit', $parametro) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No hay parámetros configurados aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h4 class="mt-5 mb-3" style="color:#FCCB00;">Parámetros Personalizados por Empleado</h4>
    <p style="color:#FCCB00;">Haz clic en un empleado para configurar valores específicos que sobreescriban los generales.</p>

    <div class="row row-cols-1 row-cols-md-3 g-3">

        @forelse ($empleados as $empleado)
        <div class="col">
            <div class="card h-100 mg-card p-3">

                <h6 class="mb-1">{{ $empleado->user->nombres ?? 'Sin nombre' }}</h6>

                <p class="mb-2">
                    <strong>CI:</strong> {{ $empleado->ci }}<br>
                    <strong>Código:</strong> {{ $empleado->codigo }}<br>
                    <strong>Salario:</strong> {{ number_format($empleado->salario_mensual ?? 0, 2) }} Bs
                </p>

                <a href="{{ route('parametros.empleado', $empleado) }}" class="btn btn-sm btn-outline-secondary">
                    Configurar Parámetros
                </a>

            </div>
        </div>

        @empty
        <p class="text-muted">No hay empleados registrados.</p>
        @endforelse

    </div>

</div>

@endsection