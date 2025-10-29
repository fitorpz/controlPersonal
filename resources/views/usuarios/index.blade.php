@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

@php
$rol = auth()->user()->rol ?? null;
@endphp

@if ($rol !== 'administrador')
<div class="container mt-5 text-center">
    <h3 class="text-danger">🚫 Acceso denegado</h3>
    <p>No tienes permiso para ver este módulo.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Volver al inicio</a>
</div>
@else

<div class="container d-flex justify-content-between align-items-center mb-4" style="max-width: 1000px;">
    <h4 class="mb-0">Lista de usuarios</h4>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo Usuario</a>
</div>

@if(session('success'))
<div class="container" style="max-width: 1000px;">
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
</div>
@endif

<div class="container" style="max-width: 1000px;">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombres }}</td>
                    <td>{{ $usuario->apellido_paterno }}</td>
                    <td>{{ $usuario->apellido_materno }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ ucfirst($usuario->rol) }}</td>
                    <td>
                        @if ($usuario->estado === 'activo')
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No se encontraron usuarios.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif
@endsection