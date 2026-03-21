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
        <button class="btn btn-secondary-custom px-4 shadow-sm hover-lift" data-toggle="modal"
            data-target="#modalHistorialEstudiante">
            <i class="fas fa-history mr-2"></i> Historial Estudiante
        </button>
        <button class="btn btn-primary-custom px-4 shadow-sm hover-lift ml-2" data-toggle="modal"
            data-target="#modalCreateMatriculacion">
            <i class="fas fa-plus-circle mr-2"></i> Nueva Matriculación
        </button>
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
                            <th class="border-0 px-4">DNI</th>
                            <th class="border-0">Gestión</th>
                            <th class="border-0">Nivel y Grado</th>
                            <th class="border-0">Sección</th>
                            <th class="border-0">Turno</th>
                            <th class="border-0">Fecha</th>
                            <th class="border-0 text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matriculacions as $m)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="rounded-circle bg-primary-soft d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 45px; height: 45px; font-weight: bold; color: #007bff;">
                                                {{ strtoupper(substr($m->estudiante->nombreEstudiante, 0, 1) . substr($m->estudiante->apellidoEstudiante, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $m->estudiante->nombreEstudiante }}
                                                {{ $m->estudiante->apellidoEstudiante }}</div>
                                            <small class="text-muted">Estudiante Matriculado</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 align-middle font-weight-bold text-dark">
                                    <span class="badge badge-light shadow-sm border px-3 py-2" style="border-radius: 8px; color: #495057;">
                                        <i class="fas fa-id-card-alt mr-2 text-primary"></i> {{ $m->estudiante->dniEstudiante }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="gestion-tag shadow-sm px-3 py-1">
                                        <i class="fas fa-graduation-cap mr-2"></i>
                                        {{ $m->gestion->nombreGestion }}
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
                                    @php
                                        $turnoLabel = mb_strtolower($m->turno->nombreTurno);
                                        $badgeClass = 'badge-light';
                                        $customStyle = '';

                                        if (str_contains($turnoLabel, 'mañana')) {
                                            $badgeClass = 'badge-warning';
                                            $customStyle = 'color: #856404; background-color: #fff3cd; border: 1px solid #ffeeba;';
                                        } elseif (str_contains($turnoLabel, 'tarde')) {
                                            $badgeClass = 'btn-orange';
                                            $customStyle = 'color: #ffffff; background-color: #fd7e14; border: none;';
                                        } elseif (str_contains($turnoLabel, 'noche')) {
                                            $badgeClass = 'badge-info';
                                            $customStyle = 'color: #fff; background-color: #17a2b8; border: none;';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-2 py-1"
                                        style="border-radius: 6px; {{ $customStyle }}">
                                        <i class="fas fa-clock mr-1 small"></i> {{ $m->turno->nombreTurno }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary small font-weight-bold">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($m->fechaMatriculacion)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.matriculacion.show', $m->idMatriculacion) }}"
                                        class="btn btn-info btn-circle shadow-sm" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.matriculacion.imprimir', $m->idMatriculacion) }}" 
                                        target="_blank" class="btn btn-success btn-circle shadow-sm" title="Imprimir Matrícula">
                                        <i class="fas fa-print"></i>
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

@include('admin.estudiantes.matriculacion.create')
@include('admin.estudiantes.matriculacion.historial')
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
<style>
    :root {
        --primary-blue: #007bff;
        --primary-soft: #e7f1ff;
    }

    .bg-primary-soft {
        background-color: var(--primary-soft);
    }

    .gestion-tag {
        display: inline-flex;
        align-items: center;
        background-color: #f3f0ff;
        color: #5f3dc4;
        border: 1.5px solid #dcd3ff;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.2px;
        transition: all 0.3s ease;
    }

    .gestion-tag:hover {
        background-color: #5f3dc4;
        color: #fff;
        transform: scale(1.05);
    }

    .btn-primary-custom {
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        color: white;
    }

    .btn-secondary-custom {
        background-color: #f8a712;
        border: none;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background-color: #f9ca30;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(243, 223, 8, 0.89);
        color: white;
    }

    .btn-secondary-custom i {
        transition: transform 0.4s ease;
    }

    .btn-secondary-custom:hover i {
        transform: rotate(-360deg);
    }

    .btn-primary-custom i {
        transition: transform 0.4s ease;
    }

    .btn-primary-custom:hover i {
        transform: scale(1.2) rotate(90deg);
    }

    .hover-lift {
        transition: transform 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
    }

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

    /* Estilo de los botones */
    .dt-buttons .btn {
        margin-right: 5px !important;
        border-radius: 10px !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.375rem 0.75rem;
    }

    #matriculasTable_filter input {
        border-radius: 10px;
        border: 1.5px solid #eaecf4;
        padding: 0.3rem 0.8rem;
        width: 200px !important;
        transition: all 0.3s;
        margin-left: 8px !important;
    }

    #matriculasTable_filter input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.1);
        width: 250px !important;
    }

    .btn-orange {
        color: #fff;
        background-color: #fd7e14;
        border-color: #fd7e14;
    }
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
            "autoWidth": false,
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
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-info shadow-sm'
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

        // Lógica para el Buscador de Historial en Modal
        $('#btnBuscarHistorial').on('click', function () {
            let query = $('#inputBuscarHistorial').val();
            if (query.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debes ingresar un nombre o DNI para buscar.',
                    confirmButtonColor: '#f8a712'
                });
                return;
            }

            // Mostrar estado de carga
            $('#placeholderHistorial').html('<div class="spinner-border text-warning" role="status"><span class="sr-only">Cargando...</span></div><p class="mt-2">Buscando registros...</p>');

            $.ajax({
                url: "{{ route('admin.matriculacion.buscar-historial') }}",
                method: 'GET',
                data: { query: query },
                success: function (data) {
                    $('#bodyResultadosHistorial').empty();

                    if (data.length > 0) {
                        $('#placeholderHistorial').addClass('d-none');
                        $('#tablaResultados').removeClass('d-none');

                        data.forEach(m => {
                            let avatar = (m.estudiante.nombreEstudiante.charAt(0) + m.estudiante.apellidoEstudiante.charAt(0)).toUpperCase();
                            let html = `
                                <tr>
                                    <td class="px-4">
                                        <div class="gestion-tag shadow-sm px-2 py-1 text-center">
                                            ${m.gestion.nombreGestion}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center shadow-sm mr-2"
                                                style="width: 30px; height: 30px; font-weight: bold; font-size: 0.8rem;">
                                                ${avatar}
                                            </div>
                                            <div style="line-height: 1.2;">
                                                <div class="font-weight-bold text-dark small">${m.estudiante.nombreEstudiante} ${m.estudiante.apellidoEstudiante}</div>
                                                <small class="text-muted" style="font-size: 0.7rem;">${m.estudiante.dniEstudiante}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-info font-weight-bold small">${m.nivel.nombreNivel}</div>
                                        <small class="text-secondary" style="font-size: 0.75rem;">${m.grado.nombreGrado} - Secc. ${m.seccion ? m.seccion.nombreSeccion : 'N/A'}</small>
                                    </td>
                                    <td class="text-dark small">${m.turno.nombreTurno}</td>
                                    <td class="text-center">
                                        <span class="badge badge-soft-success">
                                            ${m.estadoMatriculacion}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="/admin/estudiantes/matriculacion/imprimir/${m.idMatriculacion}" 
                                                target="_blank" class="btn btn-success btn-circle btn-sm shadow-sm mr-2" title="Imprimir Matrícula">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="/admin/estudiantes/matriculacion/edit/${m.idMatriculacion}" 
                                                class="btn btn-primary btn-circle btn-sm shadow-sm mr-2" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/admin/estudiantes/matriculacion/delete/${m.idMatriculacion}" method="POST" class="formulario-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-circle btn-sm shadow-sm" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            $('#bodyResultadosHistorial').append(html);
                        });
                    } else {
                        $('#tablaResultados').addClass('d-none');
                        $('#placeholderHistorial').removeClass('d-none').html(`
                            <div class="display-3 text-warning opacity-25 mb-3">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h5 class="text-secondary font-weight-light">No se encontraron registros para "${query}"</h5>
                        `);
                    }
                },
                error: function (e) {
                    console.error('Error en búsqueda:', e);
                    $('#placeholderHistorial').html('<p class="text-danger">Error al realizar la búsqueda. Por favor intente de nuevo.</p>');
                }
            });
        });

        // Permitir buscar con ENTER
        $('#inputBuscarHistorial').on('keypress', function (e) {
            if (e.which == 13) {
                $('#btnBuscarHistorial').click();
            }
        });

        // Confirmación de eliminación (Delegada para elementos dinámicos)
        $(document).on('submit', '.formulario-eliminar', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará el registro de matrícula permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>

@if(session('mensaje') && session('icono'))
    <script>
        Swal.fire({
            title: "¡Hecho!",
            text: "{{ session('mensaje') }}",
            icon: "{{ session('icono') }}",
            confirmButtonColor: '#007bff',
            timer: 4000,
            timerProgressBar: true
        });
    </script>
@endif
@stop