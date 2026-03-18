@extends('adminlte::page')

@section('title', 'Gestión de Cursos')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInLeft">
        <h1 class="text-dark font-weight-bold">
            <i class="fas fa-bookmark text-primary mr-2"></i>Módulos de Cursos
        </h1>
        <button type="button" class="btn btn-primary shadow-sm px-4" data-toggle="modal" data-target="#modalCrearCurso" style="border-radius: 15px; background: linear-gradient(135deg, #2a51be 0%, #3b82f6 100%); border: none;">
            <i class="fas fa-plus-circle mr-2"></i> Nuevo Curso
        </button>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <!-- SECCIÓN DE CARDS -->
    <div class="cards-container mb-5">
        @forelse($niveles as $nivel)
        <div class="pricing-card shadow-lg animate__animated animate__zoomIn">
            <div class="pricing-card-header">
                <label class="small text-uppercase label-nivel-{{ $loop->iteration }}">Nivel Educativo</label>
                <h2 class="heading-6">{{ $nivel->nombreNivel }}<br><span class="second-line">Académico</span></h2>
            </div>
            <div class="pricing-description-wrapper">
                <p class="body text-muted">Gestión completa de las materias e instituciones creadas para el nivel {{ $nivel->nombreNivel }}.</p>
            </div>
            <div class="card-content text-center">
                <div class="button-group">
                    <button type="button" class="button call-to-action btn-ver-cursos-modal btn-nivel-{{ $loop->iteration }}" 
                            data-id="{{ $nivel->id }}" data-nombre="{{ $nivel->nombreNivel }}">
                        <i class="fas fa-list-ul mr-2"></i> Listar Cursos
                    </button>
                </div>
                <hr>
                <div class="features-list text-left">
                    <p class="feature-title text-sm font-weight-bold mb-2">Funciones activas:</p>
                    <div class="code d-block text-xs mb-1"><i class="fas fa-check-circle text-success mr-2"></i> Exportación DataTables</div>
                    <div class="code d-block text-xs"><i class="fas fa-check-circle text-success mr-2"></i> Gestión de Grados</div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center animate__animated animate__zoomIn mt-5">
                <div class="empty-state-premium p-5 shadow-lg mx-auto" style="background: white; border-radius: 30px; border: 2px dashed #3b82f6; max-width: 600px;">
                    <div class="icon-container mb-4">
                        <i class="fas fa-layer-group fa-5x text-primary" style="opacity: 0.3"></i>
                    </div>
                    <h2 class="font-weight-bold text-dark mb-3">No hay ningún curso disponible</h2>
                    <p class="text-muted lead mb-4 font-weight-normal">
                        Para poder gestionar cursos, primero debe registrar los <b>Niveles Educativos</b> en el sistema.
                    </p>
                    <a href="{{ route('admin.niveles.index') }}" class="btn btn-primary btn-lg shadow-sm px-5" style="border-radius: 15px; background: linear-gradient(135deg, #2a51be 0%, #3b82f6 100%); border: none; font-weight: bold;">
                        <i class="fas fa-plus-circle mr-2"></i> Ir a Ingresar Nivel
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- MODAL ÚNICO PARA LA TABLA -->
    <div class="modal fade animate__animated animate__fadeIn" id="modalCursosNivel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content shadow-2xl" style="border-radius: 20px; border: none;">
                <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-university mr-2"></i> Cursos del Nivel: <span id="nombre-nivel-modal" class="text-uppercase underline"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="card card-outline card-primary shadow-none mb-0">
                        <div class="card-body">
                            <div id="wrapper_tabla" class="table-responsive">
                                <table id="tabla_cursos_principal" class="table table-bordered table-striped table-hover dtr-inline w-100">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Grado</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_cursos_ajax">
                                        <!-- Js cargará los datos aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales --}}
@include('admin.cursos.create')
@include('admin.cursos.edit')

