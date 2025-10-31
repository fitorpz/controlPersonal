@extends('layouts.app')

@section('title', 'Crear Parámetro')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h3 class="mb-4">Nuevo Parámetro</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('parametros.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="clave" class="form-label">Clave *</label>
                    <input type="text" name="clave" id="clave" class="form-control @error('clave') is-invalid @enderror"
                        value="{{ old('clave') }}" placeholder="Ej: monto_por_falta" required>
                    @error('clave')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control"
                        value="{{ old('descripcion') }}" placeholder="Descripción del parámetro">
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (Bs)</label>
                    <input type="number" name="valor" id="valor" class="form-control @error('valor') is-invalid @enderror"
                        value="{{ old('valor') }}" step="0.01" min="0">
                    @error('valor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('parametros.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection