@extends('layouts.app')

@section('title', 'Parámetros Personalizados por Empleado')

@section('content')

<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow p-4 mg-card w-100" style="max-width: 800px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                Parámetros Personalizados –
                {{ $empleado->user->nombres ?? '' }}
                {{ $empleado->user->apellido_paterno ?? '' }}
            </h5>

            <a href="{{ route('parametros.index') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
        </div>

        <div class="alert alert-info">
            <strong>Nota:</strong> Si dejas un campo vacío, se aplicará el valor general.
        </div>

        <form method="POST" action="{{ route('parametros.empleado.update', $empleado) }}" class="mg-form">
            @csrf

            <div class="table-responsive">
                <table class="table mg-table table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Descripción</th>
                            <th>Valor General</th>
                            <th>Personalizado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($parametrosGenerales as $parametro)
                        @php
                        $clave = $parametro->clave;
                        $valorPersonalizado = $parametrosEmpleado[$clave]->valor ?? null;
                        @endphp

                        <tr>
                            <td><strong>{{ $clave }}</strong></td>

                            <td>{{ $parametro->descripcion ?? '-' }}</td>

                            <td>
                                @if($parametro->valor !== null)
                                {{ number_format($parametro->valor, 2) }} Bs
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <input type="number"
                                    name="{{ $clave }}"
                                    class="form-control"
                                    value="{{ old($clave, $valorPersonalizado) }}"
                                    step="0.01" min="0"
                                    placeholder="Ej: 100.00">
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('parametros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

        </form>

    </div>
</div>

@endsection