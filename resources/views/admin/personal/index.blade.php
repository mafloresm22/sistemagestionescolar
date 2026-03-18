@extends('adminlte::page')

@section('title', 'Personal ' . ucfirst($tipoPersonal))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
            <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                <i class="fas {{ $tipoPersonal == 'docente' ? 'fa-users' : 'fa-shield-alt' }} mr-2 text-primary"></i>
                Listado de {{ ucfirst($tipoPersonal) }}s
            </h1>
            <p class="text-muted mb-0">Gestión y control de personal administrativo del sistema.</p>
        </div>
        <div class="d-flex align-items-center">
            {{-- Buscador dinámico --}}
            <div class="input-group mr-3 shadow-sm" style="width: 250px;">
                <input type="text" id="customSearch" class="form-control border-0" placeholder="Buscar personal..." style="border-radius: 10px 0 0 10px;">
                <div class="input-group-append">
                    <span class="input-group-text bg-white border-0" style="border-radius: 0 10px 10px 0;">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                </div>
            </div>
            <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreatePersonal">
                <i class="fas fa-plus-circle mr-2"></i> Nuevo {{ ucfirst($tipoPersonal) }}
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row pt-3" id="personal-container">
        @forelse($personal as $p)
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4 personal-item" data-name="{{ strtolower($p->nombrePersonal . ' ' . $p->apellidoPersonal) }}" data-dni="{{ $p->dniPersonal }}">
                <div class="personal-card animate__animated animate__zoomIn">
                    {{-- Header del Carnet --}}
                    <div class="card-header-carnet {{ strtolower($p->tipoPersonal) == 'docente' ? 'bg-gradient-blue' : 'bg-premium-orange' }}">
                        <div class="status-badge {{ $p->estadoPersonal == 'Activo' ? 'bg-success' : 'bg-danger' }}">
                            {{ strtoupper($p->estadoPersonal) }}
                        </div>
                        <div class="avatar-container shadow">
                            @if($p->fotoPersonal)
                                <img src="{{ asset($p->fotoPersonal) }}" alt="Foto" class="avatar-img shadow-sm" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                            @else
                                @php
                                    $initials = strtoupper(substr($p->nombrePersonal, 0, 1) . substr($p->apellidoPersonal, 0, 1));
                                    $colorSeed = ord($p->nombrePersonal[0]) + ord($p->apellidoPersonal[0]);
                                    $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1', '#fd7e14'];
                                    $bgColor = $colors[$colorSeed % count($colors)];
                                @endphp
                                <div class="avatar-pseudo shadow-sm" style="background: {{ $bgColor }};">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Cuerpo del Carnet --}}
                    <div class="card-body-carnet">
                        <h5 class="person-name">{{ $p->nombrePersonal }} {{ $p->apellidoPersonal }}</h5>
                        <p class="person-title"><i class="fas fa-briefcase mr-1"></i> {{ $p->profesionPersonal ?: 'SIN PROFESIÓN' }}</p>
                        
                        <div class="info-grid text-left">
                            <div class="info-item">
                                <span class="label">DNI</span>
                                <span class="value">{{ $p->dniPersonal }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">CELULAR</span>
                                <span class="value font-weight-bold">{{ $p->celularPersonal ?: '---' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer-carnet">
                        @php $isDisabled = strtolower($p->estadoPersonal) == 'inactivo' ? 'disabled' : ''; @endphp
                        <button class="btn-action edit" onclick="editPersonal({{ $p->idPersonal }})" title="Editar" {{ $isDisabled }}><i class="fas fa-edit"></i></button>
                        <button class="btn-action formacionAcademica" onclick="formacionAcademica({{ $p->idPersonal }})" title="Formación Academica" {{ $isDisabled }}><i class="fas fa-user-graduate"></i></button>
                        <button class="btn-action view" onclick="viewDetails({{ $p->idPersonal }})" title="Ver Detalles" {{ $isDisabled }}><i class="fas fa-id-card"></i></button>

                        
                        @if(strtolower($p->estadoPersonal) == 'inactivo')
                            <button class="btn-action restore" onclick="toggleStatus({{ $p->idPersonal }}, 'Activo')" title="Reactivar"><i class="fas fa-user-check" style="color: #28a745;"></i></button>
                        @else
                            <button class="btn-action delete" onclick="toggleStatus({{ $p->idPersonal }}, 'Inactivo')" title="Inhabilitar"><i class="fas fa-user-times"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 animate__animated animate__fadeIn">
                <div class="empty-state-wrapper text-center">
                    <div class="empty-state-icon">
                        <i class="fas fa-user-friends"></i>
                        <div class="icon-pulse"></div>
                    </div>
                    <h3 class="empty-state-title">Aún no hay {{ $tipoPersonal }}s</h3>
                    <p class="empty-state-text">
                        Parece que no tenemos registros en esta categoría. <br>
                        Comienza agregando uno nuevo para gestionar tu sistema.
                    </p>
                    <button class="btn btn-primary-custom px-5 py-2 mt-3 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreatePersonal">
                        <i class="fas fa-plus-circle mr-2"></i> Crear Primer Registro
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginación Custom --}}
    <div id="pagination-controls" class="d-flex justify-content-center align-items-center mt-4 pb-4 animate__animated animate__fadeInUp">
        {{-- Se genera por JS --}}
    </div>
</div>

@include('admin.personal.create')
@include('admin.personal.edit')
@include('admin.personal.show')

<style>
/* --- DESIGN SYSTEM --- */
:root {
    --primary-blue: #4e73df;
    --secondary-blue: #224abe;
    --white: #ffffff;
    --shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Corrige el espacio en blanco al final de la página */
.content-wrapper {
    background-color: #f4f6f9 !important;
}

.personal-card {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}
.personal-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.15); }

