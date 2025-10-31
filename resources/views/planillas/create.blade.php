@extends('layouts.app')

@section('title', 'Generar Planilla')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h3 class="mb-4">Generar Planilla Mensual</h3>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    {{-- Mensaje de error --}}
    @if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('planillas.generar') }}">
                @csrf

                <div class="mb-3">
                    <label for="mes" class="form-label">Selecciona el Mes</label>
                    <input type="month" name="mes" id="mes" class="form-control @error('mes') is-invalid @enderror"
                        value="{{ old('mes', date('Y-m')) }}" required>

                    @error('mes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('planillas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Generar Planillas</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection