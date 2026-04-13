@extends('adminlte::page')

@section('title', 'Gestión de Pagos - Estudiante')

@section('content_header')
<div class="container-fluid py-3">
    <div class="row align-items-center animate__animated animate__fadeIn">
        <div class="col-md-7">
            <h1 class="header-student-title mb-1">
                <span class="gradient-text-user"><i class="fas fa-user-graduate mr-3"></i>Historial de Pagos</span>
            </h1>
            <p class="text-muted font-italic mb-0">
                <i class="fas fa-id-badge mr-1 text-primary"></i> Estudiante: <strong>{{ $estudiante->nombreEstudiante }} {{ $estudiante->apellidoEstudiante }}</strong>
            </p>
        </div>
        <div class="col-md-5 text-right">
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-premium-back rounded-pill shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
            </a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-5">
    {{-- PERFIL RESUMEN --}}
    <div class="student-profile-bar shadow-sm mb-4 animate__animated animate__fadeIn">
        <div class="profile-avatar">
            {{ substr($estudiante->nombreEstudiante, 0, 1) }}{{ substr($estudiante->apellidoEstudiante, 0, 1) }}
        </div>
        <div class="profile-main-info">
            <h4 class="mb-0 font-weight-bold">{{ $estudiante->nombreEstudiante }} {{ $estudiante->apellidoEstudiante }}</h4>
            <div class="profile-meta">
                <span><i class="fas fa-fingerprint mr-1"></i> DNI: {{ $estudiante->dniEstudiante }}</span>
                <span class="mx-3 text-muted">|</span>
                <span><i class="fas fa-calendar-alt mr-1"></i> {{ $matriculaciones->count() }} Gestiones Registradas</span>
            </div>
        </div>
    </div>

    {{-- GESTIONES --}}
    @foreach($matriculaciones as $m)
    <div class="management-card mb-5 animate__animated animate__fadeInUp">
        <div class="card-header-vibrant bg-gradient-dark">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="m-0 text-white font-weight-bold">
                        <i class="fas fa-university mr-2"></i> GESTIÓN: {{ $m->gestion->nombreGestion }}
                    </h5>
                    <div class="academic-badge mt-2">
                        {{ $m->grado->nombreGrado }} • {{ $m->nivel->nombreNivel }} • Sección: {{ $m->seccion->nombreSeccion ?? 'S/S' }}
                    </div>
                </div>
                <div class="col-md-6 text-md-right mt-3 mt-md-0">
                    @if($m->pagos->where('estadoPago', 'Pagado')->isNotEmpty())
                        <div class="badge badge-success rounded-pill px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                            <i class="fas fa-check-circle mr-2"></i>MATRÍCULA PAGADA
                        </div>
                    @else
                        <button class="btn btn-register-pago glow-button" data-toggle="modal" data-target="#modalCreatePago{{ $m->idMatriculacion }}">
                            <i class="fas fa-plus-circle mr-2"></i>REGISTRAR PAGO
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="row no-gutters">
            {{-- PANEL IZQUIERDO --}}
            <div class="col-md-3 bg-white border-right p-4">
                <div class="balance-item mb-4">
                    <p class="small text-muted text-uppercase mb-1 font-weight-bold">Pago Total</p>
                    <h3 class="text-success font-weight-bold">S/. {{ number_format($m->pagos->where('estadoPago', 'Pagado')->sum('montoPago'), 2) }}</h3>
                </div>
                <div class="last-payment-info pt-3 border-top">
                    <small class="text-muted"><i class="fas fa-receipt mr-1"></i> Último movimiento:</small>
                    <p class="font-weight-bold small mb-0">
                        @if($m->pagos->isNotEmpty())
                            {{ \Carbon\Carbon::parse($m->pagos->max('fechaPago'))->format('d M, Y') }}
                        @else
                            No hay registros
                        @endif
                    </p>
                </div>
            </div>

            {{-- TABLA DE MOVIMIENTOS --}}
            <div class="col-md-9 bg-white">
                <div class="table-responsive">
                    <table class="table table-premium mb-0">
                        <thead>
                            <tr>
                                <th class="pl-4">Fecha</th>
                                <th>Ref.</th>
                                <th>Método</th>
                                <th>Monto</th>
                                <th>Voucher</th>
                                <th>Estado</th>
                                <th class="pr-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($m->pagos->sortByDesc('fechaPago') as $p)
                            <tr>
                                <td class="pl-4 align-middle">
                                    <div class="date-cell">
                                        <span class="day">{{ \Carbon\Carbon::parse($p->fechaPago)->format('d') }}</span>
                                        <span class="month">{{ \Carbon\Carbon::parse($p->fechaPago)->format('M') }}</span>
                                    </div>
                                </td>
                                <td class="align-middle font-weight-bold text-primary">#{{ str_pad($p->idPago, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="align-middle"><span class="badge badge-light border">{{ $p->metodoPago }}</span></td>
                                <td class="align-middle font-weight-bold">S/. {{ number_format($p->montoPago, 2) }}</td>
                                <td class="align-middle text-center">
                                    @if($p->fotoPago && $p->fotoPago != 'Ninguna')
                                        <a href="{{ asset('storage/pagos/' . $p->fotoPago) }}" download class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fas fa-download mr-1"></i> Descargar
                                        </a>
                                    @else
                                        <small class="text-muted"><i class="fas fa-times-circle mr-1"></i> N/A</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($p->estadoPago == 'Pagado')
                                        <div class="badge-status-glow bg-success-glow">PAGADO</div>
                                    @else
                                        <div class="badge-status-glow bg-amber-glow">PENDIENTE</div>
                                    @endif
                                </td>
                                <td class="pr-4 align-middle text-right">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pagos.imprimir', $p->idPago) }}" target="_blank" class="btn btn-action-icon text-success" title="Imprimir Recibo PDF">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted font-italic">No hay movimientos en esta gestión.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.pagos.create', ['matriculacion' => $m])
    @endforeach
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');

