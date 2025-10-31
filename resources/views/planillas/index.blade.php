@extends('layouts.app')

@section('title', 'Planillas de Pago')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Planillas Generadas</h3>
        <a href="{{ route('planillas.create') }}" class="btn btn-primary">
            + Generar Planilla
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabla de planillas --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Empleado</th>
                    <th>Mes</th>
                    <th>Salario Base</th>
                    <th>Descuento</th>
                    <th>Bonos</th>
                    <th>Salario Neto</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($planillas as $planilla)
                <tr>
                    <td>{{ $planilla->empleado->user->name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($planilla->mes)->translatedFormat('F Y') }}</td>
                    <td>{{ number_format($planilla->salario_base, 2) }} Bs</td>
                    <td>{{ number_format($planilla->total_descuento, 2) }} Bs</td>
                    <td>{{ number_format($planilla->total_bonificacion, 2) }} Bs</td>
                    <td><strong>{{ number_format($planilla->salario_neto, 2) }} Bs</strong></td>
                    <td>
                        <a href="{{ route('planillas.show', $planilla) }}" class="btn btn-sm btn-outline-primary">
                            Ver Detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay planillas generadas aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection