@extends('adminlte::page')

@section('title', 'Editar Calificaciones - ' . $asignacion->curso->nombreCurso)

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <a href="{{ route('admin.calificaciones.create', $asignacion->idAsignarCursoDocente) }}" class="btn btn-link text-muted p-0 mb-2 hover-lift">
            <i class="fas fa-arrow-left mr-1"></i> Volver a la lista del curso
        </a>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-edit mr-2 text-primary"></i>
            Editar Calificaciones: {{ $periodo->nombrePeriodo }}
        </h1>
        <div class="d-flex flex-wrap mt-2">
            <span class="badge badge-info-soft px-3 py-2 mr-2 mb-2">
                <i class="fas fa-book mr-2"></i>{{ $asignacion->curso->nombreCurso }}
            </span>
            <span class="badge badge-primary-soft px-3 py-2 mr-2 mb-2">
                <i class="fas fa-users mr-2"></i>{{ $asignacion->grado->nombreGrado }} "{{ $asignacion->seccion->nombreSeccion }}"
            </span>
            <span class="badge badge-secondary-soft px-3 py-2 mb-2">
                <i class="fas fa-calendar-check mr-2"></i>{{ $periodo->nombrePeriodo }}
            </span>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.calificaciones.update', [$asignacion->idAsignarCursoDocente, $periodo->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-user-edit mr-2 text-primary"></i>
                            Modificar Notas de Estudiantes
                        </h3>
                    </div>
                    
                    <div class="card-body p-0">
                        {{-- Escala de calificación informativa --}}
                        <div class="p-3 bg-light border-bottom d-flex flex-wrap gap-2">
                            <span class="badge badge-danger px-3 py-2 mr-2" style="border-radius:10px; font-size:0.75rem;">C: 0-10</span>
                            <span class="badge badge-info px-3 py-2 mr-2" style="border-radius:10px; font-size:0.75rem;">B: 11-13</span>
                            <span class="badge badge-primary px-3 py-2 mr-2" style="border-radius:10px; font-size:0.75rem;">A: 14-17</span>
                            <span class="badge badge-success px-3 py-2" style="border-radius:10px; font-size:0.75rem;">AD: 18-20</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light text-uppercase small font-weight-bold">
                                    <tr>
                                        <th class="border-0 px-4" style="width:40px;">#</th>
                                        <th class="border-0">Estudiante</th>
                                        <th class="border-0 text-center" style="width:150px;">Nota (0-20)</th>
                                        <th class="border-0 text-center" style="width:180px;">Literal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calificaciones as $i => $c)
                                    <tr>
                                        <td class="px-4 align-middle text-muted small">{{ $i + 1 }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary-soft d-flex align-items-center justify-content-center mr-2 shadow-sm"
                                                     style="width: 36px; height: 36px; font-weight: bold; color: #007bff; font-size: 0.8rem; flex-shrink:0;">
                                                    {{ strtoupper(substr($c->matriculacion->estudiante->nombreEstudiante, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold small">
                                                        {{ $c->matriculacion->estudiante->nombreEstudiante }} {{ $c->matriculacion->estudiante->apellidoEstudiante }}
                                                    </div>
                                                    <small class="text-muted" style="font-size:0.65rem;">DNI: {{ $c->matriculacion->estudiante->dniEstudiante }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="number" 
                                                   name="notas[{{ $c->idCalificacion }}][calificacion]" 
                                                   value="{{ $c->calificacionCalificaciones }}" 
                                                   class="form-control form-control-sm text-center border-0 bg-light nota-input"
                                                   min="0" max="20" step="0.5"
                                                   style="border-radius:10px; font-weight:bold; font-size:1rem;"
                                                   data-id="{{ $c->idCalificacion }}">
                                        </td>
                                        <td class="align-middle text-center">
                                            @php
                                                $lit = $c->calificacionLiteralCalificaciones;
                                                $litColor = $lit === 'AD' ? 'success' : ($lit === 'A' ? 'primary' : ($lit === 'B' ? 'info' : 'danger'));
                                            @endphp
                                            <span class="badge badge-{{ $litColor }} literal-badge px-3 py-2" 
                                                  id="literal-{{ $c->idCalificacion }}"
                                                  style="border-radius:10px; font-size:0.85rem; min-width:140px; display:inline-block;">
                                                {{ $lit }} — 
                                                @if($lit === 'AD') Logro Destacado
                                                @elseif($lit === 'A') Logro Esperado
                                                @elseif($lit === 'B') En Proceso
                                                @else En Inicio
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 py-4 d-flex justify-content-end">
                        <a href="{{ route('admin.calificaciones.create', $asignacion->idAsignarCursoDocente) }}" class="btn btn-light rounded-pill px-4 mr-2 shadow-sm">Cancelar</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm hover-lift">
                            <i class="fas fa-save mr-2"></i> Actualizar Calificaciones
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
    
    .nota-input:focus { box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25); background-color: #fff !important; }
    
    .hover-lift { transition: all 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); }
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        function calcularLiteral(nota) {
            nota = parseFloat(nota);
            if (isNaN(nota)) return { texto: '—', clase: 'badge-secondary' };
            if (nota >= 18) return { texto: 'AD — Logro Destacado', clase: 'badge-success' };
            if (nota >= 14) return { texto: 'A — Logro Esperado',   clase: 'badge-primary' };
            if (nota >= 11) return { texto: 'B — En Proceso',       clase: 'badge-info'    };
            return             { texto: 'C — En Inicio',            clase: 'badge-danger'  };
        }

        $(document).on('input', '.nota-input', function () {
            const id = $(this).data('id');
            const val = $(this).val();
            const r = calcularLiteral(val);

            $('#literal-' + id)
                .text(r.texto)
                .attr('class', 'badge literal-badge px-3 py-2 ' + r.clase);
        });
    });
</script>
@stop
