@extends('layouts.app')

@section('title', 'Editar Parámetro')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h3 class="mb-4">Editar Parámetro</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('parametros.update', $parametro) }}" method="POST">
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
                    <input type="number" name="valor" id="valor" class="form-control @error('valor') is-invalid @enderror"
                        value="{{ old('valor', $parametro->valor) }}" step="0.01" min="0" placeholder="Ej: 50.00">

                    @error('valor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('parametros.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection