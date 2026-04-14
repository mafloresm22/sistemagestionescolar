@extends('adminlte::page')

@section('title', 'Historial de Asistencia')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <a href="{{ route('admin.cursos-docentes-asistencias.index') }}" class="btn btn-link text-muted p-0 mb-2">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-history mr-2 text-primary"></i>
            Historial: {{ $asignacion->curso->nombreCurso }}
        </h1>
        <p class="text-muted mb-0">
            <span class="badge badge-info-soft px-3 py-1">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Docente: {{ $asignacion->docente->nombrePersonal }} {{ $asignacion->docente->apellidoPersonal }}
            </span>
            <span class="badge badge-secondary-soft px-3 py-1 ml-2">
                <i class="fas fa-users mr-2"></i>{{ $asignacion->grado->nombreGrado }} "{{ $asignacion->seccion->nombreSeccion }}" - {{ $asignacion->turno->nombreTurno }}
            </span>
        </p>
    </div>
    <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalTomarAsistencia">
        <i class="fas fa-plus-circle mr-2"></i> Tomar Asistencia Hoy
    </button>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 py-3">
            <h3 class="card-title font-weight-bold text-dark mb-0">
                <i class="fas fa-calendar-alt mr-2 text-secondary"></i>
                Sesiones Registradas
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="historialAsistenciasTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4" style="width: 150px;">Fecha</th>
                            <th class="border-0">Observaciones</th>
                            <th class="border-0 text-center" style="width: 150px;">Acciones</th>
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
                                        <span>{{ \Carbon\Carbon::parse($h->fechaAsistencias)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-muted small">
                                    {{ $h->observacionAsistencias ?: 'Sin observaciones' }}
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.cursos-docentes-asistencias.imprimir', $h->idAsistencia) }}" target="_blank" 
                                           class="btn btn-sm btn-outline-success border-0 mr-1" title="Ver Reporte">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-primary border-0" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fas fa-calendar-times mb-3 fa-3x" style="opacity: 0.2;"></i>
                                    <p>No hay asistencias registradas para este curso.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TOMAR ASISTENCIA --}}
<div class="modal fade" id="modalTomarAsistencia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-check-double mr-2"></i>Registro de Asistencia Diaria</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.cursos-docentes-asistencias.store', $asignacion->idAsignarCursoDocente) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="font-weight-bold small text-muted">Fecha del Registro</label>
                            <input type="date" name="fechaAsistencias" class="form-control rounded-pill border-0 bg-light shadow-none" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="font-weight-bold small text-muted">Observaciones Generales (Opcional)</label>
                            <input type="text" name="observacionAsistencias" class="form-control rounded-pill border-0 bg-light shadow-none" placeholder="Ej: Clase de repaso, examen final...">
                        </div>
                    </div>

                    <h6 class="font-weight-bold mb-3 d-flex align-items-center">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>
                        Listado de Alumnos ({{ $estudiantes->count() }})
                        <div class="ml-auto">
                            <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2 mr-1" onclick="markAll('Presente')">Todo Presente</button>
                        </div>
                    </h6>

                    <div class="table-container shadow-sm border rounded-lg" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped mb-0">
                            <thead class="bg-light position-sticky" style="top: 0; z-index: 1;">
                                <tr>
                                    <th class="border-0 px-3 py-2 small">Estudiante</th>
                                    <th class="border-0 text-center py-2 small" style="width: 280px;">Estado de Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $e)
                                    <tr>
                                        <td class="align-middle px-3">
                                            <div class="font-weight-bold small">{{ $e->estudiante->nombreEstudiante }} {{ $e->estudiante->apellidoEstudiante }}</div>
                                            <small class="text-muted">DNI: {{ $e->estudiante->dniEstudiante }}</small>
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-xs flex-fill m-1 rounded-pill active">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Presente" checked> P
                                                </label>
                                                <label class="btn btn-outline-warning btn-xs flex-fill m-1 rounded-pill">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Tarde"> T
                                                </label>
                                                <label class="btn btn-outline-danger btn-xs flex-fill m-1 rounded-pill">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Falta"> F
                                                </label>
                                                <label class="btn btn-outline-secondary btn-xs flex-fill m-1 rounded-pill">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Justificada"> J
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Guardar Asistencia</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .bg-primary-soft { background-color: #e7f1ff; }
    .badge-info-soft { background-color: #e0f2f1; color: #00796b; border: 1px solid #b2dfdb; }
    .badge-secondary-soft { background-color: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }
    .btn-primary-custom {
        background-color: #007bff; border: none; color: white;
        border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
    }
    .btn-primary-custom:hover {
        background-color: #0056b3; transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4); color: white;
    }
    .hover-lift:hover { transform: translateY(-3px); transition: transform 0.2s ease; }
    
    .btn-xs { padding: 0.1rem 0.5rem; font-size: 0.75rem; }
    .table-container::-webkit-scrollbar { width: 6px; }
    .table-container::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    
    /* Active states for toggle buttons */
    .btn-group-toggle .btn.active { box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important; font-weight: bold; }
    .btn-outline-success.active { background-color: #28a745 !important; color: white !important; }
    .btn-outline-warning.active { background-color: #ffc107 !important; color: #212529 !important; }
    .btn-outline-danger.active { background-color: #dc3545 !important; color: white !important; }
    .btn-outline-secondary.active { background-color: #6c757d !important; color: white !important; }
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