{{-- Formulario oculto para eliminación lógica --}}
<form id="formEliminarCurso" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        --card-bg: #ffffff;
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem;
        justify-content: center;
        padding-top: 20px;
    }

    .pricing-card {
        background: var(--card-bg);
        border-radius: 24px;
        width: 330px;
        padding: 1.8rem;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.08);
    }

    .pricing-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
    }

    .pricing-card-header .small {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 800;
        letter-spacing: 0.5px;
        font-size: 0.65rem;
    }

    /* COLORES DINÁMICOS POR NIVEL */
    .label-nivel-1 { background: #d1fae5 !important; color: #065f46 !important; } /* Verde suave */
    .label-nivel-2 { background: #dbeafe !important; color: #1e40af !important; } /* Azul suave */
    .label-nivel-3 { background: #e0e7ff !important; color: #3730a3 !important; } /* Indigo suave */

    .heading-6 { font-weight: 900; font-size: 1.6rem; margin-top: 15px; color: #111827; }
    .second-line { color: #6b7280; font-weight: 500; font-size: 1.1rem; }

    .button-group .call-to-action {
        width: 100%;
        padding: 14px;
        border-radius: 15px;
        border: none;
        color: white;
        font-weight: 700;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .button-group .call-to-action:hover {
        transform: scale(1.03);
        filter: brightness(1.1);
    }

    /* GRADIENTES POR NIVEL */
    .btn-nivel-1 { background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important; }
    .btn-nivel-2 { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important; }
    .btn-nivel-3 { background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%) !important; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important; }
    .btn-nivel-4 { background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%) !important; }

    /* Estilos DataTable Buttons */
    .dt-buttons .btn {
        margin-right: 5px !important;
        border-radius: 8px !important;
        font-weight: 600;
        font-size: 0.85rem;
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
$(document).ready(function() {
    let currentNivelId = null;
    let currentNivelNombre = "";

    $('.btn-ver-cursos-modal').click(function() {
        currentNivelId = $(this).data('id');
        currentNivelNombre = $(this).data('nombre');
        
        $('#nombre-nivel-modal').text(currentNivelNombre);
        $('#modalCursosNivel').modal('show');

        // Reinicio de la tabla y mostrar Loading Premium
        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tabla_cursos_principal')) {
            $('#tabla_cursos_principal').DataTable().destroy();
        }
        
        $('#body_cursos_ajax').html(`
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="loading-wrapper p-5">
                        <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                        <div class="spinner-grow text-info" role="status" style="width: 3rem; height: 3rem;"></div>
                        <div class="spinner-grow text-secondary" role="status" style="width: 3rem; height: 3rem;"></div>
                        <h5 class="mt-4 text-dark font-weight-bold animate__animated animate__pulse animate__infinite">
                            Sincronizando malla curricular...
                        </h5>
                        <p class="text-muted small">Por favor, espera un momento.</p>
                    </div>
                </td>
            </tr>
        `);

        $.ajax({
            url: "{{ route('admin.cursos.index') }}", 
            type: 'GET',
            data: { nivel_id: currentNivelId },
            success: function(json_response) {
                if (json_response.length === 0) {
                    $('#body_cursos_ajax').html(`
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-gray mb-3"></i>
                                <h4 class="text-secondary font-weight-bold">No hay cursos disponibles</h4>
                                <p class="text-muted small">No se encontraron registros para este nivel.</p>
                            </td>
                        </tr>
                    `);
                } else {
                    let rows = "";
                    json_response.forEach(function(curso) {
                        let statusBadge = curso.estado === 'Activo' 
                            ? '<span class="badge badge-success rounded-pill px-3">Activo</span>' 
                            : '<span class="badge badge-danger rounded-pill px-3">Inactivo</span>';
                        
                        rows += `<tr>
                            <td class="font-weight-bold">${curso.codigoCurso}</td>
                            <td>${curso.nombreCurso}</td>
                            <td class="small text-muted">${curso.descripcionCurso || '---'}</td>
                            <td><span class="badge badge-info">${curso.grado ? curso.grado.nombreGrado : 'N/A'}</span></td>
                            <td>${statusBadge}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-warning btn-sm mx-1 btn-edit-curso" 
                                        data-id="${curso.idCurso}" 
                                        data-codigo="${curso.codigoCurso}"
                                        data-nombre="${curso.nombreCurso}"
                                        data-descripcion="${curso.descripcionCurso || ''}"
                                        data-gradoid="${curso.gradoID}"
                                        data-gradonombre="${curso.grado ? curso.grado.nombreGrado : 'N/A'}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm mx-1 btn-delete-curso" 
                                        data-id="${curso.idCurso}" 
                                        data-nombre="${curso.nombreCurso}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    });

                    $('#body_cursos_ajax').html(rows);
                    
                    $("#tabla_cursos_principal").DataTable({
                        "responsive": true, 
                        "lengthChange": false, 
                        "autoWidth": false,
                        "dom": 'Bfrtip', // Mostrar botones
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        "language": {
                            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                        }
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'No se pudieron cargar los cursos', 'error');
            }
        });
    });

    // Manejador para abrir el modal de edición
    $(document).on('click', '.btn-edit-curso', function() {
        let id = $(this).data('id');
        let codigo = $(this).data('codigo');
        let nombre = $(this).data('nombre');
        let descripcion = $(this).data('descripcion');
        let gradoId = $(this).data('gradoid');
        let gradoNombre = $(this).data('gradonombre');

        // Llenar campos del modal
        $('#edit_codigoCurso').val(codigo);
        $('#edit_nombreCurso').val(nombre);
        $('#edit_descripcionCurso').val(descripcion === 'NINGUNO' ? '' : descripcion);
        $('#edit_gradoID').val(gradoId);
        $('#edit_gradoNombre').val(gradoNombre);
        $('#edit_nombre_display').text(nombre);

        // Ajustar la acción del formulario
        let url = "{{ route('admin.cursos.update', ':id') }}";
        url = url.replace(':id', id);
        $('#formEditarCurso').attr('action', url);

        // Mostrar modal
        $('#modalEditarCurso').modal('show');
    });

    // Manejador para la eliminación lógica (Cambio de estado)
    $(document).on('click', '.btn-delete-curso', function() {
        let id = $(this).data('id');
        let nombre = $(this).data('nombre');

        Swal.fire({
            title: '¿Estás seguro?',
            text: `El curso "${nombre}" será desactivado y no aparecerá en las listas activas.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('admin.cursos.destroy', ':id') }}";
                url = url.replace(':id', id);
                $('#formEliminarCurso').attr('action', url).submit();
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
        confirmButtonColor: '#3b82f6',
        timer: 4000,
        timerProgressBar: true
    });
</script>
@endif
@stop

