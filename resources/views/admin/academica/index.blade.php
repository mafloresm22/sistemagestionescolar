@extends('adminlte::page')

@section('title', 'Gestión Académica')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    <i class="fas fa-graduation-cap mr-2 text-primary"></i>Gestión Académica
                </h1>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid pb-4">
    <div class="row">
        <!-- COLUMNA DE ESTADÍSTICAS (Izquierda) -->
        <div class="col-md-3">
            <div class="stats-container">
                <!-- Card Periodos -->
                <div class="premium-card bg-gradient-primary slide-up" style="animation-delay: 0.1s">
                    <div class="premium-card-body">
                        <div class="icon-circle bg-white-transparent shadow-sm">
                            <i class="fas fa-calendar-alt text-primary"></i>
                        </div>
                        <div class="premium-card-info">
                            <h5 class="text-uppercase mb-0 opacity-8">Periodos</h5>
                            <h2 class="font-weight-bold mb-0 count-up">{{ $cant_periodos }}</h2>
                        </div>
                    </div>
                    <div class="premium-card-footer">
                        <small>Total registrados en el sistema</small>
                    </div>
                </div>

                <!-- Card Grados -->
                <div class="premium-card bg-gradient-info slide-up" style="animation-delay: 0.2s">
                    <div class="premium-card-body">
                        <div class="icon-circle bg-white-transparent shadow-sm">
                            <i class="fas fa-school text-info"></i>
                        </div>
                        <div class="premium-card-info">
                            <h5 class="text-uppercase mb-0 opacity-8">Grados</h5>
                            <h2 class="font-weight-bold mb-0 count-up">{{ $cant_grados }}</h2>
                        </div>
                    </div>
                    <div class="premium-card-footer">
                        <small>Configurados para esta gestión</small>
                    </div>
                </div>

                <!-- Card Paralelos -->
                <div class="premium-card bg-gradient-success slide-up" style="animation-delay: 0.3s">
                    <div class="premium-card-body">
                        <div class="icon-circle bg-white-transparent shadow-sm">
                            <i class="fas fa-users-cog text-success"></i>
                        </div>
                        <div class="premium-card-info">
                            <h5 class="text-uppercase mb-0 opacity-8">Paralelos</h5>
                            <h2 class="font-weight-bold mb-0 count-up">{{ $cant_paralelos }}</h2>
                        </div>
                    </div>
                    <div class="premium-card-footer">
                        <small>Divisiones por grado</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- COLUMNA DE TABS (Derecha) -->
        <div class="col-md-9">
            <div class="card card-outline card-primary shadow-premium border-0 fade-in" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header p-0 border-bottom-0 bg-white">
                    <ul class="nav nav-pills custom-pills p-2" id="academica-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.periodos.*') || request()->routeIs('admin.academicas.index') ? 'active active-premium' : '' }}" 
                               href="{{ route('admin.periodos.index') }}">
                                <i class="fas fa-clock mr-2"></i>Periodos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.grados.*') ? 'active active-premium' : '' }}" 
                               href="{{ route('admin.grados.index') }}">
                                <i class="fas fa-layer-group mr-2"></i>Grados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.secciones.*') ? 'active active-premium' : '' }}" 
                               href="{{ route('admin.secciones.index') }}">
                                <i class="fas fa-list-ul mr-2"></i>Paralelos
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body bg-light-soft p-4">
                    <div class="tab-content transition-content">
                        @if(request()->routeIs('admin.periodos.*') || request()->routeIs('admin.academicas.index'))
                            <div class="fade-in-content">
                                @include('admin.academica.periodos.index')
                            </div>
                        @elseif(request()->routeIs('admin.grados.*'))
                            <div class="fade-in-content">
                                @include('admin.academica.grados.index')
                            </div>
                        @elseif(request()->routeIs('admin.secciones.*'))
                            <div class="fade-in-content">
                                @include('admin.academica.paralelos.index')
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-tools fa-4x text-gray-300 mb-3"></i>
                                <h3 class="text-gray-500">Módulo en construcción</h3>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales de Periodos --}}
@isset($gestions)
    @include('admin.academica.periodos.create')
    @include('admin.academica.periodos.edit')
@endisset

{{-- Modales de Grados --}}
@isset($niveles)
    @include('admin.academica.grados.create')
    @include('admin.academica.grados.edit')
@endisset

{{-- Modales de Paralelos --}}
@isset($secciones)
    @include('admin.academica.paralelos.create')
    @include('admin.academica.paralelos.edit')
@endisset

@push('css')
<style>
    /* VARIABLES & FUNDAMENTALS */
    :root {
        --premium-shadow: 0 10px 30px rgba(0,0,0,0.08);
        --transition-speed: 0.3s;
    }

    .bg-light-soft { background-color: #f8f9fc; }
    .shadow-premium { box-shadow: var(--premium-shadow) !important; }

    /* PREMIUM CARDS */
    .premium-card {
        border-radius: 12px;
        color: white;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: none;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .premium-card-body {
        padding: 25px;
        display: flex;
        align-items: center;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 20px;
    }

    .bg-white-transparent {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }

    .premium-card-footer {
        background: rgba(0, 0, 0, 0.05);
        padding: 10px 25px;
        font-size: 0.85rem;
    }

    /* CUSTOM PILLS & TABS */
    .custom-pills .nav-link {
        border-radius: 10px;
        color: #4e73df;
        font-weight: 600;
        margin-right: 5px;
        transition: all 0.3s;
        border: 2px solid transparent;
        padding: 10px 20px;
    }

    .custom-pills .nav-link:hover {
        background: rgba(78, 115, 223, 0.05);
    }

    .custom-pills .nav-link.active-premium {
        background: #4e73df !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }

    /* ANIMATIONS */
    .slide-up {
        animation: slideUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        opacity: 0;
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }

    .fade-in-content {
        animation: fadeInContent 0.5s ease-in-out forwards;
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInContent {
        from { opacity: 0; transform: scale(0.98); }
        to { opacity: 1; transform: scale(1); }
    }

    /* GLASSMORPHISM DECORATION */
    .premium-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        transition: 0.5s;
    }

    .premium-card:hover::after {
        left: 100%;
    }
</style>
@endpush
@stop
