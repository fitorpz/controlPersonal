@extends('layouts.app')

@section('title', 'Parámetros Personalizados por Empleado')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <h3 class="mb-4">
        Parámetros Personalizados – {{ $empleado->user->name ?? 'Empleado' }}
    </h3>

    <div class="alert alert-info">
        <strong>Nota:</strong> Si dejas un campo vacío, se aplicará el valor general.
    </div>

    <form method="POST" action="{{ route('parametros.empleado.update', $empleado) }}">
        @csrf

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
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
                        <td>{{ $parametro->valor !== null ? number_format($parametro->valor, 2) . ' Bs' : '-' }}</td>
                        <td>
                            <input type="number"
                                name="{{ $clave }}"
                                class="form-control"
                                value="{{ old($clave, $valorPersonalizado) }}"
                                step="0.01"
                                min="0"
                                placeholder="Ej: 100.00">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('parametros.index') }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>
    </form>
</div>
@endsection