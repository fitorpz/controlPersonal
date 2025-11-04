<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema')</title>
    <link rel="shortcut icon" href="{{ asset('logominigolden.png') }}" type="image/x-icon">

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Estilos globales -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: rgba(193, 216, 247, 1);
        }

        .navbar-brand img {
            height: 60px;
        }

        .navbar {
            background-color: rgba(147, 176, 229, 1);
        }

        main {
            margin-top: 70px;
        }
    </style>

    @stack('styles')
</head>

<body>
    @auth
    @php
    $rol = Auth::user()->rol;
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('logominigolden.png') }}" alt="Logo" class="me-2">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    @if($rol === 'administrador')
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('usuarios.*') ? 'active fw-semibold' : '' }}" href="{{ route('usuarios.index') }}">
                            Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('empleados.*') ? 'active fw-semibold' : '' }}" href="{{ route('empleados.index') }}">
                            Registro de Empleados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('horarios.*') ? 'active fw-semibold' : '' }}" href="{{ route('horarios.index') }}">
                            Horarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('parametros.*') ? 'active fw-semibold' : '' }}" href="{{ route('parametros.index') }}">
                            Parámetros
                        </a>
                    </li>
                    @endif

                    @if(in_array($rol, ['administrador', 'operador', 'usuario']))
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('asistencias.*') ? 'active fw-semibold' : '' }}" href="{{ route('asistencias.index') }}">
                            Asistencias
                        </a>
                    </li>
                    @endif

                    @if(in_array($rol, ['administrador', 'operador']))
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('permisos.*') ? 'active fw-semibold' : '' }}" href="{{ route('permisos.index') }}">
                            Permisos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('planillas.*') ? 'active fw-semibold' : '' }}" href="{{ route('planillas.index') }}">
                            Planillas
                        </a>
                    </li>
                    @endif
                </ul>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>
    <br><br><br><br>
    @endauth

    {{-- Contenido principal --}}
    @yield('content')

    <!-- Scripts globales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    @yield('scripts')
</body>

</html>