@extends('adminlte::page')

@section('title', 'Historial de Asistencia')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <a href="{{ route('admin.cursos-docentes-asistencias.index') }}" class="btn btn-link text-muted p-0 mb-2 hover-lift">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-history mr-2 text-primary"></i>
            Control de Asistencia: {{ $asignacion->curso->nombreCurso }}
        </h1>
        <div class="d-flex flex-wrap mt-2">
            <span class="badge badge-info-soft px-3 py-2 mr-2 mb-2">
                <i class="fas fa-chalkboard-teacher mr-2"></i>{{ $asignacion->docente->nombrePersonal }} {{ $asignacion->docente->apellidoPersonal }}
            </span>
            <span class="badge badge-primary-soft px-3 py-2 mr-2 mb-2">
                <i class="fas fa-door-open mr-2 text-primary"></i>Aula: {{ $aulaAsignada->aula->nombreAula ?? 'Sin físicamente asignada' }}
            </span>
            <span class="badge badge-secondary-soft px-3 py-2 mb-2">
                <i class="fas fa-users mr-2"></i>{{ $asignacion->grado->nombreGrado }} "{{ $asignacion->seccion->nombreSeccion }}" - {{ $asignacion->turno->nombreTurno }}
            </span>
        </div>
    </div>
    <div class="d-flex align-items-center">
        <div class="text-right mr-3 d-none d-md-block">
            <small class="text-muted d-block text-uppercase font-weight-bold">Total Alumnos</small>
            <span class="h5 font-weight-bold mb-0 text-primary">{{ $estudiantes->count() }} inscritos</span>
        </div>
        <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalTomarAsistencia">
            <i class="fas fa-check-double mr-2"></i> Registrar Asistencia
        </button>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Card de Historial --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-calendar-alt mr-2 text-secondary"></i>
                        Sesiones Registradas en {{ $aulaAsignada->aula->nombreAula ?? 'esta aula' }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="historialAsistenciasTable">
                            <thead class="bg-light text-center text-uppercase small font-weight-bold">
                                <tr>
                                    <th class="border-0 px-4 text-left" style="width: 200px;">Fecha</th>
                                    <th class="border-0 text-left">Observaciones</th>
                                    <th class="border-0">Alumnos</th>
                                    <th class="border-0" style="width: 150px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historial as $h)
                                    <tr>
                                        <td class="px-4 align-middle font-weight-bold">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-date mr-3 bg-primary-soft text-primary rounded-lg text-center p-1" style="width: 45px;">
                                                    <small class="d-block text-uppercase" style="font-size: 0.6rem;">{{ \Carbon\Carbon::parse($h->fechaAsistencias)->translatedFormat('M') }}</small>
                                                    <span class="d-block h6 mb-0 font-weight-bold">{{ \Carbon\Carbon::parse($h->fechaAsistencias)->format('d') }}</span>
                                                </div>
                                                <span>{{ \Carbon\Carbon::parse($h->fechaAsistencias)->translatedFormat('d F Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-muted">
                                            {{ $h->observacionAsistencias ?: 'Sin descripción' }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-light shadow-sm px-3 border" style="border-radius: 20px;">
                                                <i class="fas fa-user-check mr-1 text-success"></i> {{ $h->asistenciasDetalles->count() }} presentes
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a href="{{ route('admin.cursos-docentes-asistencias.imprimir', $h->idAsistencia) }}" target="_blank" 
                                                   class="btn btn-success btn-circle shadow-sm mr-2" title="Reporte PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <button class="btn btn-primary btn-circle shadow-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                                            <p class="mt-3 font-weight-bold">Aún no se han registrado asistencias en este curso.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- EL MODAL SE CARGA DESDE EL ARCHIVO SEPARADO --}}
@include('admin.asignaciones_curso_docente.asistencias_curso_docentes.asignar_asistencias')

@stop

@section('css')
<style>
    .bg-primary-soft { background-color: #e7f1ff; }
    .badge-info-soft { background-color: #e0f2f1; color: #00796b; border: 1px solid #b2dfdb; }
    .badge-primary-soft { background-color: #e3f2fd; color: #0d47a1; border: 1px solid #bbdefb; }
    .badge-secondary-soft { background-color: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }
    .btn-primary-custom {
        background-color: #007bff; border: none; color: white;
        border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
    }
    .btn-primary-custom:hover {
        background-color: #0056b3; transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4); color: white;
    }
    .hover-lift { transition: all 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); }
    
    .btn-xs { padding: 0.2rem 0.5rem; font-size: 0.75rem; }
    .table-container::-webkit-scrollbar { width: 6px; }
    .table-container::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    
    .btn-group-toggle .btn.active { box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important; font-weight: bold; }
    .btn-outline-success.active { background-color: #28a745 !important; color: white !important; }
    .btn-outline-warning.active { background-color: #ffc107 !important; color: #212529 !important; }
    .btn-outline-danger.active { background-color: #dc3545 !important; color: white !important; }
    .btn-outline-secondary.active { background-color: #6c757d !important; color: white !important; }

    #historialAsistenciasTable_wrapper .dataTables_paginate .paginate_button.current {
        background: #007bff !important; color: white !important; border: none !important; border-radius: 50%;
    }

    .btn-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-circle:hover {
        transform: scale(1.15) rotate(5deg);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15) !important;
    }
</style>
@stop

@section('js')
<script>
    function markAll(status) {
        $('input[type="radio"]').each(function() {
            if($(this).val() == status) {
                $(this).prop('checked', true).parent().addClass('active').siblings().removeClass('active');
            }
        });
    }

    $(document).ready(function () {
        $('#historialAsistenciasTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            "paging": true, "lengthChange": false, "searching": false, "ordering": true,
            "info": true, "responsive": true, "autoWidth": false
        });
    });
</script>
@stop
