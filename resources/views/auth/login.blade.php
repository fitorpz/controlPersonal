@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="login-box text-center">
    <img src="{{ asset('logominigolden.png') }}" class="img-fluid" style="max-height: 200px;"><br><br>

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="emailInput" placeholder="correo@empresa.com" required autofocus value="{{ old('email') }}">
            <label for="emailInput">Correo electrónico</label>
        </div>

        <div class="form-floating mb-4">
            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Contraseña" required>
            <label for="passwordInput">Contraseña</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        <button type="button" class="btn btn-outline-secondary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#asistenciaModal">
            Marcar Asistencia
        </button>
        <button type="button" class="btn btn-outline-secondary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#salidaModal">
            Marcar Salida
        </button>

    </form>
</div>
<!-- Modal de Marcaje de Asistencia -->
<div class="modal fade" id="asistenciaModal" tabindex="-1" aria-labelledby="asistenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('asistencia.entrada') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asistenciaModalLabel">Marcar Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ci" class="form-label">Cédula de Identidad</label>
                        <input type="text" name="ci" id="ci" class="form-control" required>
                    </div>

                    <input type="hidden" name="ubicacion_marcaje" id="ubicacion_marcaje">
                    <p class="small text-muted">Tu ubicación se registrará automáticamente al marcar.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Registrar Entrada</button>
                </div>


            </div>
        </form>
    </div>
</div>

<!-- Modal de Marcaje de Salida -->
<div class="modal fade" id="salidaModal" tabindex="-1" aria-labelledby="salidaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('asistencia.salida') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salidaModalLabel">Marcar Salida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ci_salida" class="form-label">Cédula de Identidad</label>
                        <input type="text" name="ci" id="ci_salida" class="form-control" required>
                    </div>
                    <p class="small text-muted">Tu salida será registrada sin necesidad de iniciar sesión.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Registrar Salida</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@push('styles')
<style>
    .login-box {
        max-width: 400px;
        margin: auto;
        margin-top: 80px;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    .logo-img {
        max-height: 80px;
        margin-bottom: 20px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const url = `https://www.openstreetmap.org/?mlat=${lat}&mlon=${lon}`;
            document.getElementById('ubicacion_marcaje').value = url;
        }, function(error) {
            console.warn("No se pudo obtener la ubicación.");
        });
    });
</script>

@endpush