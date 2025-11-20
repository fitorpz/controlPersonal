@extends('layouts.app')

@section('title', 'Editar Parámetro')

@section('content')

<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow p-4 mg-card w-100" style="max-width: 600px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Editar Parámetro</h5>
            <a href="{{ route('parametros.index') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
        </div>

        <form action="{{ route('parametros.update', $parametro) }}" method="POST" class="mg-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Clave</label>
                <input type="text" class="form-control" value="{{ $parametro->clave }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" value="{{ $parametro->descripcion }}" disabled>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor (Bs)</label>
                <input type="number" name="valor" id="valor"
                    class="form-control @error('valor') is-invalid @enderror"
                    value="{{ old('valor', $parametro->valor) }}"
                    step="0.01" min="0" placeholder="Ej: 50.00">

                @error('valor')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('parametros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

        </form>

    </div>
</div>

@endsection