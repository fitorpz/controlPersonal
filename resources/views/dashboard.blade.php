@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <!-- Bienvenida -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-0">Bienvenido, {{ auth()->user()->nombres }}</h4>
        </div>
    </div>
</div>
@endsection