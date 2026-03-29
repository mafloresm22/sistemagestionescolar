@extends('adminlte::page')

@section('title', 'Asignación de Aulas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i>
            Asignación de Aulas
        </h1>
        <p class="text-muted mb-0">Asigna aulas a secciones, gestiones y docentes responsables.</p>
    </div>
    <div class="d-flex align-items-center">
        <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal"
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
                            <th class="border-0 px-4">Aula</th>
                            <th class="border-0">Sección / Grado</th>
                            <th class="border-0">Docente</th>
                            <th class="border-0">Gestión</th>
                            <th class="border-0">Turno</th>
                            <th class="border-0 text-center">Estado</th>
                            <th class="border-0 text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asignaciones as $a)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-primary-soft rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-door-open text-primary"></i>
                                        </div>
                                        <span class="font-weight-bold text-dark">{{ $a->aula->nombreAula }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-info">{{ $a->seccion->nombreSeccion }} - </span>
                                    <small class="text-secondary">{{ $a->seccion->grados->nombreGrado }} - {{ $a->seccion->grados->nivel->nombreNivel }}</small>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-tie mr-2 text-muted"></i>
                                        <span>{{ $a->personal->nombrePersonal }} {{ $a->personal->apellidoPersonal }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="gestion-tag shadow-sm px-3 py-1">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        {{ $a->gestion->nombreGestion }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-light border px-2 py-1" style="border-radius: 6px;">
                                        <i class="fas fa-clock mr-1 small text-warning"></i> {{ $a->turno->nombreTurno }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-pill {{ $a->estadoAsignarSeccionAula == 'Activo' ? 'badge-success' : 'badge-danger' }} px-3 py-2">
                                        {{ strtoupper($a->estadoAsignarSeccionAula) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                        <button type="button" class="btn btn-primary btn-circle btn-sm shadow-sm btn-edit-asignacion" 
                                            data-id="{{ $a->idAsignarSeccionAula }}"
                                            data-aula="{{ $a->aulaID }}"
                                            data-seccion="{{ $a->seccionID }}"
                                            data-gestion="{{ $a->gestionID }}"
                                            data-turno="{{ $a->turnoID }}"
                                            data-personal="{{ $a->personalID }}"
                                            data-obs="{{ $a->observacionesAsignarSeccionAula }}"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.asignar-secciones-aulas.destroy', $a->idAsignarSeccionAula) }}" method="POST" class="formulario-eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm shadow-sm" title="Eliminar">
                                                <i class="fas fa-trash"></i>
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
</div>

@include('admin.aulas.asignacion.create')
@include('admin.aulas.asignacion.edit')

@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
<style>
    .bg-primary-soft { background-color: #e7f1ff; }
    .btn-primary-custom {
        background-color: #007bff; border: none; color: white;
        border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
    }
    .btn-primary-custom:hover {
        background-color: #0056b3; transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4); color: white;
    }
    .gestion-tag {
        display: inline-flex; align-items: center;
        background-color: #f3f0ff; color: #5f3dc4;
        border: 1.5px solid #dcd3ff; border-radius: 10px;
        font-weight: 800; font-size: 0.8rem;
    }
    .btn-circle {
        width: 35px; height: 35px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0; transition: all 0.3s ease; border: none;
    }
    .btn-circle:hover { transform: scale(1.15); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
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

<script>
    $(document).ready(function () {
        $('.select2').select2({ theme: 'bootstrap4' });

        $('#asignacionesTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            "paging": true, "lengthChange": false, "searching": true,
            "ordering": true, "info": true, "responsive": true, "autoWidth": false,
            "dom": "<'row mb-3 px-4 pt-4'<'col-md-8'B><'col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-4 px-4 pb-4'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "buttons": [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar', className: 'btn btn-secondary btn-sm shadow-sm' },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm shadow-sm' },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-danger btn-sm shadow-sm' },
                { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir', className: 'btn btn-dark btn-sm shadow-sm' }
            ]
        });

        $(document).on('click', '.btn-edit-asignacion', function() {
            let id = $(this).data('id');
            $('#editAulaID').val($(this).data('aula')).trigger('change');
            $('#editSeccionID').val($(this).data('seccion')).trigger('change');
            $('#editPersonalID').val($(this).data('personal')).trigger('change');
            $('#editGestionID').val($(this).data('gestion'));
            $('#editTurnoID').val($(this).data('turno'));
            $('#editObs').val($(this).data('obs'));

            let url = "{{ route('admin.asignar-secciones-aulas.update', ':id') }}";
            url = url.replace(':id', id);
            $('#formEditAsignacion').attr('action', url);
            $('#modalEditAsignacion').modal('show');
        });

        $(document).on('submit', '.formulario-eliminar', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la asignación de aula.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });
    });
</script>

@if(session('mensaje'))
    <script>
        Swal.fire({
            title: "¡Hecho!",
            text: "{{ session('mensaje') }}",
            icon: "{{ session('icono') }}",
            confirmButtonColor: '#007bff',
            timer: 3000
        });
    </script>
@endif
@stop
