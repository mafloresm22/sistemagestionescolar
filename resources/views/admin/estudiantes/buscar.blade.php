@extends('adminlte::page')

@section('title', 'Buscador de Estudiantes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
            <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                <i class="fas fa-search mr-2 text-primary"></i>
                Buscador Avanzado de Estudiantes
            </h1>
            <p class="text-muted mb-0">Consulta y filtra la información detalla de todos los estudiantes.</p>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white border-0 py-3">
            <h3 class="card-title font-weight-bold text-dark">
                <i class="fas fa-list mr-2 text-secondary"></i>
                Listado de Registros
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableEstudiantesBuscar" class="table table-hover table-striped w-100">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Foto</th>
                            <th>Nombres y Apellidos</th>
                            <th>DNI</th>
                            <th>Genero</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Apoderado</th>
                            <th>Estado</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $e)
                        <tr>
                            <td class="align-middle text-center">
                                @if($e->fotoEstudiante)
                                    <img src="{{ asset($e->fotoEstudiante) }}" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; font-weight: bold; color: #4e73df;">
                                        {{ strtoupper(substr($e->nombreEstudiante, 0, 1) . substr($e->apellidoEstudiante, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle font-weight-bold">{{ $e->nombreEstudiante }} {{ $e->apellidoEstudiante }}</td>
                            <td class="align-middle">{{ $e->dniEstudiante }}</td>
                            <td class="align-middle">
                                <span class="badge badge-pill badge-light border">{{ $e->generoEstudiante }}</span>
                            </td>
                            <td class="align-middle">{{ $e->celularEstudiante ?: '---' }}</td>
                            <td class="align-middle small">{{ $e->correoEstudiante ?: 'Sin correo' }}</td>
                            <td class="align-middle">
                                @if($e->padreFamilia)
                                    <div class="small">
                                        <div class="font-weight-600">{{ $e->padreFamilia->nombrePadreFamilia }} {{ $e->padreFamilia->apellidoPadreFamilia }}</div>
                                        <span class="text-muted"><i class="fas fa-phone-alt mr-1"></i>{{ $e->padreFamilia->celularPadreFamilia }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Sin Apoderado</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-pill {{ $e->estadoEstudiante == 'Activo' ? 'badge-success' : 'badge-danger' }} px-3 py-2 shadow-sm">
                                    {{ strtoupper($e->estadoEstudiante) }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <button onclick="viewEstudiante({{ $e->idEstudiante }})" class="btn btn-sm btn-info btn-pill text-white shadow-sm hover-lift" title="Ver Detalles" style="font-size: 0.75rem; padding: 0.25rem 1rem;">
                                    <i class="fas fa-id-card mr-1"></i> Perfil
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Incluir el modal de mostrar detalles del estudiante --}}
@include('admin.estudiantes.show')

@stop

@section('css')
    {{-- Plugins CSS --}}
    @section('plugins.Datatables', true)
    <style>
        /* Corrección de la franja blanca al fondo */
        html, body {
            height: 100% !important;
            background-color: #f4f6f9 !important;
        }

        .content-wrapper {
            background-color: #f4f6f9 !important;
        }

        .hover-lift { transition: transform 0.2s; }
        .hover-lift:hover { transform: translateY(-3px); }
        
        .btn-pill { border-radius: 50px; padding: 0.4rem 1.2rem; }
        
        #tableEstudiantesBuscar thead th {
            border-bottom: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 50px !important;
            margin: 0 5px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 50px;
            padding: 8px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #4e73df;
            box-shadow: 0 0 8px rgba(78,115,223,0.1);
            outline: none;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#tableEstudiantesBuscar').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
            },
            dom: '<"row d-flex justify-content-between align-items-center mb-3"<"col-md-6"l><"col-md-6 text-right"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
            columnDefs: [
                { orderable: false, targets: [0, 8] }
            ]
        });
    });

    function viewEstudiante(id) {
        fetch(`{{ url('admin/estudiantes/show') }}/${id}`)
            .then(response => response.json())
            .then(data => {
                // Llenar datos del estudiante
                $('#show_nombre_completo').text(`${data.nombreEstudiante} ${data.apellidoEstudiante}`);
                $('#show_dni').text(data.dniEstudiante);
                $('#show_genero').text(data.generoEstudiante);
                $('#show_fecha_nacimiento').text(data.fechaNacimientoEstudiante);
                $('#show_celular').text(data.celularEstudiante || 'Sin celular');
                $('#show_correo').text(data.correoEstudiante || 'Sin correo');
                $('#show_direccion').text(data.direccionEstudiante || 'Sin dirección');
                
                // Foto del estudiante
                let photoUrl = data.fotoEstudiante ? `{{ asset('') }}${data.fotoEstudiante}` : `{{ asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}`;
                $('#show_foto').attr('src', photoUrl);

                // Llenar datos del apoderado (si existe)
                if (data.padre_familia) {
                    $('#show_apoderado_nombre').text(`${data.padre_familia.nombrePadreFamilia} ${data.padre_familia.apellidoPadreFamilia}`);
                    $('#show_apoderado_dni').text(data.padre_familia.dniPadreFamilia);
                    $('#show_apoderado_celular').text(data.padre_familia.celularPadreFamilia || '---');
                    $('#show_apoderado_correo').text(data.padre_familia.correoPadreFamilia || '---');
                } else {
                    $('#show_apoderado_nombre').text('Sin apoderado asignado');
                    $('#show_apoderado_dni').text('---');
                    $('#show_apoderado_celular').text('---');
                    $('#show_apoderado_correo').text('---');
                }

                // Activar pestaña inicial si el modal la usa
                if(typeof switchStudentTab === 'function') {
                    switchStudentTab('personal');
                }

                // Abrir el modal
                $('#modalShowEstudiante').modal('show');
            })
            .catch(error => {
                console.error("Error al cargar perfil:", error);
                Swal.fire('Error', 'No se pudo cargar la información.', 'error');
            });
    }
</script>
@stop
