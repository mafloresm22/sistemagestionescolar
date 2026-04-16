@extends('adminlte::page')

@section('title', 'Editar Asistencia')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <a href="{{ route('admin.cursos-docentes-asistencias.create', $asignacion->idAsignarCursoDocente) }}" class="btn btn-link text-muted p-0 mb-2 hover-lift">
            <i class="fas fa-arrow-left mr-1"></i> Volver al historial
        </a>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-edit mr-2 text-primary"></i>
            Editar Asistencia: {{ \Carbon\Carbon::parse($asistencia->fechaAsistencias)->translatedFormat('d F Y') }}
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
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.cursos-docentes-asistencias.update', $asistencia->idAsistencia) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label for="observacionAsistencias" class="font-weight-bold text-muted small text-uppercase">Observaciones de la clase</label>
                                <input type="text" name="observacionAsistencias" class="form-control border-0 bg-light rounded-pill px-3" 
                                       value="{{ old('observacionAsistencias', $asistencia->observacionAsistencias) }}" 
                                       placeholder="Ej: Tema: Ecuaciones de segundo grado...">
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn-group btn-group-sm shadow-sm" style="border-radius: 20px; overflow: hidden;">
                                    <button type="button" class="btn btn-outline-success px-3" onclick="markAll('Presente')">Marcar Todos Presentes</button>
                                    <button type="button" class="btn btn-outline-danger px-3" onclick="markAll('Falta')">Marcar Todos Faltas</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light sticky-top shadow-sm">
                                    <tr>
                                        <th class="border-0 px-4" style="width: 50px;">#</th>
                                        <th class="border-0">Estudiante</th>
                                        <th class="border-0 text-center" style="width: 400px;">Estado de Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asistencia->asistenciasDetalles as $index => $detalle)
                                    <tr>
                                        <td class="align-middle px-4 text-muted small font-weight-bold">{{ $index + 1 }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle mr-3 bg-primary-soft text-primary font-weight-bold d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; border-radius: 50%;">
                                                    {{ substr($detalle->estudiante->nombreEstudiante, 0, 1) }}{{ substr($detalle->estudiante->apellidoEstudiante, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="d-block font-weight-bold">{{ $detalle->estudiante->apellidoEstudiante }}, {{ $detalle->estudiante->nombreEstudiante }}</span>
                                                    <small class="text-muted">{{ $detalle->estudiante->dniEstudiante }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group btn-group-toggle d-flex shadow-sm" data-toggle="buttons" style="border-radius: 10px; overflow: hidden;">
                                                <label class="btn btn-outline-success border-0 flex-fill {{ $detalle->estadoAsistenciasDetalle == 'Presente' ? 'active' : '' }}">
                                                    <input type="radio" name="asistencias[{{ $detalle->idAsistenciasDetalle }}]" value="Presente" required {{ $detalle->estadoAsistenciasDetalle == 'Presente' ? 'checked' : '' }}> 
                                                    <i class="fas fa-check-circle mr-1"></i> Presente
                                                </label>
                                                <label class="btn btn-outline-warning border-0 flex-fill {{ $detalle->estadoAsistenciasDetalle == 'Tarde' ? 'active' : '' }}">
                                                    <input type="radio" name="asistencias[{{ $detalle->idAsistenciasDetalle }}]" value="Tarde" required {{ $detalle->estadoAsistenciasDetalle == 'Tarde' ? 'checked' : '' }}> 
                                                    <i class="fas fa-clock mr-1"></i> Tarde
                                                </label>
                                                <label class="btn btn-outline-danger border-0 flex-fill {{ $detalle->estadoAsistenciasDetalle == 'Falta' ? 'active' : '' }}">
                                                    <input type="radio" name="asistencias[{{ $detalle->idAsistenciasDetalle }}]" value="Falta" required {{ $detalle->estadoAsistenciasDetalle == 'Falta' ? 'checked' : '' }}> 
                                                    <i class="fas fa-times-circle mr-1"></i> Falta
                                                </label>
                                                <label class="btn btn-outline-secondary border-0 flex-fill {{ $detalle->estadoAsistenciasDetalle == 'Justificado' ? 'active' : '' }}">
                                                    <input type="radio" name="asistencias[{{ $detalle->idAsistenciasDetalle }}]" value="Justificado" required {{ $detalle->estadoAsistenciasDetalle == 'Justificado' ? 'checked' : '' }}> 
                                                    <i class="fas fa-file-alt mr-1"></i> Justificado
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0 py-4 text-center">
                        <button type="submit" class="btn btn-primary-custom px-5 py-2 shadow-sm hover-lift">
                            <i class="fas fa-save mr-2"></i> Actualizar Asistencia
                        </button>
                    </div>
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
    
    .sticky-top { z-index: 1020; }
    
    .btn-group-toggle .btn.active { box-shadow: inset 0 3px 5px rgba(0,0,0,0.125); font-weight: bold; }
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
</script>
@stop
