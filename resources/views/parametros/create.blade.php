@extends('layouts.app')

@section('title', 'Crear Parámetro')

@section('content')

<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow p-4 mg-card w-100" style="max-width: 600px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Nuevo Parámetro</h5>
            <a href="{{ route('parametros.index') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
        </div>

        <form action="{{ route('parametros.store') }}" method="POST" class="mg-form">
            @csrf

            <div class="mb-3">
                <label for="clave" class="form-label">Clave *</label>
                <input type="text" name="clave" id="clave"
                    class="form-control @error('clave') is-invalid @enderror"
                    value="{{ old('clave') }}"
                    placeholder="Ej: monto_por_falta" required>
                @error('clave')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion"
                    class="form-control"
                    value="{{ old('descripcion') }}"
                    placeholder="Descripción del parámetro">
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor (Bs)</label>
                <input type="number" name="valor" id="valor"
                    class="form-control @error('valor') is-invalid @enderror"
                    value="{{ old('valor') }}"
                    step="0.01" min="0">
                @error('valor')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('parametros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

        </form>

    </div>
</div>

@endsection