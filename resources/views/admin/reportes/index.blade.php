@extends('adminlte::page')

@section('title', 'Panel de Reportes Académicos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-chart-line mr-2 text-primary"></i>
            Reportes y Estadísticas
        </h1>
        <p class="text-muted mb-0">Visualización detallada del estado académico y administrativo.</p>
    </div>
    <div class="d-flex align-items-center">
        <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm hover-lift mr-2">
            <i class="fas fa-print mr-2"></i> Imprimir Reporte
        </button>
        <span class="badge badge-primary-soft px-3 py-2 border">
            <i class="fas fa-calendar-day mr-2"></i>{{ date('d M Y') }}
        </span>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">

    {{-- TARJETAS DE RESUMEN --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white shadow-sm border-0 animate__animated animate__zoomIn" style="border-radius: 15px;">
                <div class="inner p-4">
                    <h3 class="text-primary font-weight-bold mb-0">{{ $totalEstudiantes }}</h3>
                    <p class="text-muted font-weight-bold text-uppercase small mb-0">Estudiantes Registrados</p>
                </div>
                <div class="icon text-primary-soft" style="opacity: 0.2;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="#" class="small-box-footer bg-light text-primary border-top" style="border-radius: 0 0 15px 15px;">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white shadow-sm border-0 animate__animated animate__zoomIn" style="border-radius: 15px; animation-delay: 0.1s;">
                <div class="inner p-4">
                    <h3 class="text-success font-weight-bold mb-0">{{ $totalMatriculados }}</h3>
                    <p class="text-muted font-weight-bold text-uppercase small mb-0">Matrículas Activas</p>
                </div>
                <div class="icon text-success-soft" style="opacity: 0.2;">
                    <i class="fas fa-id-card"></i>
                </div>
                <a href="#" class="small-box-footer bg-light text-success border-top" style="border-radius: 0 0 15px 15px;">
                    Gestionar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white shadow-sm border-0 animate__animated animate__zoomIn" style="border-radius: 15px; animation-delay: 0.2s;">
                <div class="inner p-4">
                    <h3 class="text-warning font-weight-bold mb-0">S/. {{ number_format($totalIngresos, 2) }}</h3>
                    <p class="text-muted font-weight-bold text-uppercase small mb-0">Ingresos Totales</p>
                </div>
                <div class="icon text-warning-soft" style="opacity: 0.2;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer bg-light text-warning border-top" style="border-radius: 0 0 15px 15px;">
                    Ver Caja <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white shadow-sm border-0 animate__animated animate__zoomIn" style="border-radius: 15px; animation-delay: 0.3s;">
                <div class="inner p-4">
                    <h3 class="text-info font-weight-bold mb-0">{{ $estudiantesPorNivel->count() }}</h3>
                    <p class="text-muted font-weight-bold text-uppercase small mb-0">Niveles Educativos</p>
                </div>
                <div class="icon text-info-soft" style="opacity: 0.2;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer bg-light text-info border-top" style="border-radius: 0 0 15px 15px;">
                    Ver Estructura <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- GRAFICO: DISTRIBUCION DE NOTAS --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInLeft" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-star mr-2 text-warning"></i>Rendimiento Académico General
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light border">Escala Literal Peruanal</span>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartNotas" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        {{-- GRAFICO: ESTADO MATRICULA --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInRight" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-check-circle mr-2 text-success"></i>Estado de Matrículas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <canvas id="chartMatricula" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <div class="col-md-5">
                            <ul class="list-group list-group-unbordered">
                                @foreach($estadosMatricula as $estado)
                                <li class="list-group-item border-0 px-0 py-2 d-flex justify-content-between">
                                    <span class="small font-weight-bold"><i class="fas fa-circle mr-1 text-primary"></i> {{ $estado->estadoMatriculacion }}</span>
                                    <span class="badge badge-primary-soft text-primary">{{ $estado->total }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- GRAFICO: GENERO --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-venus-mars mr-2 text-secondary"></i>Diversidad de Género
                    </h3>
                </div>
                <div class="card-body text-center">
                    <canvas id="chartGenero" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    <div class="mt-3">
                        @foreach($generos as $g)
                        <span class="mx-2 small font-weight-bold">
                            {{ $g->generoEstudiante }}: {{ $g->total }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFICO: INGRESOS --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; animation-delay: 0.1s;">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-chart-area mr-2 text-primary"></i>Recaudación Mensual (Últimos 6 Meses)
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="chartIngresos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- GRAFICO: ESTUDIANTES POR NIVEL --}}
        <div class="col-md-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; animation-delay: 0.2s;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-school mr-2 text-info"></i>Estudiantes por Nivel Educativo
                    </h3>
                    <span class="text-muted small">Datos actualizados de matriculaciones vigentes</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <canvas id="chartNiveles" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                        </div>
                        <div class="col-md-3 border-left d-flex flex-column justify-content-center px-4">
                            @foreach($estudiantesPorNivel as $nivel)
                            <div class="mb-4">
                                <label class="d-block small font-weight-bold mb-1">{{ $nivel->nombreNivel }}</label>
                                <div class="progress rounded-pill shadow-none border" style="height: 12px;">
                                    @php $porcentaje = ($nivel->total / max($totalEstudiantes, 1)) * 100; @endphp
                                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" 
                                         style="width: {{ $porcentaje }}%" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="small text-muted">{{ $nivel->total }} estudiantes ({{ round($porcentaje, 1) }}%)</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('css')
<style>
    .bg-primary-soft { background-color: #e7f1ff; color: #007bff; }
    .bg-success-soft { background-color: #e8f5e9; color: #28a745; }
    .bg-warning-soft { background-color: #fff8e1; color: #ffc107; }
    .bg-info-soft { background-color: #e0f7fa; color: #17a2b8; }
    .badge-primary-soft { background-color: #e7f1ff; color: #007bff; border-color: #cfe2ff !important; }
    
    .text-primary-soft { color: #007bff; }
    .text-success-soft { color: #28a745; }
    .text-warning-soft { color: #ffc107; }
    .text-info-soft { color: #17a2b8; }

    .hover-lift { transition: all 0.3s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; }

    @media print {
        .main-sidebar, .main-header, .btn-outline-secondary, .card-tools, .card-footer { display: none !important; }
        .content-wrapper { margin-left: 0 !important; }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // --- GRAFICO RENDIMIENTO (NOTAS) ---
        const ctxNotas = document.getElementById('chartNotas').getContext('2d');
        new Chart(ctxNotas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($distribucionNotas->pluck('calificacionLiteralCalificaciones')) !!},
                datasets: [{
                    label: 'Cantidad de Estudiantes',
                    data: {!! json_encode($distribucionNotas->pluck('total')) !!},
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)',  // AD (Verde)
                        'rgba(0, 123, 255, 0.7)', // A (Azul)
                        'rgba(23, 162, 184, 0.7)', // B (Cian)
                        'rgba(220, 53, 69, 0.7)'   // C (Rojo)
                    ],
                    borderColor: [
                        '#28a745', '#007bff', '#17a2b8', '#dc3545'
                    ],
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- GRAFICO MATRICULA (PIE) ---
        const ctxMatricula = document.getElementById('chartMatricula').getContext('2d');
        new Chart(ctxMatricula, {
            type: 'pie',
            data: {
                labels: {!! json_encode($estadosMatricula->pluck('estadoMatriculacion')) !!},
                datasets: [{
                    data: {!! json_encode($estadosMatricula->pluck('total')) !!},
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 10 } } }
                }
            }
        });

        // --- GRAFICO GENERO (DOUGHNUT) ---
        const ctxGenero = document.getElementById('chartGenero').getContext('2d');
        new Chart(ctxGenero, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($generos->pluck('generoEstudiante')) !!},
                datasets: [{
                    data: {!! json_encode($generos->pluck('total')) !!},
                    backgroundColor: ['#e83e8c', '#007bff', '#6c757d'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });

        // --- GRAFICO INGRESOS (LINE) ---
        const ctxIngresos = document.getElementById('chartIngresos').getContext('2d');
        new Chart(ctxIngresos, {
            type: 'line',
            data: {
                labels: {!! json_encode($pagosData->pluck('mes')) !!},
                datasets: [{
                    label: 'Recaudación (S/.)',
                    data: {!! json_encode($pagosData->pluck('total')) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { 
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- GRAFICO NIVELES (HORIZONTAL BAR) ---
        const ctxNiveles = document.getElementById('chartNiveles').getContext('2d');
        new Chart(ctxNiveles, {
            type: 'bar',
            data: {
                labels: {!! json_encode($estudiantesPorNivel->pluck('nombreNivel')) !!},
                datasets: [{
                    label: 'Estudiantes',
                    data: {!! json_encode($estudiantesPorNivel->pluck('total')) !!},
                    backgroundColor: 'rgba(23, 162, 184, 0.8)',
                    borderRadius: 5
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    x: { beginAtZero: true, ticks: { precision: 0 } },
                    y: { grid: { display: false } }
                }
            }
        });
    });
</script>
@stop
