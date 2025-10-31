@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="login-box text-center">
    <img src="{{ asset('logominigolden.png') }}" class="img-fluid" style="max-height: 200px;"><br><br>

    {{-- Mensajes de éxito o error del sistema --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif

    {{-- Formulario de inicio de sesión --}}
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="emailInput"
                placeholder="correo@empresa.com" required autofocus value="{{ old('email') }}">
            <label for="emailInput">Correo electrónico</label>
        </div>

        <div class="form-floating mb-4">
            <input type="password" name="password" class="form-control" id="passwordInput"
                placeholder="Contraseña" required>
            <label for="passwordInput">Contraseña</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>

        <button type="button" class="btn btn-outline-success w-100 mt-3"
            data-bs-toggle="modal" data-bs-target="#asistenciaModal">
            🟩 Marcar Asistencia
        </button>

        <button type="button" class="btn btn-outline-danger w-100 mt-2"
            data-bs-toggle="modal" data-bs-target="#salidaModal">
            🟥 Marcar Salida
        </button>
    </form>
</div>

{{-- MODAL: Marcar Asistencia --}}
<div class="modal fade" id="asistenciaModal" tabindex="-1" aria-labelledby="asistenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('asistencia.entrada') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-success" id="asistenciaModalLabel">Marcar Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código del Empleado</label>
                        <input type="text" name="codigo" id="codigo" class="form-control text-center"
                            placeholder="Ej: 1043" required>
                    </div>

                    <input type="hidden" name="ubicacion_marcaje" id="ubicacion_marcaje">
                    <p class="small text-muted">Tu ubicación se registrará automáticamente al marcar.</p>

                    <div class="text-center mt-3">
                        <h6 id="horaAsistencia" class="fw-bold"></h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Registrar Entrada</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: Marcar Salida --}}
<div class="modal fade" id="salidaModal" tabindex="-1" aria-labelledby="salidaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('asistencia.salida') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger" id="salidaModalLabel">Marcar Salida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="codigo_salida" class="form-label">Código del Empleado</label>
                        <input type="text" name="codigo" id="codigo_salida" class="form-control text-center"
                            placeholder="Ej: 1043" required>
                    </div>
                    <p class="small text-muted">Tu salida será registrada sin necesidad de iniciar sesión.</p>

                    <div class="text-center mt-3">
                        <h6 id="horaSalida" class="fw-bold"></h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100">Registrar Salida</button>
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

    .modal-content {
        border-radius: 15px;
    }

    .btn {
        border-radius: 10px;
    }

    #horaAsistencia,
    #horaSalida {
        font-size: 1.1rem;
        color: #555;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener ubicación del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    const url = `https://www.openstreetmap.org/?mlat=${lat}&mlon=${lon}`;
                    document.getElementById('ubicacion_marcaje').value = url;
                },
                function(error) {
                    console.warn("No se pudo obtener la ubicación del dispositivo.");
                }
            );
        }

        // Reloj en tiempo real dentro de los modales
        function actualizarReloj() {
            const ahora = new Date();
            const hora = ahora.toLocaleTimeString();
            document.getElementById('horaAsistencia').textContent = hora;
            document.getElementById('horaSalida').textContent = hora;
        }

        setInterval(actualizarReloj, 1000);
        actualizarReloj();
    });
</script>
@endpush