body, .content-wrapper { font-family: 'Outfit', sans-serif !important; background-color: #f4f7f6 !important; }

.gradient-text-user { background: linear-gradient(135deg, #0d49a2 0%, #408fea 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; }
.btn-premium-back { background: white; border: 1px solid #e3e6f0; color: #4e73df; font-weight: 600; transition: all 0.3s; font-size: 0.75rem; padding: 8px 18px; }
.btn-premium-back:hover { background: #4e73df; color: white; transform: translateX(-5px); }

.student-profile-bar { background: white; border-radius: 20px; padding: 25px; display: flex; align-items: center; }
.profile-avatar { width: 50px; height: 50px; background: #0d49a2; color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 800; margin-right: 20px; box-shadow: 0 5px 15px rgba(2, 133, 255, 0.934); }
.profile-meta { font-size: 0.8rem; color: #858796; margin-top: 3px; }

/* MANAGEMENT CARDS */
.management-card { background: white; border-radius: 25px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
.card-header-vibrant { padding: 25px 35px; }
.bg-gradient-dark { background: linear-gradient(135deg, #008cffdd 0%, #0073ff88 100%) !important; }
.academic-badge { background: rgba(27, 118, 245, 0.975); color: rgba(255,255,255,0.8); padding: 5px 15px; border-radius: 50px; display: inline-block; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.15); }

.btn-register-pago { background: #ffd901; color: white; padding: 10px 22px; border-radius: 50px; border: none; font-weight: 700; transition: all 0.3s; font-size: 0.75rem; }
.glow-button:hover { transform: scale(1.05); box-shadow: 0 0 20px rgba(2, 128, 255, 0.997); }

/* TABLE CUSTOM STYLES */
.table-premium thead th { 
    border: none; 
    text-transform: uppercase; 
    font-size: 0.65rem; 
    color: #858796; 
    letter-spacing: 1px; 
    padding: 12px 10px; 
    background: transparent !important;
}
.table-premium tr { transition: all 0.3s ease; border-bottom: 1px solid #f1f3f9; }
.table-premium tr:hover { background: #fdfdfd; box-shadow: inset 4px 0 0 #0072ff; transform: scale(1.002); }
.table-premium td { padding: 18px 10px; vertical-align: middle; border: none; font-size: 0.82rem; }

.date-cell { display: flex; flex-direction: column; align-items: center; line-height: 1; }
.date-cell .day { font-size: 0.95rem; font-weight: 800; color: #333; }
.date-cell .month { font-size: 0.6rem; color: #888; text-transform: uppercase; }

.badge-status-glow { 
    display: inline-block; padding: 4px 12px; border-radius: 8px; 
    font-weight: 800; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;
}
.bg-success-glow { background: #dcfce7; color: #15803d; box-shadow: 0 2px 10px rgba(21, 128, 61, 0.1); }
.bg-amber-glow { background: #fef9c3; color: #854d0e; box-shadow: 0 2px 10px rgba(133, 77, 14, 0.1); }

.btn-action-icon { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; font-size: 1rem; background: #f8f9fa; border: 1px solid #eef0f2; }
.btn-action-icon:hover { background: #fff; transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-color: #ddd; }

.rounded-xl { border-radius: 20px !important; }
</style>
@stop