.card-header-carnet { height: 95px; position: relative; display: flex; justify-content: center; }
.bg-gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
.bg-premium-orange { background: linear-gradient(135deg, #fd7e14 0%, #fb8c00 100%); }

.status-badge { position: absolute; top: 10px; right: 10px; padding: 3px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 900; color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
.avatar-container { position: absolute; bottom: -35px; width: 80px; height: 80px; border-radius: 50%; background: white; padding: 4px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
.avatar-pseudo { width: 100%; height: 100%; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem; }

.card-body-carnet { padding: 45px 20px 20px 20px; text-align: center; }
.person-name { font-weight: 800; color: #2e3b4e; font-size: 1.1rem; }
.person-title { color: #858796; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 15px; }

.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #f8f9fc; padding: 10px; border-radius: 12px; }
.info-item .label { font-size: 0.6rem; font-weight: 700; color: #b7b9cc; text-transform: uppercase; }
.info-item .value { font-size: 0.85rem; color: #4e73df; }

.divider { height: 1px; background: linear-gradient(to right, transparent, #eaecf4, transparent); margin: 15px 0; }
.dni-bar { font-family: 'Courier New', Courier, monospace; font-size: 0.75rem; color: #5a5c69; }

.card-footer-carnet { display: flex; justify-content: space-around; padding: 12px; background: #fafbfc; border-top: 1px solid #f1f3f9; }
.btn-action { width: 35px; height: 35px; border-radius: 12px; border: none; transition: 0.2s; }
.btn-action.edit { background: #eef2ff; color: #4e73df; }
.btn-action.view { background: #e6fffa; color: #c8ba1c; }
.btn-action.formacionAcademica { background: #f5f3ff; color: #8b5cf6; }
.btn-action.delete { background: #fff5f5; color: #e74a3b; }
.btn-action:hover { transform: scale(1.15); filter: contrast(1.1); }
.btn-action:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    filter: grayscale(0.8) !important;
}


/* --- ICON INPUT STYLES --- */
.input-group-premium { position: relative; display: flex; align-items: center; }
.input-group-premium .icon { position: absolute; left: 15px; color: #b7b9cc; z-index: 10; font-size: 0.9rem; }
.input-group-premium .form-control { padding-left: 45px; height: 48px; border-radius: 12px; border: 2px solid #eaecf4; font-weight: 600; color: #5a5c69; transition: all 0.3s; }
.input-group-premium .form-control:focus { border-color: #4e73df; box-shadow: 0 0 10px rgba(78, 115, 223, 0.1); }
.form-premium label { font-weight: 700; font-size: 0.8rem; color: #4e5e7a; margin-bottom: 5px; margin-left: 5px; }

/* --- CUSTOM BUTTONS & PAGINATION --- */
.btn-primary-custom { background: var(--primary-blue); border: none; color: white; border-radius: 10px; font-weight: 600; }

.pag-btn {
    width: 40px; height: 40px; border-radius: 50%; border: none; background: white;
    color: var(--primary-blue); margin: 0 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    font-weight: bold; transition: 0.3s;
}
.pag-btn.active { background: var(--primary-blue); color: white; transform: scale(1.1); }
.pag-btn:hover:not(.active) { background: #f1f3f9; }
.pag-btn:disabled { opacity: 0.5; cursor: not-allowed; }

.hover-lift { transition: transform 0.2s ease; }
.hover-lift:hover { transform: translateY(-3px); }

/* --- EMPTY STATE PREMIUM --- */
.empty-state-wrapper {
    background: white;
    padding: 60px 40px;
    border-radius: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.05);
    margin-top: 30px;
}

.empty-state-icon {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto 25px;
    background: linear-gradient(135deg, #e0e7ff 0%, #f1f3f9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
    font-size: 3rem;
}

.icon-pulse {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    border-radius: 50%;
    border: 4px solid var(--primary-blue);
    animation: icon-pulse-anim 2s infinite ease-out;
    opacity: 0;
}

@keyframes icon-pulse-anim {
    0% { transform: scale(0.8); opacity: 0.5; }
    100% { transform: scale(1.4); opacity: 0; }
}

.empty-state-title {
    font-weight: 800;
    color: #2e3b4e;
    margin-bottom: 10px;
}

.empty-state-text {
    color: #858796;
    font-size: 1.1rem;
    margin-bottom: 25px;
}
</style>

@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('personal-container');
        const items = Array.from(document.getElementsByClassName('personal-item'));
        const paginationContainer = document.getElementById('pagination-controls');
        const searchInput = document.getElementById('customSearch');
        
        let currentPage = 1;
        const itemsPerPage = 8;
        let filteredItems = [...items];

        function renderPagination() {
            const pageCount = Math.ceil(filteredItems.length / itemsPerPage);
            paginationContainer.innerHTML = '';

            if (pageCount <= 1) return;

            // Botón Anterior
            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.className = 'pag-btn';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => { currentPage--; updateDisplay(); };
            paginationContainer.appendChild(prevBtn);

            // Números de página con "ventana" (1 2 3 ... 10)
            const range = 2; // Cuántas páginas a los lados de la actual
            let lastPageAdded = 0;

            for (let i = 1; i <= pageCount; i++) {
                if (i === 1 || i === pageCount || (i >= currentPage - range && i <= currentPage + range)) {
                    
                    if (lastPageAdded > 0 && i - lastPageAdded > 1) {
                        const dots = document.createElement('span');
                        dots.innerText = '...';
                        dots.className = 'mx-2 text-muted font-weight-bold';
                        paginationContainer.appendChild(dots);
                    }

                    const btn = document.createElement('button');
                    btn.innerText = i;
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
            nextBtn.disabled = currentPage === pageCount;
            nextBtn.onclick = () => { currentPage++; updateDisplay(); };
            paginationContainer.appendChild(nextBtn);
        }

        function updateDisplay() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Ocultar todos los ítems originales
            items.forEach(item => item.style.display = 'none');

            // Mostrar solo los filtrados de la página actual
            filteredItems.forEach((item, index) => {
                if (index >= start && index < end) {
                    item.style.display = 'block';
                }
            });

            renderPagination();
        }

        // Buscador en tiempo real
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            filteredItems = items.filter(item => {
                const name = item.getAttribute('data-name');
                const dni = item.getAttribute('data-dni');
                return name.includes(term) || dni.includes(term);
            });
            currentPage = 1;
            updateDisplay();
        });

        // Inicialización
        updateDisplay();
    });

    function toggleStatus(id, nuevoEstado) {
        let isActivating = (nuevoEstado === 'Activo');
        let tituloStr = isActivating ? '¿Estás seguro de reactivar a este personal?' : '¿Estás seguro de inhabilitar a este personal?';
        let textoStr = isActivating ? "Esta acción devolverá su estado a Activo y restaurará su acceso al sistema." : "Esta acción cambiará su estado a inactivo y suspenderá sus sesiones.";
        let btnIcon = isActivating ? '<i class="fas fa-user-check"></i> Sí, reactivar' : '<i class="fas fa-user-times"></i> Sí, inhabilitar';
        let btnColor = isActivating ? '#28a745' : '#ff4b5c';
        let btnClass = isActivating ? 'btn-success' : 'btn-danger';

        Swal.fire({
            title: tituloStr,
            text: textoStr,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: btnColor,
            cancelButtonColor: '#007bff',
            confirmButtonText: btnIcon,
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: `btn ${btnClass} px-4 mx-2`,
                cancelButton: 'btn btn-primary px-4 mx-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear form virtual
                let form = document.createElement('form');
                form.action = `{{ url('admin/personal/delete') }}/${id}`;
                form.method = 'POST';
                
                let csrfToken = document.createElement('input');
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                csrfToken.type = 'hidden';

                let methodProp = document.createElement('input');
                methodProp.name = '_method';
                methodProp.value = 'DELETE'; // Aunque sea "Destroy/Delete", enviaremos la var estado también
                methodProp.type = 'hidden';

                let statusProp = document.createElement('input');
                statusProp.name = 'nuevoEstado';
                statusProp.value = nuevoEstado;
                statusProp.type = 'hidden';

                form.appendChild(csrfToken);
                form.appendChild(methodProp);
                form.appendChild(statusProp);
                document.body.appendChild(form);
                
                form.submit();
            }
        });
    }

    function editPersonal(id) {
        // Cargar datos en el modal de edición
        fetch(`{{ url('admin/personal/show') }}/${id}`)
            .then(response => response.json())
            .then(data => {
                // Actualizar la acción del formulario
                document.getElementById('formEditPersonal').action = `{{ url('admin/personal/update') }}/${id}`;
                
                // Llenar datos
                document.getElementById('edit_nombrePersonal').value = data.nombrePersonal;
                document.getElementById('edit_apellidoPersonal').value = data.apellidoPersonal;
                document.getElementById('edit_dniPersonal').value = data.dniPersonal;
                document.getElementById('edit_profesionPersonal').value = data.profesionPersonal || '';
                document.getElementById('edit_emailPersonal').value = data.emailPersonal;
                document.getElementById('edit_generoPersonal').value = data.generoPersonal;
                document.getElementById('edit_fechaNacimientoPersonal').value = data.fechaNacimientoPersonal;
                document.getElementById('edit_celularPersonal').value = data.celularPersonal || '';
                
                // Setear Rol automáticamente en el <select>
                if (data.role_name) {
                    let selectRole = document.getElementById('edit_role');
                    for (let i = 0; i < selectRole.options.length; i++) {
                        if (selectRole.options[i].value.toLowerCase() === data.role_name.toLowerCase()) {
                            selectRole.selectedIndex = i;
                            break;
                        }
                    }
                }
                
                // Preview de foto
                let photoUrl = data.fotoPersonal ? `{{ asset('') }}${data.fotoPersonal}` : `{{ asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}`;
                document.getElementById('imagePreviewEdit').style.backgroundImage = `url('${photoUrl}')`;

                // Mostrar modal
                $('#modalEditPersonal').modal('show');
            })
            .catch(error => {
                console.error("Error al cargar los datos para editar:", error);
                Swal.fire('Error', 'No se pudieron cargar los datos.', 'error');
            });
    }

    function formacionAcademica(id) {
        window.location.href = `{{ url('admin/formacionAcademica') }}/${id}`;
    }

    function viewDetails(id) {
        // Mostrar cargador o deshabilitar botón si fuera necesario
        fetch(`{{ url('admin/personal/show') }}/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('show-dni-top').innerText = data.dniPersonal || '---';
                document.getElementById('show-nombres-apellidos').innerText = `${data.nombrePersonal || ''} ${data.apellidoPersonal || ''}`;
                document.getElementById('show-fecha-nac').innerText = data.fechaNacimientoPersonal || '---';
                document.getElementById('show-genero').innerText = data.generoPersonal || '---';
                
                // Nuevos campos
                document.getElementById('show-profesion').innerText = data.profesionPersonal || 'SIN PROFESIÓN';
                document.getElementById('show-celular').innerText = data.celularPersonal || '---';
                document.getElementById('show-email').innerText = data.emailPersonal || '---';
                document.getElementById('show-tipo').innerText = data.tipoPersonal || '---';
                
                // Foto
                const fotoImg = document.getElementById('show-foto');
                if (data.fotoPersonal) {
                    fotoImg.src = `{{ asset('') }}${data.fotoPersonal}`;
                } else {
                    const avatarNombre = data.nombrePersonal ? data.nombrePersonal : 'A';
                    const avatarApellido = data.apellidoPersonal ? data.apellidoPersonal : 'B';
                    fotoImg.src = `https://ui-avatars.com/api/?name=${avatarNombre}+${avatarApellido}&background=random&size=200`;
                }

                // Abrir modal
                $('#modalShowPersonal').modal('show');
            })
            .catch(error => {
                console.error("Error al cargar los datos del personal:", error);
                Swal.fire('Error', 'No se pudo cargar la información del personal', 'error');
            });
    }

    @if(session('mensaje'))
        Swal.fire({
            title: "{{ session('mensaje') }}",
            icon: "{{ session('icono') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if($errors->any())
        $('#modalCreatePersonal').modal('show');
    @endif
</script>
@stop
