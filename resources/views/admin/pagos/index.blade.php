@extends('adminlte::page')

@section('title', 'Gestión de Pagos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h1 class="text-dark font-weight-bold">
            <i class="fas fa-hand-holding-usd mr-2 text-success"></i>
            Control de Pagos
        </h1>
        @if(isset($matriculacion))
            <p class="text-muted mb-0">Gestión de recibos para <strong>{{ $matriculacion->estudiante->nombreEstudiante }}</strong></p>
        @else
            <p class="text-muted mb-0">Selecciona un alumno para realizar un cobro o ver su historial.</p>
        @endif
    </div>
    <div class="d-flex align-items-center">
        @if(!isset($matriculacion))
            {{-- Buscador dinámico estilo Personal --}}
            <div class="input-group mr-3 shadow-sm" style="width: 300px;">
                <input type="text" id="customSearch" class="form-control border-0" placeholder="Buscar por nombre o DNI..." style="border-radius: 10px 0 0 10px;">
                <div class="input-group-append">
                    <span class="input-group-text bg-white border-0" style="border-radius: 0 10px 10px 0;">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                </div>
            </div>
        @endif
        <a href="{{ route('admin.matriculacion.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mr-2 shadow-sm hover-lift">
            <i class="fas fa-arrow-left mr-2"></i> {{ isset($matriculacion) ? 'Volver' : 'Registrar Matrícula' }}
        </a>
        @if(isset($matriculacion))
            <button class="btn btn-success-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreatePago">
                <i class="fas fa-plus-circle mr-2"></i> Nuevo Pago
            </button>
        @endif
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    @if(isset($matriculacion))
        {{-- VISTA: DETALLE DE PAGOS DE UN ALUMNO --}}
        <div class="row">
            {{-- Carnet Lateral del Alumno --}}
            <div class="col-md-4">
                <div class="personal-card animate__animated animate__zoomIn sticky-top" style="top: 20px;">
                    <div class="card-header-carnet bg-gradient-blue text-center">
                        <div class="avatar-container shadow">
                            @php
                                $initials = strtoupper(substr($matriculacion->estudiante->nombreEstudiante, 0, 1) . substr($matriculacion->estudiante->apellidoEstudiante, 0, 1));
                            @endphp
                            <div class="avatar-pseudo shadow-sm" style="background: #4e73df;">{{ $initials }}</div>
                        </div>
                    </div>
                    <div class="card-body-carnet mt-4">
                        <h5 class="person-name">{{ $matriculacion->estudiante->nombreEstudiante }} {{ $matriculacion->estudiante->apellidoEstudiante }}</h5>
                        <p class="person-title"><i class="fas fa-graduation-cap mr-1"></i> {{ $matriculacion->grado->nombreGrado }}</p>
                        <div class="info-grid">
                            <div class="info-item"><span class="label">DNI</span><span class="value">{{ $matriculacion->estudiante->dniEstudiante }}</span></div>
                            <div class="info-item"><span class="label">GESTIÓN</span><span class="value">{{ $matriculacion->gestion->nombreGestion }}</span></div>
                        </div>
                        <hr class="my-3">
                        <div class="text-left px-2">
                            <p class="mb-1"><strong>Pagado:</strong> <span class="text-success float-right">S/. {{ number_format($pagos->where('estadoPago', 'Pagado')->sum('montoPago'), 2) }}</span></p>
                            <p class="mb-0"><strong>Pendiente:</strong> <span class="text-warning float-right">S/. {{ number_format($pagos->where('estadoPago', 'Pendiente')->sum('montoPago'), 2) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Historial de Pagos --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-xl overflow-hidden">
                    <div class="card-header bg-white py-3 border-0">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-history mr-2 text-secondary"></i> Historial de Recibos</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4">Fecha</th>
                                    <th class="border-0">Monto</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pagos as $p)
                                    <tr>
                                        <td class="px-4 align-middle">{{ \Carbon\Carbon::parse($p->fechaPago)->format('d/m/Y') }}</td>
                                        <td class="align-middle font-weight-bold text-success">S/. {{ number_format($p->montoPago, 2) }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-pill badge-{{ $p->estadoPago == 'Pagado' ? 'success' : 'warning' }} px-3 py-1">{{ strtoupper($p->estadoPago) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="{{ route('admin.pagos.imprimir', $p->idPago) }}" target="_blank" class="btn btn-light btn-sm text-success"><i class="fas fa-print"></i></a>
                                                <button class="btn btn-light btn-sm text-primary"><i class="fas fa-edit"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-5 text-muted">No hay pagos registrados.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- VISTA: BUSCADOR DE ALUMNOS (ESTILO PERSONAL) --}}
        <div class="row pt-3" id="pago-container">
            @foreach($matriculaciones as $m)
                <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4 pago-item" 
                     data-name="{{ strtolower($m->estudiante->nombreEstudiante . ' ' . $m->estudiante->apellidoEstudiante) }}" 
                     data-dni="{{ $m->estudiante->dniEstudiante }}">
                    <div class="personal-card animate__animated animate__zoomIn">
                        <div class="card-header-carnet bg-premium-orange">
                            <div class="avatar-container shadow">
                                @php
                                    $initials = strtoupper(substr($m->estudiante->nombreEstudiante, 0, 1) . substr($m->estudiante->apellidoEstudiante, 0, 1));
                                    $bgColor = '#f6c23e';
                                @endphp
                                <div class="avatar-pseudo shadow-sm" style="background: {{ $bgColor }};">{{ $initials }}</div>
                            </div>
                        </div>
                        <div class="card-body-carnet">
                            <h5 class="person-name">{{ $m->estudiante->nombreEstudiante }} {{ $m->estudiante->apellidoEstudiante }}</h5>
                            <p class="person-title" style="font-size: 0.75rem;"><i class="fas fa-school mr-1"></i> {{ $m->grado->nombreGrado }} - {{ $m->seccion->nombreSeccion ?? 'S/S' }}</p>
                            <div class="info-grid">
                                <div class="info-item"><span class="label">DNI</span><span class="value">{{ $m->estudiante->dniEstudiante }}</span></div>
                                <div class="info-item"><span class="label">TURN.</span><span class="value">{{ $m->turno->nombreTurno }}</span></div>
                            </div>
                        </div>
                        <div class="card-footer-carnet bg-light border-top text-center py-3">
                            <a href="{{ route('admin.pagos.index', ['idMatriculacion' => $m->idMatriculacion]) }}" 
                               class="btn btn-warning rounded-pill px-4 shadow-sm font-weight-bold text-white hover-lift">
                                <i class="fas fa-cash-register mr-1"></i> GESTIONAR PAGOS
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* HEREDADO DE PERSONAL.INDEX */
.personal-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s; border: 1px solid rgba(0,0,0,0.05); }
.personal-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.15); }
.card-header-carnet { height: 95px; position: relative; display: flex; justify-content: center; }
.bg-gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
.bg-premium-orange { background: linear-gradient(135deg, #fd7e14 0%, #fb8c00 100%); }
.avatar-container { position: absolute; bottom: -35px; width: 80px; height: 80px; border-radius: 50%; background: white; padding: 4px; }
.avatar-pseudo { width: 100%; height: 100%; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem; }
.card-body-carnet { padding: 45px 20px 20px 20px; text-align: center; }
.person-name { font-weight: 800; color: #2e3b4e; font-size: 1.1rem; }
.person-title { color: #858796; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 15px; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #f8f9fc; padding: 10px; border-radius: 12px; text-align: left; }
.info-item .label { font-size: 0.6rem; font-weight: 700; color: #b7b9cc; text-transform: uppercase; }
.info-item .value { font-size: 0.8rem; color: #4e73df; }
.btn-success-custom { background: linear-gradient(135deg, #28a745 0%, #218838 100%); border: none; color: white; border-radius: 12px; font-weight: 600; }
.hover-lift { transition: transform 0.2s; }
.hover-lift:hover { transform: translateY(-3px); }
.rounded-xl { border-radius: 15px !important; }
</style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('customSearch');
        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('.pago-item').forEach(item => {
                    const name = item.getAttribute('data-name');
                    const dni = item.getAttribute('data-dni');
                    item.style.display = (name.includes(term) || dni.includes(term)) ? 'block' : 'none';
                });
            });
        }
    });
</script>
@stop
