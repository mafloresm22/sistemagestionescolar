@extends('adminlte::page')

@section('title', 'Listado de Matriculaciones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
            <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                <i class="fas fa-file-signature mr-2 text-primary"></i>
                Listado de Matriculaciones
            </h1>
            <p class="text-muted mb-0">Gestión de inscripciones de estudiantes por nivel, grado y sección.</p>
        </div>
        <div class="d-flex align-items-center">
            <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreateMatriculacion">
                <i class="fas fa-plus-circle mr-2"></i> Nueva Matriculación
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center pr-3" style="border-radius: 15px 15px 0 0;">
            <h3 class="card-title font-weight-bold text-dark mb-0">
                <i class="fas fa-table mr-2 text-secondary"></i>
                Registros de Matrículas
            </h3>
            <div id="div_buscar" class="ml-auto"></div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="matriculasTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">Estudiante</th>
                            <th class="border-0">Nivel y Grado</th>
                            <th class="border-0">Sección</th>
                            <th class="border-0">Turno</th>
                            <th class="border-0">Gestión</th>
                            <th class="border-0">Fecha</th>
                            <th class="border-0 text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matriculacions as $m)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="rounded-circle bg-primary-soft d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; font-weight: bold; color: #007bff;">
                                                {{ strtoupper(substr($m->estudiante->nombreEstudiante, 0, 1) . substr($m->estudiante->apellidoEstudiante, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $m->estudiante->nombreEstudiante }} {{ $m->estudiante->apellidoEstudiante }}</div>
                                            <small class="text-muted">DNI: {{ $m->estudiante->dniEstudiante }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-info">{{ $m->nivel->nombreNivel }}</span><br>
                                    <small class="text-secondary">{{ $m->grado->nombreGrado }}</small>
                                </td>
                                <td class="align-middle text-secondary font-weight-600">
                                    {{ $m->seccion->nombreSeccion ?? 'N/A' }}
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-light border px-2 py-1">{{ $m->turno->nombreTurno }}</span>
                                </td>
                                <td class="align-middle text-secondary font-weight-600">
                                    {{ $m->gestion->nombreGestion }}
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary">
                                        {{ \Carbon\Carbon::parse($m->fechaMatriculacion)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                        <a href="{{ route('admin.matriculacion.edit', $m->idMatriculacion) }}" class="btn btn-sm btn-white text-primary btn-action-table" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.matriculacion.show', $m->idMatriculacion) }}" class="btn btn-sm btn-white text-info btn-action-table" title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.estudiantes.matriculacion.create')
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('css')
<style>
    :root {
        --primary-blue: #007bff;
        --primary-soft: #e7f1ff;
    }

    .bg-primary-soft { background-color: var(--primary-soft); }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        color: white;
    }

    .hover-lift { transition: transform 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); }

    .table thead th {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #858796;
        background-color: #f8f9fc;
    }

    .btn-action-table {
        background: white;
        border: 1px solid #e3e6f0;
        padding: 0.4rem 0.75rem;
        transition: all 0.2s;
    }

    .btn-action-table:hover {
        background: #f8f9fc;
        transform: scale(1.05);
        z-index: 1;
    }

    #matriculasTable_filter input {
        border-radius: 10px;
        border: 1.5px solid #eaecf4;
        padding: 0.3rem 0.8rem;
        width: 220px !important;
        transition: all 0.3s;
        margin-left: 8px !important;
    }

    #matriculasTable_filter input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.1);
        width: 300px !important;
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#matriculasTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            "dom": '<"p-0"f>t<"card-footer bg-white d-flex justify-content-between align-items-center border-top-0 px-3 py-2"ip>',
        });

        $('#div_buscar').append($('#matriculasTable_filter'));
    });
</script>
@stop
