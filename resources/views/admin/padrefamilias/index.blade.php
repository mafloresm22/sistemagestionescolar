@extends('adminlte::page')

@section('title', 'Listado de Apoderados')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
            <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                <i class="fas fa-user-shield mr-2 text-info"></i>
                Listado de Apoderados
            </h1>
            <p class="text-muted mb-0">Gestión de padres de familia y tutores legales del sistema.</p>
        </div>
        <div class="d-flex align-items-center">
            <button class="btn btn-info-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreatePadre">
                <i class="fas fa-plus-circle mr-2"></i> Nuevo Apoderado
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
                Registros de Padres de Familia
            </h3>
            <div id="div_buscar" class="ml-auto"></div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="padresTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">Apoderado</th>
                            <th class="border-0">DNI</th>
                            <th class="border-0">F. Nacimiento</th>
                            <th class="border-0">Contacto</th>
                            <th class="border-0">Dirección</th>
                            <th class="border-0 text-center">Estado</th>
                            <th class="border-0 text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($padres as $p)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="rounded-circle bg-info-soft d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; font-weight: bold; color: #17a2b8;">
                                                {{ strtoupper(substr($p->nombrePadreFamilia, 0, 1) . substr($p->apellidoPadreFamilia, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $p->nombrePadreFamilia }} {{ $p->apellidoPadreFamilia }}</div>
                                            <small class="text-muted">{{ $p->correoPadreFamilia }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-secondary font-weight-600">{{ $p->dniPadreFamilia }}</td>
                                <td class="align-middle">
                                    <span class="text-secondary font-weight-600">
                                        {{ $p->fechaNacimientoPadreFamilia ? \Carbon\Carbon::parse($p->fechaNacimientoPadreFamilia)->format('d/m/Y') : '-' }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary font-weight-600">{{ $p->celularPadreFamilia }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary font-weight-600" style="font-size: 0.75rem;">{{ Str::limit($p->direccionPadreFamilia, 30) }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-pill {{ $p->estadoPadreFamilia == 'Activo' ? 'badge-success' : 'badge-danger' }} px-3 py-2 shadow-sm" style="font-size: 0.75rem;">
                                        {{ strtoupper($p->estadoPadreFamilia) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                        @if($p->estadoPadreFamilia == 'Activo')
                                            {{-- Botón Editar (Solo Activos) --}}
                                            <button class="btn btn-sm btn-white text-primary btn-action-table" title="Editar" 
                                                onclick="editPadre('{{ route('admin.padres.update', $p->idPadreFamilia) }}', '{{ $p->nombrePadreFamilia }}', '{{ $p->apellidoPadreFamilia }}', '{{ $p->dniPadreFamilia }}', '{{ $p->generoPadreFamilia }}', '{{ $p->fechaNacimientoPadreFamilia }}', '{{ $p->celularPadreFamilia }}', '{{ $p->correoPadreFamilia }}', '{{ $p->direccionPadreFamilia }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Botón Eliminar (Desactiva) --}}
                                            <form id="delete-form-{{ $p->idPadreFamilia }}" action="{{ route('admin.padres.destroy', $p->idPadreFamilia) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="nuevoEstado" value="Inactivo">
                                            </form>
                                            <button class="btn btn-sm btn-white text-danger btn-action-table" title="Eliminar" 
                                                onclick="confirmDelete(event, 'delete-form-{{ $p->idPadreFamilia }}', 'a {{ $p->nombrePadreFamilia }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @else
                                            {{-- Botón Editar Deshabilitado (Para Inactivos) --}}
                                            <button class="btn btn-sm btn-white text-muted btn-action-table" title="No se puede editar un registro inactivo" disabled style="cursor: not-allowed; opacity: 0.6;">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Botón Habilitar --}}
                                            <form id="enable-form-{{ $p->idPadreFamilia }}" action="{{ route('admin.padres.destroy', $p->idPadreFamilia) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="nuevoEstado" value="Activo">
                                            </form>
                                            <button class="btn btn-sm btn-white text-success btn-action-table" title="Habilitar" 
                                                onclick="confirmActivate(event, 'enable-form-{{ $p->idPadreFamilia }}', 'a {{ $p->nombrePadreFamilia }}')">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-user-friends fa-3x mb-3 opacity-2"></i>
                                        <p class="h5">No se encontraron apoderados</p>
                                        <button class="btn btn-info-custom mt-2" data-toggle="modal" data-target="#modalCreatePadre">
                                            <i class="fas fa-plus mr-1"></i> Registrar Primer Apoderado
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.padrefamilias.create')
@include('admin.padrefamilias.edit')

@stop

@section('plugins.Datatables', true)

@section('css')
<style>
    html, body {
        height: 100% !important;
        background-color: #f4f6f9 !important;
    }
    
    body.swal2-height-auto {
        height: 100% !important;
    }

    :root {
        --info-blue: #17a2b8;
        --info-soft: #e0f7fa;
    }

    .bg-info-soft { background-color: var(--info-soft); }
    
    .btn-info-custom {
        background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
        border: none;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-info-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
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

    /* Eliminar margen inferior de la tabla para evitar la línea blanca */
    #padresTable {
        margin-bottom: 0 !important;
    }

    .table-responsive {
        margin-bottom: 0 !important;
    }

    /* Estilos para el Buscador de DataTables */
    .dataTables_filter {
        margin: 0 !important;
        padding: 0 !important;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        margin-bottom: 0;
        font-weight: 700;
        color: #5a5c69;
        font-size: 0.85rem;
    }
    
    .dataTables_filter input {
        border-radius: 10px;
        border: 1.5px solid #eaecf4;
        padding: 0.3rem 0.8rem;
        width: 220px !important;
        transition: all 0.3s;
        margin-left: 8px !important;
        font-weight: normal;
    }

    .dataTables_filter input:focus {
        border-color: #17a2b8;
        outline: none;
        box-shadow: 0 0 10px rgba(23, 162, 184, 0.1);
        width: 300px !important;
    }

    .dataTables_info { font-size: 0.85rem; color: #858796; padding-left: 15px; }
    .dataTables_paginate { padding-right: 15px; padding-top: 10px; }
</style>
@stop

@section('js')
<script>
    // Función para confirmación de eliminación 
    function confirmDelete(event, formId, entityName = 'este registro') {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Realmente deseas eliminar ${entityName}? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4b5c',
            cancelButtonColor: '#007bff',
            confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger px-4 mx-2',
                cancelButton: 'btn btn-primary px-4 mx-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    // Función para confirmación de activación
    function confirmActivate(event, formId, entityName = 'este registro') {
        event.preventDefault();
        Swal.fire({
            title: '¿Habilitar apoderado?',
            text: `¿Deseas reactivar al apoderado ${entityName}? Volverá a aparecer como Activo en el sistema.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check"></i> Sí, habilitar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-success px-4 mx-2',
                cancelButton: 'btn btn-secondary px-4 mx-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    $(document).ready(function() {
        // Inicializar DataTable
        $('#padresTable').DataTable({
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            "dom": '<"p-0"f>t<"card-footer bg-white d-flex justify-content-between align-items-center border-top-0 px-3 py-2"ip>',
        });

        // Mover el buscador de DataTables al header del card
        $('#div_buscar').append($('#padresTable_filter'));

        @if(session('mensaje'))
            Swal.fire({
                title: "{{ session('mensaje') }}",
                icon: "{{ session('icono') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });

    function editPadre(url, nombre, apellido, dni, genero, fecha, celular, correo, direccion) {
        $('#formEditPadre').attr('action', url);
        $('#edit_nombre').val(nombre);
        $('#edit_apellido').val(apellido);
        $('#edit_dni').val(dni);
        $('#edit_genero').val(genero);
        $('#edit_fecha_nacimiento').val(fecha);
        $('#edit_celular').val(celular);
        $('#edit_correo').val(correo);
        $('#edit_direccion').val(direccion);
        $('#modalEditPadre').modal('show');
    }
</script>
@stop
