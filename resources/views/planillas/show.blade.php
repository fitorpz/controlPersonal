@extends('layouts.app')

@section('title', 'Detalle de Planilla')

@section('content')

<div class="container mt-4" style="max-width: 700px;">

    <h4 class="mb-4" style="color:#FCCB00;">Detalle de Planilla</h4>

    <div class="card shadow-sm mg-card">
        <div class="card-body">

            <h5 class="card-title mb-3" style="color:#FCCB00;">
                {{ $planilla->empleado->user->name ?? 'Empleado' }}
            </h5>

            <ul class="list-group list-group-flush mb-3 mg-card" style="background:none;border:none;">
                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Mes:</strong>
                    {{ \Carbon\Carbon::parse($planilla->mes)->translatedFormat('F Y') }}
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Salario Base:</strong>
                    {{ number_format($planilla->salario_base, 2) }} Bs
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Días Trabajados:</strong> {{ $planilla->dias_trabajados }}
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Faltas:</strong> {{ $planilla->faltas }}
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Retrasos:</strong> {{ $planilla->retrasos }}
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Horas Extra:</strong> {{ $planilla->horas_extra }}
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Total Descuento:</strong>
                    {{ number_format($planilla->total_descuento, 2) }} Bs
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Total Bonificación:</strong>
                    {{ number_format($planilla->total_bonificacion, 2) }} Bs
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Salario Neto:</strong>
                    <span style="color:#FCCB00;font-weight:bold;">
                        {{ number_format($planilla->salario_neto, 2) }} Bs
                    </span>
                </li>

                <li class="list-group-item bg-transparent text-white border-secondary">
                    <strong>Estado:</strong> {{ $planilla->estado }}
                </li>
            </ul>

            <h6 class="mt-4" style="color:#FCCB00;">Detalle de Descuentos:</h6>
            <p>{{ $planilla->detalle_descuento ?: '—' }}</p>

            <h6 class="mt-3" style="color:#FCCB00;">Detalle de Bonificaciones:</h6>
            <p>{{ $planilla->detalle_bonificacion ?: '—' }}</p>

            <div class="mt-4 text-end">
                <a href="{{ route('planillas.index') }}" class="btn btn-outline-secondary">Volver</a>
            </div>

        </div>
    </div>

</div>

@endsection