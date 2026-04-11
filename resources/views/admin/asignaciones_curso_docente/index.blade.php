@extends('adminlte::page')

@section('title', 'Asignación de Cursos a Docentes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i>
            Asignación de Cursos a Docentes
        </h1>
        <p class="text-muted mb-0">Gestión de cursos asignados al personal docente por nivel, grado y sección.</p>
    </div>
    <div class="d-flex align-items-center">
        <button class="btn btn-primary-custom px-4 shadow-sm hover-lift ml-2" data-toggle="modal"
            data-target="#modalCreateAsignacion">
            <i class="fas fa-plus-circle mr-2"></i> Nueva Asignación
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
                Registros de Asignaciones
            </h3>
            <div id="div_buscar" class="ml-auto"></div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="asignacionesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">Docente y DNI</th>
                            <th class="border-0">Curso</th>
                            <th class="border-0">Gestión</th>
                            <th class="border-0">Aula y Turno</th>
                            <th class="border-0">Fecha</th>
                            <th class="border-0 text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asignaciones as $a)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="rounded-circle bg-primary-soft d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 45px; height: 45px; font-weight: bold; color: #007bff;">
                                                {{ strtoupper(substr($a->docente->nombrePersonal, 0, 1) . substr($a->docente->apellidoPersonal, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $a->docente->nombrePersonal }} {{ $a->docente->apellidoPersonal }}</div>
                                            <small class="text-muted mb-1 d-block">Docente</small>
                                            <span class="badge badge-light shadow-sm border px-2 py-1" style="border-radius: 6px; color: #495057; font-size: 0.75rem;">
                                                <i class="fas fa-id-card-alt mr-1 text-primary"></i> {{ $a->docente->dniPersonal }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-success">{{ $a->curso->nombreCurso }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="gestion-tag shadow-sm px-3 py-1">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        {{ $a->gestion->nombreGestion }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-info">{{ $a->nivel->nombreNivel }}</span><br>
                                    <small class="text-secondary">{{ $a->grado->nombreGrado }} - Sec: <span class="font-weight-600">{{ $a->seccion->nombreSeccion ?? 'N/A' }}</span></small>
                                    <div class="mt-1">
                                        @php
                                            $turnoLabel = mb_strtolower($a->turno->nombreTurno);
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
                                            <i class="fas fa-clock mr-1 small"></i> {{ $a->turno->nombreTurno }}
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary small font-weight-bold">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($a->fechaAsignarCursoDocente)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-primary btn-circle shadow-sm btn-edit-asignacion mr-2" 
                                            data-toggle="modal" data-target="#modalEditAsignacion"
                                            data-id="{{ $a->idAsignarCursoDocente }}"
                                            data-docente="{{ $a->docenteId }}"
                                            data-curso="{{ $a->cursoID }}"
                                            data-nivel="{{ $a->nivelID }}"
                                            data-gestion="{{ $a->gestionID }}"
                                            data-grado="{{ $a->gradoID }}"
                                            data-seccion="{{ $a->seccionID }}"
                                            data-turno="{{ $a->turnoID }}"
                                            title="Editar Asignación">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.cursos-docentes.destroy', $a->idAsignarCursoDocente) }}" method="POST" class="formulario-eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm shadow-sm" title="Eliminar Asignación">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 pb-4"></div>
</div>

@include('admin.asignaciones_curso_docente.create')
@include('admin.asignaciones_curso_docente.edit')

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

    .dt-buttons .btn {
        margin-right: 5px !important;
        border-radius: 10px !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.375rem 0.75rem;
    }

    #asignacionesTable_filter input {
        border-radius: 10px;
        border: 1.5px solid #eaecf4;
        padding: 0.3rem 0.8rem;
        width: 200px !important;
        transition: all 0.3s;
        margin-left: 8px !important;
    }

    #asignacionesTable_filter input:focus {
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
        $('#docenteId, #cursoID').select2({
            dropdownParent: $('#modalCreateAsignacion'),
            theme: 'bootstrap4',
            width: '100%'
        });
        
        $('#editDocenteID, #editCursoID').select2({
            dropdownParent: $('#modalEditAsignacion'),
            theme: 'bootstrap4',
            width: '100%'
        });
        $('#asignacionesTable').DataTable({
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

        // Confirmación de eliminación
        $(document).on('submit', '.formulario-eliminar', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará la asignación permanentemente.",
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
        
        // Lógica para el Modal de Edición (Rellenar inputs)
        $(document).on('click', '.btn-edit-asignacion', function() {
            let id = $(this).data('id');
            let docente = $(this).data('docente');
            let curso = $(this).data('curso');
            let nivel = $(this).data('nivel');
            let gestion = $(this).data('gestion');
            let grado = $(this).data('grado');
            let seccion = $(this).data('seccion');
            let turno = $(this).data('turno');

            $('#editDocenteID').val(docente).trigger('change');
            $('#editCursoID').val(curso).trigger('change');
            $('#editGestionID').val(gestion).trigger('change');
            $('#editNivelID').val(nivel).trigger('change');
            
            // Actualizar URL del formulario de edición
            let url = "{{ route('admin.cursos-docentes.update', ':id') }}";
            url = url.replace(':id', id);
            $('#formEditAsignacion').attr('action', url);

            // Filtrar Grados y Secciones igual que en matrículas
            filterGradosEdit(nivel, grado);
            filterSeccionesEdit(grado, seccion);
            
            $('#editTurnoID').val(turno).trigger('change');
        });

        function filterGradosEdit(nivelId, selectedGrado = null) {
            let $selectGrado = $('#editGradosID');
            $selectGrado.find('option').each(function() {
                if($(this).val() === "") return;
                if($(this).data('nivel') == nivelId) {
                    $(this).show().prop('disabled', false);
                } else {
                    $(this).hide().prop('disabled', true);
                }
            });
            if (selectedGrado) $selectGrado.val(selectedGrado);
        }

        function filterSeccionesEdit(gradoId, selectedSeccion = null) {
            let $selectSeccion = $('#editSeccionID');
            if (!gradoId) {
                $selectSeccion.prop('disabled', true);
                return;
            }
            $selectSeccion.prop('disabled', false);
            $selectSeccion.find('option').each(function() {
                if($(this).val() === "") return;
                if($(this).data('grado') == gradoId) {
                    $(this).show().prop('disabled', false);
                } else {
                    $(this).hide().prop('disabled', true);
                }
            });
            if (selectedSeccion) $selectSeccion.val(selectedSeccion);
        }

        $('#editNivelID').on('change', function() {
            let nivelId = $(this).val();
            $('#editGradosID').val('');
            $('#editSeccionID').val('').prop('disabled', true);
            filterGradosEdit(nivelId);
        });

        $('#editGradosID').on('change', function() {
            let gradoId = $(this).val();
            $('#editSeccionID').val('').prop('disabled', false);
            filterSeccionesEdit(gradoId);
        });

        $('#nivelID').on('change', function() {
            let nivelId = $(this).val();
            let $selectGrado = $('#gradosID');
            let $selectSeccion = $('#seccionID');
            
            $selectGrado.val('').prop('disabled', false);
            $selectGrado.find('option').each(function() {
                if($(this).val() === "") {
                    $(this).text("Seleccione un grado...");
                    return;
                }
                if($(this).data('nivel') == nivelId) {
                    $(this).show().prop('disabled', false);
                } else {
                    $(this).hide().prop('disabled', true);
                }
            });
            
            $selectSeccion.val('').prop('disabled', true);
            $selectSeccion.find('option[value=""]').text("Seleccione un grado primero...");
        });

        $('#gradosID').on('change', function() {
            let gradoId = $(this).val();
            let $selectSeccion = $('#seccionID');
            
            $selectSeccion.val('').prop('disabled', false);
            $selectSeccion.find('option').each(function() {
                if($(this).val() === "") {
                    $(this).text("Seleccione una sección...");
                    return;
                }
                if($(this).data('grado') == gradoId) {
                    $(this).show().prop('disabled', false);
                } else {
                    $(this).hide().prop('disabled', true);
                }
            });
        });

        // Al abrir modal de creación, asegurar estado inicial
        $('#modalCreateAsignacion').on('show.bs.modal', function () {
            $('#nivelID').val('');
            
            $('#gradosID').val('').prop('disabled', true);
            $('#gradosID').find('option[value=""]').text("Seleccione un nivel primero...");
            
            $('#seccionID').val('').prop('disabled', true);
            $('#seccionID').find('option[value=""]').text("Seleccione un grado primero...");
        });
    });
</script>

@if(session('mensaje') && session('icono'))
    <script>
        Swal.fire({
            title: "¡Hecho!",
            text: "{!! session('mensaje') !!}",
            icon: "{{ session('icono') }}",
            confirmButtonColor: '#007bff',
            timer: 4000,
            timerProgressBar: true
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            title: 'Faltan datos',
            html: '<ul>' + 
                  @foreach ($errors->all() as $error)
                      '<li>{{ $error }}</li>' +
                  @endforeach
                  '</ul>',
            icon: 'error',
            confirmButtonColor: '#007bff'
        });
    </script>
@endif
@stop
