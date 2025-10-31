@extends('layouts.app')

@section('title', 'Detalle de Planilla')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <h3 class="mb-4">Detalle de Planilla</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $planilla->empleado->user->name ?? 'Empleado' }}</h5>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Mes:</strong> {{ \Carbon\Carbon::parse($planilla->mes)->translatedFormat('F Y') }}</li>
                <li class="list-group-item"><strong>Salario Base:</strong> {{ number_format($planilla->salario_base, 2) }} Bs</li>
                <li class="list-group-item"><strong>Días Trabajados:</strong> {{ $planilla->dias_trabajados }}</li>
                <li class="list-group-item"><strong>Faltas:</strong> {{ $planilla->faltas }}</li>
                <li class="list-group-item"><strong>Retrasos:</strong> {{ $planilla->retrasos }}</li>
                <li class="list-group-item"><strong>Horas Extra:</strong> {{ $planilla->horas_extra }}</li>
                <li class="list-group-item"><strong>Total Descuento:</strong> {{ number_format($planilla->total_descuento, 2) }} Bs</li>
                <li class="list-group-item"><strong>Total Bonificación:</strong> {{ number_format($planilla->total_bonificacion, 2) }} Bs</li>
                <li class="list-group-item"><strong>Salario Neto:</strong> <strong>{{ number_format($planilla->salario_neto, 2) }} Bs</strong></li>
                <li class="list-group-item"><strong>Estado:</strong> {{ $planilla->estado }}</li>
            </ul>

            <h6 class="mt-4">Detalle de Descuentos:</h6>
            <p>{{ $planilla->detalle_descuento ?: '—' }}</p>

            <h6 class="mt-3">Detalle de Bonificaciones:</h6>
            <p>{{ $planilla->detalle_bonificacion ?: '—' }}</p>

            <div class="mt-4">
                <a href="{{ route('planillas.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection