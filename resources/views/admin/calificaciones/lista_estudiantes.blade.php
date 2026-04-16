@extends('adminlte::page')

@section('title', 'Calificaciones - ' . $asignacion->curso->nombreCurso)

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <a href="{{ route('admin.calificaciones.index') }}" class="btn btn-link text-muted p-0 mb-2 hover-lift">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-star-half-alt mr-2 text-warning"></i>
            Calificaciones: {{ $asignacion->curso->nombreCurso }}
        </h1>
        <div class="d-flex flex-wrap mt-2">
            <span class="badge badge-info-soft px-3 py-2 mr-2 mb-2">
                <i class="fas fa-chalkboard-teacher mr-2"></i>{{ $asignacion->docente->nombrePersonal }} {{ $asignacion->docente->apellidoPersonal }}
            </span>
            <span class="badge badge-warning-soft px-3 py-2 mr-2 mb-2">
                <i class="fas fa-door-open mr-2"></i>Aula: {{ $aulaAsignada->aula->nombreAula ?? 'Sin aula asignada' }}
            </span>
            <span class="badge badge-secondary-soft px-3 py-2 mb-2">
                <i class="fas fa-users mr-2"></i>{{ $asignacion->grado->nombreGrado }} "{{ $asignacion->seccion->nombreSeccion }}" - {{ $asignacion->turno->nombreTurno }}
            </span>
        </div>
    </div>
    <div class="d-flex align-items-center">
        <div class="text-right mr-3 d-none d-md-block">
            <small class="text-muted d-block text-uppercase font-weight-bold">Matriculados</small>
            <span class="h5 font-weight-bold mb-0 text-warning">{{ $matriculados->count() }} estudiantes</span>
        </div>
        @if($periodos->count() > 0)
        <button class="btn btn-warning-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalRegistrarNota">
            <i class="fas fa-pen mr-2"></i> Registrar Notas
        </button>
        @endif
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">

    {{-- ========================= TABLA DE CALIFICACIONES POR PERIODO ========================= --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-table mr-2 text-warning"></i>
                        Calificaciones por Período
                    </h3>
                </div>
                <div class="card-body p-0">

                    @if($periodos->count() > 0)
                    {{-- Pestañas de periodos --}}
                    <ul class="nav nav-tabs px-3 pt-2 border-bottom" id="periodosTab" role="tablist">
                        @foreach($periodos as $periodo)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }} font-weight-bold"
                               data-toggle="tab"
                               href="#tab-periodo-{{ $periodo->id }}"
                               role="tab">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $periodo->nombrePeriodo }}
                                <span class="badge badge-pill badge-warning ml-1" style="font-size:0.65rem;">
                                    {{ $calificaciones->get($periodo->id, collect())->count() }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="periodosTabContent">
                        @foreach($periodos as $periodo)
                        @php $notasPeriodo = $calificaciones->get($periodo->id, collect()); @endphp
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="tab-periodo-{{ $periodo->id }}" role="tabpanel">

                            @if($notasPeriodo->count() > 0)
                            <div class="p-3 d-flex justify-content-end bg-light border-bottom">
                                <a href="{{ route('admin.calificaciones.edit', [$asignacion->idAsignarCursoDocente, $periodo->id]) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm hover-lift">
                                    <i class="fas fa-edit mr-1"></i> Editar Notas de este Período
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light text-uppercase small font-weight-bold">
                                        <tr>
                                            <th class="border-0 px-4" style="width:40px;">#</th>
                                            <th class="border-0">Estudiante</th>
                                            <th class="border-0 text-center" style="width:110px;">Nota</th>
                                            <th class="border-0 text-center" style="width:130px;">Literal</th>
                                            <th class="border-0 text-center" style="width:150px;">Fecha Registro</th>
                                            <th class="border-0 text-center" style="width:100px;">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($matriculados as $i => $m)
                                        @php
                                            $notaEstudiante = $notasPeriodo->firstWhere('matriculacionID', $m->idMatriculacion);
                                        @endphp
                                        <tr>
                                            <td class="px-4 align-middle text-muted small">{{ $i + 1 }}</td>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-warning-soft d-flex align-items-center justify-content-center mr-2 shadow-sm"
                                                         style="width: 36px; height: 36px; font-weight: bold; color: #e6a100; font-size: 0.8rem; flex-shrink:0;">
                                                        {{ strtoupper(substr($m->estudiante->nombreEstudiante, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold small">
                                                            {{ $m->estudiante->nombreEstudiante }} {{ $m->estudiante->apellidoEstudiante }}
                                                        </div>
                                                        <small class="text-muted" style="font-size:0.65rem;">DNI: {{ $m->estudiante->dniEstudiante }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            @if($notaEstudiante)
                                                @php
                                                    $n = $notaEstudiante->calificacionCalificaciones;
                                                    $colorNota = $n >= 18 ? 'success' : ($n >= 14 ? 'primary' : ($n >= 11 ? 'info' : 'danger'));
                                                @endphp
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-{{ $colorNota }} px-3 py-2" style="font-size:1rem; border-radius:10px; min-width:50px;">
                                                        {{ number_format($n, 0) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $lit = $notaEstudiante->calificacionLiteralCalificaciones;
                                                        $litColor = $lit === 'AD' ? 'success' : ($lit === 'A' ? 'primary' : ($lit === 'B' ? 'info' : 'danger'));
                                                    @endphp
                                                    <span class="badge badge-{{ $litColor }} px-3 py-2" style="border-radius:8px; font-size:0.85rem;">
                                                        {{ $lit }}
                                                        @if($lit === 'AD') <small class="d-block" style="font-size:0.6rem;">Logro Destacado</small>
                                                        @elseif($lit === 'A') <small class="d-block" style="font-size:0.6rem;">Logro Esperado</small>
                                                        @elseif($lit === 'B') <small class="d-block" style="font-size:0.6rem;">En Proceso</small>
                                                        @else <small class="d-block" style="font-size:0.6rem;">En Inicio</small>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center text-muted small">
                                                    {{ \Carbon\Carbon::parse($notaEstudiante->fechaRegistroCalificaciones)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge {{ $notaEstudiante->estadoCalificaciones === 'Activo' ? 'badge-success' : 'badge-secondary' }} px-2">
                                                        {{ $notaEstudiante->estadoCalificaciones }}
                                                    </span>
                                                </td>
                                            @else
                                                <td class="align-middle text-center" colspan="4">
                                                    <span class="text-muted small"><i class="fas fa-minus"></i> Sin nota</span>
                                                </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-clipboard fa-2x text-light mb-2"></i>
                                <p class="mb-0 small font-weight-bold">No hay calificaciones registradas para este período.</p>
                                <small>Usa el botón <strong>"Registrar Notas"</strong> para agregar.</small>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-calendar-times fa-3x text-secondary mb-3"></i>
                        <p class="font-weight-bold">No hay períodos configurados para la gestión de este curso.</p>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- ========================= LISTA DE MATRICULADOS ========================= --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-user-graduate mr-2 text-warning"></i>
                        Estudiantes Matriculados Activos
                    </h3>
                    <span class="badge badge-warning px-3 py-2" style="border-radius:10px;">
                        {{ $matriculados->count() }} matriculados
                    </span>
                </div>
                <div class="card-body p-0">
                    @if($matriculados->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="matriculadosTable">
                            <thead class="bg-light text-uppercase small font-weight-bold">
                                <tr>
                                    <th class="border-0 px-4">#</th>
                                    <th class="border-0">Estudiante</th>
                                    <th class="border-0 text-center">DNI</th>
                                    <th class="border-0 text-center">Fecha Matrícula</th>
                                    <th class="border-0 text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriculados as $i => $m)
                                <tr>
                                    <td class="px-4 align-middle text-muted font-weight-bold">{{ $i + 1 }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning-soft d-flex align-items-center justify-content-center mr-3 shadow-sm"
                                                 style="width: 40px; height: 40px; font-weight: bold; color: #e6a100;">
                                                {{ strtoupper(substr($m->estudiante->nombreEstudiante, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark">
                                                    {{ $m->estudiante->nombreEstudiante }} {{ $m->estudiante->apellidoEstudiante }}
                                                </div>
                                                <small class="text-muted">Matrícula #{{ $m->idMatriculacion }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-muted">{{ $m->estudiante->dniEstudiante }}</td>
                                    <td class="align-middle text-center text-muted small">
                                        {{ \Carbon\Carbon::parse($m->fechaMatriculacion)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-success px-2 py-1" style="border-radius:8px;">
                                            {{ $m->estadoMatriculacion }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-user-graduate fa-3x text-secondary mb-3"></i>
                        <p class="font-weight-bold">No hay estudiantes matriculados activos en este curso.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ========================= MODAL REGISTRAR NOTAS ========================= --}}
<div class="modal fade" id="modalRegistrarNota" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #f6c90e, #e0a800); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-pen mr-2"></i>Registrar Calificaciones — {{ $asignacion->curso->nombreCurso }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.calificaciones.store', $asignacion->idAsignarCursoDocente) }}" method="POST">
                @csrf
                <div class="modal-body p-4">

                    {{-- Info del curso --}}
                    <div class="alert bg-light border mb-4 shadow-sm" style="border-radius: 12px;">
                        <div class="row align-items-center">
                            <div class="col-md-6 border-right">
                                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Curso / Aula</small>
                                <div class="font-weight-bold text-warning">
                                    <i class="fas fa-book mr-1"></i> {{ $asignacion->curso->nombreCurso }}
                                    <span class="mx-2 text-muted">|</span>
                                    <i class="fas fa-door-open mr-1"></i> {{ $aulaAsignada->aula->nombreAula ?? 'Sin Aula' }}
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-4">
                                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Grado / Sección / Turno</small>
                                <div class="text-dark">
                                    {{ $asignacion->grado->nombreGrado }} - "{{ $asignacion->seccion->nombreSeccion }}" ({{ $asignacion->turno->nombreTurno }})
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Escala de calificación --}}
                    <div class="d-flex flex-wrap mb-4 gap-2">
                        <span class="badge badge-danger px-3 py-2 mr-1" style="border-radius:10px; font-size:0.8rem;">
                            C &nbsp;— En Inicio (0–10)
                        </span>
                        <span class="badge badge-info px-3 py-2 mr-1" style="border-radius:10px; font-size:0.8rem;">
                            B &nbsp;— En Proceso (11–13)
                        </span>
                        <span class="badge badge-primary px-3 py-2 mr-1" style="border-radius:10px; font-size:0.8rem;">
                            A &nbsp;— Logro Esperado (14–17)
                        </span>
                        <span class="badge badge-success px-3 py-2" style="border-radius:10px; font-size:0.8rem;">
                            AD — Logro Destacado (18–20)
                        </span>
                    </div>

                    {{-- Periodo y fecha --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="font-weight-bold small text-muted">Período <span class="text-danger">*</span></label>
                            <select name="periodoID" class="form-control rounded-pill border-0 bg-light shadow-none" required>
                                <option value="">-- Seleccionar período --</option>
                                @foreach($periodos as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombrePeriodo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold small text-muted">Fecha de Registro <span class="text-danger">*</span></label>
                            <input type="date" name="fechaRegistro"
                                   class="form-control rounded-pill border-0 bg-light shadow-none"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold small text-muted">Estado</label>
                            <select name="estadoGeneral" class="form-control rounded-pill border-0 bg-light shadow-none">
                                <option value="Activo" selected>Activo</option>
                                <option value="Provisional">Provisional</option>
                            </select>
                        </div>
                    </div>

                    {{-- Lista de estudiantes con nota --}}
                    <h6 class="font-weight-bold mb-3 d-flex align-items-center">
                        <i class="fas fa-user-graduate mr-2 text-warning"></i>
                        Ingresa la nota de cada estudiante (escala 0 – 20)
                    </h6>

                    <div class="shadow-sm border rounded-lg" style="max-height: 420px; overflow-y: auto;">
                        <table class="table table-striped mb-0">
                            <thead class="bg-light position-sticky" style="top: 0; z-index: 1;">
                                <tr>
                                    <th class="border-0 px-3 py-2 small" style="width:40px;">#</th>
                                    <th class="border-0 py-2 small">Estudiante</th>
                                    <th class="border-0 text-center py-2 small" style="width: 120px;">Nota (0–20)</th>
                                    <th class="border-0 text-center py-2 small" style="width: 160px;">Literal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriculados as $i => $m)
                                <tr>
                                    <td class="align-middle px-3 py-2 text-muted small">{{ $i + 1 }}</td>
                                    <td class="align-middle py-1">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning-soft d-flex align-items-center justify-content-center mr-2"
                                                 style="width: 30px; height: 30px; font-size: 0.65rem; font-weight: bold; color: #e6a100; flex-shrink:0;">
                                                {{ strtoupper(substr($m->estudiante->nombreEstudiante, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold small" style="line-height:1.1;">
                                                    {{ $m->estudiante->nombreEstudiante }} {{ $m->estudiante->apellidoEstudiante }}
                                                </div>
                                                <small class="text-muted" style="font-size:0.62rem;">DNI: {{ $m->estudiante->dniEstudiante }}</small>
                                            </div>
                                        </div>
                                        <input type="hidden" name="notas[{{ $m->idMatriculacion }}][matriculacionID]" value="{{ $m->idMatriculacion }}">
                                    </td>
                                    <td class="align-middle text-center py-1">
                                        <input type="number"
                                               name="notas[{{ $m->idMatriculacion }}][calificacion]"
                                               class="form-control form-control-sm text-center border-0 bg-light nota-input"
                                               min="0" max="20" step="0.5"
                                               placeholder="—"
                                               style="border-radius:10px; font-weight:bold; font-size:0.95rem;"
                                               data-id="{{ $m->idMatriculacion }}">
                                    </td>
                                    <td class="align-middle text-center py-1">
                                        <span class="badge badge-secondary literal-badge px-3 py-2"
                                              id="literal-{{ $m->idMatriculacion }}"
                                              style="border-radius:10px; font-size:0.8rem; min-width:120px; display:inline-block;">
                                            —
                                        </span>
                                        <input type="hidden" name="notas[{{ $m->idMatriculacion }}][literal]"
                                               id="hiddenLiteral-{{ $m->idMatriculacion }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 shadow-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning-custom rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save mr-2"></i>Guardar Calificaciones
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('plugins.Datatables', true)

@section('css')
<style>
    .bg-warning-soft { background-color: #fff8e1; }
    .badge-info-soft     { background-color: #e0f2f1; color: #00796b; border: 1px solid #b2dfdb; }
    .badge-warning-soft  { background-color: #fff3cd; color: #856404; border: 1px solid #ffc107; }
    .badge-secondary-soft{ background-color: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }

    .btn-warning-custom {
        background-color: #ffc107; border: none; color: #212529;
        border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
    }
    .btn-warning-custom:hover {
        background-color: #e0a800; transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,193,7,0.4); color: #212529;
    }
    .hover-lift { transition: all 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); }

    /* Tabs */
    .nav-tabs .nav-link { border-radius: 12px 12px 0 0; color: #6c757d; font-size: 0.85rem; }
    .nav-tabs .nav-link.active { background-color: #fff8e1; color: #e6a100; border-color: #ffc107 #ffc107 #fff; font-weight: 700; }

    /* Input nota */
    .nota-input:focus { box-shadow: 0 0 0 3px rgba(255,193,7,0.3); background-color: #fff8e1 !important; }

    /* Scrollbar suave */
    .table-responsive::-webkit-scrollbar,
    .shadow-sm::-webkit-scrollbar { width: 5px; height: 5px; }
    .table-responsive::-webkit-scrollbar-thumb,
    .shadow-sm::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('#matriculadosTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            "paging": true, "lengthChange": false, "searching": true,
            "ordering": true, "info": true, "responsive": true, "autoWidth": false
        });

        // ---- Cálculo automático del literal según escala vigesimal peruana ----
        // C  = 0–10   (En inicio)
        // B  = 11–13  (En proceso)
        // A  = 14–17  (Logro esperado)
        // AD = 18–20  (Logro destacado)
        function calcularLiteral(nota) {
            nota = parseFloat(nota);
            if (isNaN(nota)) return { texto: '—', clase: 'badge-secondary' };
            if (nota >= 18) return { texto: 'AD — Logro Destacado', clase: 'badge-success' };
            if (nota >= 14) return { texto: 'A — Logro Esperado',   clase: 'badge-primary' };
            if (nota >= 11) return { texto: 'B — En Proceso',       clase: 'badge-info'    };
            return             { texto: 'C — En Inicio',            clase: 'badge-danger'  };
        }

        $(document).on('input', '.nota-input', function () {
            const id  = $(this).data('id');
            const val = $(this).val();
            const r   = calcularLiteral(val);

            $('#literal-' + id)
                .text(r.texto)
                .attr('class', 'badge literal-badge px-3 py-2 ' + r.clase)
                .css({ 'border-radius': '10px', 'font-size': '0.78rem', 'min-width': '120px', 'display': 'inline-block' });

            // Guardar solo la clave (C / B / A / AD) en el hidden
            const clave = val !== '' ? r.texto.split(' ')[0] : '';
            $('#hiddenLiteral-' + id).val(clave);
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ session('success') }}",
            timer: 3500, showConfirmButton: false, toast: true, position: 'top-end'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: "{{ session('error') }}",
            timer: 4000, showConfirmButton: false, toast: true, position: 'top-end'
        });
    @endif
</script>
@stop
