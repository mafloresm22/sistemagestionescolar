@extends('adminlte::page')

@section('title', 'Calificaciones')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-star-half-alt mr-2 text-warning"></i>
            Control de Calificaciones
        </h1>
        <p class="text-muted mb-0">Selecciona un curso para registrar o gestionar las calificaciones de los estudiantes.</p>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 animate__animated animate__fadeInUp"
        style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center pr-3"
            style="border-radius: 15px 15px 0 0;">
            <h3 class="card-title font-weight-bold text-dark mb-0">
                <i class="fas fa-chalkboard mr-2 text-secondary"></i>
                Cursos Asignados
            </h3>
            <div id="div_buscar" class="ml-auto"></div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="calificacionesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">Docente</th>
                            <th class="border-0">Curso</th>
                            <th class="border-0">Nivel y Grado</th>
                            <th class="border-0 text-center">Sección</th>
                            <th class="border-0 text-center">Turno</th>
                            <th class="border-0 text-center">Gestión</th>
                            <th class="border-0 text-center" style="width: 160px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asignaciones as $a)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="rounded-circle bg-warning-soft d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 45px; height: 45px; font-weight: bold; color: #e6a100;">
                                                {{ strtoupper(substr($a->docente->nombrePersonal, 0, 1) . substr($a->docente->apellidoPersonal, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $a->docente->nombrePersonal }} {{ $a->docente->apellidoPersonal }}</div>
                                            <small class="text-muted">Docente Encargado</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-light border px-3 py-2 shadow-sm" style="border-radius: 8px;">
                                        <i class="fas fa-book mr-2 text-info"></i>{{ $a->curso->nombreCurso }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-info">{{ $a->nivel->nombreNivel }}</span><br>
                                    <small class="text-secondary">{{ $a->grado->nombreGrado }}</small>
                                </td>
                                <td class="align-middle text-center text-secondary font-weight-600">
                                    {{ $a->seccion->nombreSeccion ?? 'N/A' }}
                                </td>
                                <td class="align-middle text-center">
                                    @php
                                        $turnoLabel = mb_strtolower($a->turno->nombreTurno);
                                        $badgeClass = 'badge-light';
                                        if (str_contains($turnoLabel, 'mañana')) $badgeClass = 'badge-warning';
                                        elseif (str_contains($turnoLabel, 'tarde')) $badgeClass = 'badge-orange';
                                        elseif (str_contains($turnoLabel, 'noche')) $badgeClass = 'badge-info';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-2 py-1" style="border-radius: 6px;">
                                        <i class="fas fa-clock mr-1 small"></i> {{ $a->turno->nombreTurno }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="gestion-tag shadow-sm px-3 py-1">
                                        <i class="fas fa-graduation-cap mr-2"></i>
                                        {{ $a->gestion->nombreGestion }}
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.calificaciones.create', $a->idAsignarCursoDocente) }}"
                                       class="btn btn-warning-custom btn-sm px-3 shadow-sm hover-lift">
                                        <i class="fas fa-pen mr-2"></i>Calificar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
<style>
    :root {
        --warning-color: #ffc107;
        --warning-soft: #fff8e1;
    }
    .bg-warning-soft { background-color: var(--warning-soft); }
    .gestion-tag {
        display: inline-flex; align-items: center;
        background-color: #f3f0ff; color: #5f3dc4;
        border: 1.5px solid #dcd3ff; border-radius: 10px;
        font-weight: 800; font-size: 0.8rem;
    }
    .btn-warning-custom {
        background-color: #ffc107; border: none; color: #212529;
        border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
        font-size: 0.8rem; white-space: nowrap;
    }
    .btn-warning-custom:hover {
        background-color: #e0a800; transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4); color: #212529;
    }
    .hover-lift { transition: transform 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); }
    .badge-orange { background-color: #fd7e14; color: white; }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function () {
        $('#calificacionesTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            "paging": true, "lengthChange": false, "searching": true, "ordering": true,
            "info": true, "responsive": true, "autoWidth": false,
            "dom": "<'row mb-3 px-4 pt-4'<'col-md-8'B><'col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-4 px-4 pb-4'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "buttons": [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copiar',
                    className: 'btn btn-secondary shadow-sm'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success shadow-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger shadow-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-dark shadow-sm'
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-columns"></i> Columnas',
                    className: 'btn btn-white shadow-sm'
                }
            ]
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: "{{ session('error') }}",
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif
</script>
@stop
