@extends('layouts.app')

@section('title', 'Lista de Empleados')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Lista de Empleados</h3>
        <a href="{{ route('empleados.create') }}" class="btn btn-primary">+ Nuevo Empleado</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($empleados->isEmpty())
    <p>No hay empleados registrados.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nombre Completo</th>
                    <th>CI</th>
                    <th>Código</th>
                    <th>Celular</th>
                    <th>Edad</th>
                    <th>Ingreso</th>
                    <th>Retiro</th>
                    <th>Referencia 1</th>
                    <th>Referencia 2</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $empleado)
                <tr>
                    {{-- Foto --}}
                    <td>
                        @if($empleado->foto)
                        <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto" width="50" height="50" class="rounded-circle">
                        @else
                        <span class="text-muted">Sin foto</span>
                        @endif
                    </td>

                    {{-- Nombre completo del usuario relacionado --}}
                    <td>
                        {{ $empleado->user->nombres ?? '' }}
                        {{ $empleado->user->apellido_paterno ?? '' }}
                        {{ $empleado->user->apellido_materno ?? '' }}
                    </td>

                    <td>{{ $empleado->ci }}</td>
                    <td>{{ $empleado->codigo }}</td>
                    <td>{{ $empleado->celular }}</td>
                    <td>{{ $empleado->edad }}</td>
                    <td>{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td>
                        @if ($empleado->fecha_retiro)
                        {{ \Carbon\Carbon::parse($empleado->fecha_retiro)->format('d/m/Y') }}
                        @else
                        <span class="text-muted">Activo</span>
                        @endif
                    </td>

                    {{-- Referencia 1 --}}
                    <td>
                        <strong>{{ $empleado->referencia_1_nombre }}</strong><br>
                        <small>{{ $empleado->referencia_1_celular }}</small>
                    </td>

                    {{-- Referencia 2 --}}
                    <td>
                        @if ($empleado->referencia_2_nombre)
                        <strong>{{ $empleado->referencia_2_nombre }}</strong><br>
                        <small>{{ $empleado->referencia_2_celular }}</small>
                        @else
                        <span class="text-muted">No registrada</span>
                        @endif
                    </td>

                    {{-- Ubicación --}}
                    <td>
                        @if ($empleado->ubicacion_domicilio)
                        <a href="{{ $empleado->ubicacion_domicilio }}" target="_blank" class="btn btn-sm btn-outline-primary">Ver</a>
                        @else
                        <span class="text-muted">No registrada</span>
                        @endif
                    </td>

                    {{-- Acciones --}}
                    <td>
                        <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection