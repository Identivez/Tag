{{-- Hereda de la plantilla general --}}
@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-tools me-2"></i>@yield('crud-title', 'Gestión')
            </h5>
            @yield('crud-actions')
        </div>
        <div class="card-body">
            {{-- Zona de contenido para formularios, tablas, etc. --}}
            @yield('crud-content')
        </div>
    </div>
</div>
@endsection
