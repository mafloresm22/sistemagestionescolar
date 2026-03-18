@extends('adminlte::page')

@section('title', 'Listado de Estudiantes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
            <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                <i class="fas fa-user-graduate mr-2 text-primary"></i>
                Listado de Estudiantes
            </h1>
            <p class="text-muted mb-0">Gestión y control de los estudiantes matriculados en el sistema.</p>
        </div>
        <div class="d-flex align-items-center">
            <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreateEstudiante">
                <i class="fas fa-plus-circle mr-2"></i> Nuevo Estudiante
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 animate__animated animate__fadeInUp" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
            <div class="row align-items-center">
                <div class="col-12">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-table mr-2 text-secondary"></i>
                        Registros de Estudiantes
                    </h3>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="estudiantesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">Estudiante</th>
                            <th class="border-0">DNI</th>
                            <th class="border-0">Contacto</th>
                            <th class="border-0">Apoderado</th>
                            <th class="border-0 text-center">Estado</th>
                            <th class="border-0 text-center" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantes as $e)
                            <tr>
                                <td class="px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            @if($e->fotoEstudiante)
                                                <img src="{{ asset($e->fotoEstudiante) }}" alt="Avatar" class="rounded-circle shadow-sm" width="45" height="45" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary-soft d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; font-weight: bold; color: #4e73df;">
                                                    {{ strtoupper(substr($e->nombreEstudiante, 0, 1) . substr($e->apellidoEstudiante, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $e->nombreEstudiante }} {{ $e->apellidoEstudiante }}</div>
                                            <small class="text-muted">{{ $e->correoEstudiante ?: 'Sin correo' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-secondary font-weight-600">{{ $e->dniEstudiante }}</td>
                                <td class="align-middle">
                                    <div><i class="fas fa-phone-alt mr-1 text-muted small"></i> {{ $e->celularEstudiante ?: '---' }}</div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-user-shield text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-600 small">{{ $e->padreFamilia ? $e->padreFamilia->nombrePadreFamilia . ' ' . $e->padreFamilia->apellidoPadreFamilia : 'Sin Apoderado' }}</div>
                                            <small class="text-muted">{{ $e->padreFamilia ? $e->padreFamilia->celularPadreFamilia : '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-pill {{ $e->estadoEstudiante == 'Activo' ? 'badge-success' : 'badge-danger' }} px-3 py-2 shadow-sm" style="font-size: 0.75rem;">
                                        {{ strtoupper($e->estadoEstudiante) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center" style="gap: 7px;">
                                        @php $disabled = $e->estadoEstudiante == 'Inactivo' ? 'disabled' : ''; @endphp
                                        <button onclick="editEstudiante(
                                            '{{ route('admin.estudiantes.update', $e->idEstudiante) }}',
                                            '{{ $e->nombreEstudiante }}',
                                            '{{ $e->apellidoEstudiante }}',
                                            '{{ $e->dniEstudiante }}',
                                            '{{ $e->generoEstudiante }}',
                                            '{{ $e->fechaNacimientoEstudiante }}',
                                            '{{ $e->celularEstudiante }}',
                                            '{{ $e->correoEstudiante }}',
                                            '{{ $e->direccionEstudiante }}',
                                            '{{ $e->padreFamiliaID }}',
                                            '{{ $e->fotoEstudiante ? asset($e->fotoEstudiante) : asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}'
                                        )" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center" title="Editar" style="width: 40px; height: 40px;" data-toggle="modal" data-target="#modalEditEstudiante" {{ $disabled }}>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="viewEstudiante({{ $e->idEstudiante }})" class="btn btn-sm btn-info text-white rounded-circle d-flex align-items-center justify-content-center" title="Ver Detalles" style="width: 40px; height: 40px;" {{ $disabled }}>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($e->estadoEstudiante == 'Activo')
                                            <button onclick="toggleEstado({{ $e->idEstudiante }}, 'Inactivo')" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center" title="Inhabilitar" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        @else
                                            <button onclick="toggleEstado({{ $e->idEstudiante }}, 'Activo')" class="btn btn-sm btn-success rounded-circle d-flex align-items-center justify-content-center" title="Rehabilitar" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-user-slash fa-3x mb-3 opacity-2"></i>
                                        <p class="h5">No se encontraron estudiantes</p>
                                        <button class="btn btn-primary-custom mt-2" data-toggle="modal" data-target="#modalCreateEstudiante">
                                            <i class="fas fa-plus mr-1"></i> Registrar Primer Estudiante
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
    {{-- Paginación Custom --}}
    <div id="pagination-controls" class="d-flex justify-content-center align-items-center mt-4 pb-4 animate__animated animate__fadeInUp">
        {{-- Se genera por JS --}}
    </div>
</div>

@include('admin.estudiantes.create')
@include('admin.estudiantes.edit')
@include('admin.estudiantes.show')

@stop

@section('css')
<style>
    :root {
        --primary-blue: #4e73df;
        --primary-soft: #eef2ff;
        --secondary-blue: #224abe;
        --white: #ffffff;
        --bg-light: #f8f9fc;
    }

    .bg-primary-soft { background-color: var(--primary-soft); }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border: none;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
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

    .table td {
        border-top: 1px solid #e3e6f0;
        font-size: 0.9rem;
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

    .avatar-sm {
        position: relative;
        display: inline-block;
    }

    /* --- CUSTOM BUTTONS & PAGINATION --- */
    .pag-btn {
        width: 40px; height: 40px; border-radius: 50%; border: none; background: white;
        color: var(--primary-blue); margin: 0 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        font-weight: bold; transition: 0.3s;
    }
    .pag-btn.active { background: var(--primary-blue); color: white; transform: scale(1.1); }
    .pag-btn:hover:not(.active) { background: #f1f3f9; }
    .pag-btn:disabled { opacity: 0.5; cursor: not-allowed; }

    /* Animaciones */
    .animate__animated {
        animation-duration: 0.8s;
    }
</style>
@stop

@section('plugins.Select2', true)

@section('js')
<script>
    $(document).ready(function() {
        const table = document.getElementById('estudiantesTable');
        const rows = Array.from(table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'));
        const paginationContainer = document.getElementById('pagination-controls');
        
        let currentPage = 1;
        const itemsPerPage = 8;
        let filteredRows = rows.filter(row => !row.cells[0].classList.contains('text-center')); // Ignora la fila de 'No se encontraron registros'

        function renderPagination() {
            const pageCount = Math.ceil(filteredRows.length / itemsPerPage);
            paginationContainer.innerHTML = '';

            if (pageCount <= 1) return;

            // Botón Anterior
            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.className = 'pag-btn';
            prevBtn.type = 'button';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => { currentPage--; updateDisplay(); };
            paginationContainer.appendChild(prevBtn);

            // Números de página con "ventana" (1 2 3 ... 10)
            const range = 2; // Cuántas páginas mostrar a los lados de la actual
            let lastPageAdded = 0;

            for (let i = 1; i <= pageCount; i++) {
                // Siempre mostrar: primera, última, y las cercanas a la actual
                if (i === 1 || i === pageCount || (i >= currentPage - range && i <= currentPage + range)) {
                    
                    // Añadir elipsis si hay un salto
                    if (lastPageAdded > 0 && i - lastPageAdded > 1) {
                        const dots = document.createElement('span');
                        dots.innerText = '...';
                        dots.className = 'mx-2 text-muted font-weight-bold';
                        paginationContainer.appendChild(dots);
                    }

                    const btn = document.createElement('button');
                    btn.innerText = i;
                    btn.type = 'button';
                    btn.className = `pag-btn ${i === currentPage ? 'active' : ''}`;
                    btn.onclick = () => { 
                        currentPage = i; 
                        updateDisplay(); 
                        window.scrollTo({ top: 0, behavior: 'smooth' }); 
                    };
                    paginationContainer.appendChild(btn);
                    lastPageAdded = i;
                }
            }

            // Botón Siguiente
            const nextBtn = document.createElement('button');
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.className = 'pag-btn';
            nextBtn.type = 'button';
            nextBtn.disabled = currentPage === pageCount;
            nextBtn.onclick = () => { currentPage++; updateDisplay(); };
            paginationContainer.appendChild(nextBtn);
        }

        function updateDisplay() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Ocultar todas las filas
            rows.forEach(row => row.style.display = 'none');

            // Mostrar solo las de la página actual
            filteredRows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = '';
                }
            });

            renderPagination();
        }

        updateDisplay();


        // Inicializar Select2 con el modal como contenedor padre para evitar problemas de z-index
        $('#selectPadre').select2({
            theme: 'bootstrap4',
            placeholder: '-- Seleccione un apoderado --',
            allowClear: true,
            dropdownParent: $('#modalCreateEstudiante')
        });

        $('#edit_apoderado').select2({
            theme: 'bootstrap4',
            placeholder: '-- Seleccione un apoderado --',
            allowClear: true,
            dropdownParent: $('#modalEditEstudiante')
        });

        // Notificaciones SweetAlert si existen
        @if(session('mensaje'))
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('mensaje') }}",
                icon: "{{ session('icono') ?? 'success' }}",
                confirmButtonColor: '#4e73df'
            });
        @endif
    });

    function editEstudiante(url, nombre, apellido, dni, genero, fecha, celular, correo, direccion, apoderadoID, foto) {
        $('#formEditEstudiante').attr('action', url);
        $('#edit_nombre').val(nombre);
        $('#edit_apellido').val(apellido);
        $('#edit_dni').val(dni);
        $('#edit_genero').val(genero);
        $('#edit_fecha_nacimiento').val(fecha);
        $('#edit_celular').val(celular);
        $('#edit_correo').val(correo);
        $('#edit_direccion').val(direccion);
        $('#edit_apoderado').val(apoderadoID).trigger('change');
        
        // Cargar foto
        $('#editImagePreview').css({
            'background-image': 'url(' + foto + ')',
            'background-size': 'cover',
            'background-position': 'center'
        });
        $('#edit_foto').val(''); // Limpiar input file
        
        $('#modalEditEstudiante').modal('show');
    }

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

                // Llenar datos del apoderado
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

                // Activar pestaña de Información Personal por defecto al abrir
                if (typeof switchStudentTab === 'function') {
                    switchStudentTab('personal');
                }

                // Mostrar modal
                $('#modalShowEstudiante').modal('show');
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: '¡Error!',
                    text: 'No se pudo obtener la información del estudiante.',
                    icon: 'error',
                    confirmButtonColor: '#4e73df'
                });
            });
    }

    function toggleEstado(id, nuevoEstado) {
        let isActivating = (nuevoEstado === 'Activo');
        let title = isActivating ? '¿Reactivar estudiante?' : '¿Inhabilitar estudiante?';
        let text = isActivating ? 'El estudiante volverá a estar Activo en el sistema.' : 'Esta acción deshabilitará la edición y vista de detalles.';
        let confirmBtnColor = isActivating ? '#28a745' : '#e74a3b';
        let confirmBtnText = isActivating ? 'Sí, reactivar' : 'Sí, inhabilitar';

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmBtnColor,
            cancelButtonColor: '#858796',
            confirmButtonText: confirmBtnText,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = `{{ url('admin/estudiantes/delete') }}/${id}`;
                form.method = 'POST';
                
                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                let method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                let statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'nuevoEstado';
                statusInput.value = nuevoEstado;

                form.appendChild(csrf);
                form.appendChild(method);
                form.appendChild(statusInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@stack('js')
@stop
