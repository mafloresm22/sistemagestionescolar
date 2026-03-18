@extends('adminlte::page')

@section('title', 'Formación Académica - ' . $personal->nombrePersonal . ' ' . $personal->apellidoPersonal)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
            <h1 class="text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                <i class="fas fa-user-graduate mr-2 text-primary"></i>
                Formación Académica
            </h1>
            <p class="text-muted mb-0">Gestión del historial académico de: <span class="text-primary font-weight-bold">{{ $personal->nombrePersonal }} {{ $personal->apellidoPersonal }}</span></p>
        </div>
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.personal.index', strtolower($personal->tipoPersonal)) }}" class="btn btn-secondary px-4 shadow-sm hover-lift mr-3" style="border-radius: 10px; font-weight: 600;">
                <i class="fas fa-arrow-left mr-2"></i> Volver a {{ ucfirst($personal->tipoPersonal) }}s
            </a>
            <button class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreateFormacion" {{ strtolower($personal->estadoPersonal) == 'inactivo' ? 'disabled' : '' }}>
                <i class="fas fa-plus-circle mr-2"></i> Nueva Formación
            </button>

        </div>
    </div>
@stop

@section('content')
<div class="container-fluid pb-5">
    <div class="row pt-3">
        {{-- PANEL IZQUIERDO: PERFIL DEL PERSONAL --}}
        <div class="col-md-4">
            <div class="card premium-card animate__animated animate__fadeInLeft">
                <div class="profile-header {{ strtolower($personal->tipoPersonal) == 'docente' ? 'bg-gradient-blue' : 'bg-premium-orange' }}">
                </div>
                <div class="card-body text-center pt-0">
                    <div class="avatar-container-large mx-auto shadow mb-3" style="margin-top: -50px;">
                        @if($personal->fotoPersonal)
                            <img src="{{ asset($personal->fotoPersonal) }}" alt="Foto" class="avatar-img-large">
                        @else
                            @php
                                $initials = strtoupper(substr($personal->nombrePersonal, 0, 1) . substr($personal->apellidoPersonal, 0, 1));
                                $colorSeed = ord($personal->nombrePersonal[0]) + ord($personal->apellidoPersonal[0]);
                                $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1', '#fd7e14'];
                                $bgColor = $colors[$colorSeed % count($colors)];
                            @endphp
                            <div class="avatar-pseudo-large" style="background: {{ $bgColor }};">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="font-weight-bold text-dark mb-1">{{ $personal->nombrePersonal }} {{ $personal->apellidoPersonal }}</h4>
                    <p class="text-muted text-uppercase mb-3" style="font-size: 0.85rem;"><i class="fas fa-briefcase mr-1"></i> {{ $personal->profesionPersonal ?: 'SIN PROFESIÓN' }}</p>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <span class="badge {{ $personal->estadoPersonal == 'Activo' ? 'badge-success' : 'badge-danger' }} px-3 py-2 mr-2" style="border-radius: 8px;">
                            {{ strtoupper($personal->estadoPersonal) }}
                        </span>
                        <span class="badge badge-light border px-3 py-2 text-dark" style="border-radius: 8px;">
                            DNI: {{ $personal->dniPersonal }}
                        </span>
                    </div>

                    <div class="info-grid-profile text-left px-2">
                        <div class="info-item-profile mb-3">
                            <span class="label d-block text-muted font-weight-bold" style="font-size: 0.75rem;">CORREO ELECTRÓNICO</span>
                            <span class="value text-dark d-flex align-items-center mt-1">
                                <div class="icon-circle mr-2"><i class="fas fa-envelope"></i></div>
                                {{ $personal->emailPersonal ?: '---' }}
                            </span>
                        </div>
                        <div class="info-item-profile mb-3">
                            <span class="label d-block text-muted font-weight-bold" style="font-size: 0.75rem;">CELULAR</span>
                            <span class="value text-dark d-flex align-items-center mt-1">
                                <div class="icon-circle mr-2"><i class="fas fa-phone"></i></div>
                                {{ $personal->celularPersonal ?: '---' }}
                            </span>
                        </div>
                        <div class="info-item-profile">
                            <span class="label d-block text-muted font-weight-bold" style="font-size: 0.75rem;">TIPO DE PERSONAL</span>
                            <span class="value text-dark d-flex align-items-center mt-1">
                                <div class="icon-circle mr-2"><i class="fas fa-id-badge"></i></div>
                                {{ ucfirst($personal->tipoPersonal) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL DERECHO: TIMELINE DE FORMACIÓN --}}
        <div class="col-md-8">
            <div class="card premium-card animate__animated animate__fadeInRight">
                <div class="card-header bg-white border-0 pt-4 pb-2">
                    <h5 class="font-weight-bold text-primary mb-0"><i class="fas fa-history mr-3"></i> Historial Académico</h5>
                </div>
                <div class="card-body">
                    @if($formacionAcademica->count() > 0)
                        <div class="timeline mt-2 px-3">
                            @foreach($formacionAcademica->sortByDesc('anioFormacionAcademica') as $FA)
                                {{-- Etiqueta del Año --}}
                                <div class="time-label">
                                    <span class="bg-primary text-white px-3 shadow-sm" style="border-radius: 20px; font-weight: 600;">
                                        {{ $FA->anioFormacionAcademica }}
                                    </span>
                                </div>
                                
                                {{-- Item de la Línea de Tiempo --}}
                                <div>
                                    @php
                                        $iconBadge = 'fa-graduation-cap bg-blue';
                                        $iconColor = '#4e73df';
                                        $nivel = strtolower($FA->nivelFormacionAcademica);
                                        if(str_contains($nivel, 'doctorado')) {
                                            $iconBadge = 'fa-award bg-purple';
                                            $iconColor = '#6f42c1';
                                        } elseif(str_contains($nivel, 'maestría') || str_contains($nivel, 'postgrado') || str_contains($nivel, 'magister') || str_contains($nivel, 'maestria')) {
                                            $iconBadge = 'fa-medal bg-warning';
                                            $iconColor = '#f6c23e';
                                        } elseif(str_contains($nivel, 'bachiller') || str_contains($nivel, 'licenciatura') || str_contains($nivel, 'título') || str_contains($nivel, 'titulo')) {
                                            $iconBadge = 'fa-certificate bg-info';
                                            $iconColor = '#36b9cc';
                                        } elseif(str_contains($nivel, 'técnico') || str_contains($nivel, 'tecnico')) {
                                            $iconBadge = 'fa-wrench bg-teal';
                                            $iconColor = '#20c997';
                                        }
                                    @endphp
                                    
                                    <i class="fas {{ $iconBadge }} text-white shadow-sm" style="width: 40px; height: 40px; line-height: 40px; font-size: 16px;"></i>
                                    <div class="timeline-item shadow-sm border-0" style="border-radius: 15px; overflow: hidden; background: #fff; border: 1px solid #f1f3f9 !important;">
                                        <div class="timeline-header font-weight-bold border-0 text-dark pb-2 pt-3" style="font-size: 1.15rem;">
                                            {{ $FA->tituloFormacionAcademica }}
                                        </div>
                                        <div class="timeline-body pt-0 text-muted">
                                            <div class="d-flex align-items-center mb-2 text-dark" style="font-weight: 500;">
                                                <i class="fas fa-university mr-2" style="color: {{ $iconColor }}"></i> {{ $FA->institucionFormacionAcademica }}
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-light border text-uppercase" style="font-size: 0.8rem; padding: 6px 12px; color: #5a5c69;">{{ $FA->nivelFormacionAcademica }}</span>
                                            </div>
                                        </div>
                                        <div class="timeline-footer mt-2 pt-3 px-3 pb-3 d-flex justify-content-between align-items-center bg-light border-top">
                                            <div>
                                                @if($FA->archivoFormacionAcademica)
                                                    <a href="{{ asset($FA->archivoFormacionAcademica) }}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm" style="border-radius: 8px; font-weight: 600;">
                                                        <i class="fas fa-file-pdf mr-1 text-danger"></i> Ver Documento
                                                    </a>
                                                @else
                                                    <span class="text-muted small align-items-center d-flex"><i class="fas fa-times-circle mr-1 text-secondary"></i> Sin documento adjunto</span>
                                                @endif
                                            </div>
                                            <div class="d-flex">
                                                @php $isDisabled = strtolower($personal->estadoPersonal) == 'inactivo' ? 'disabled' : ''; @endphp
                                                <button class="btn btn-sm btn-action edit mx-1 shadow-sm" onclick="editFormacion({{ $FA->idFormacionAcademica }})" title="Editar" {{ $isDisabled }}><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-action delete mx-1 shadow-sm" onclick="deleteFormacion({{ $FA->idFormacionAcademica }})" title="Eliminar" {{ $isDisabled }}><i class="fas fa-trash-alt"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                <i class="fas fa-clock bg-gray shadow-sm text-white" style="width: 40px; height: 40px; line-height: 40px; font-size: 16px;"></i>
                            </div>
                        </div>
                    @else
                        <div class="empty-state-wrapper text-center my-4 py-5 animate__animated animate__fadeIn">
                            <div class="empty-state-icon mx-auto mb-4" style="width: 100px; height: 100px; font-size: 3rem;">
                                <i class="fas fa-book-reader"></i>
                                <div class="icon-pulse"></div>
                            </div>
                            <h3 class="font-weight-bold text-dark mb-2">Aún no hay registros de formación</h3>
                            <p class="text-muted mb-4" style="font-size: 1.1rem;">
                                Agrega los estudios, diplomados, y grados obtenidos por este {{ strtolower($personal->tipoPersonal) }}.
                            </p>
                            <button class="btn btn-primary-custom px-5 py-3 shadow hover-lift" data-toggle="modal" data-target="#modalCreateFormacion" style="font-size: 1.1rem;">
                                <i class="fas fa-plus-circle mr-2"></i> Agregar Primera Formación
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.formacion_academica.create')
@include('admin.formacion_academica.edit')


<style>
/* --- DESIGN SYSTEM --- */
:root {
    --primary-blue: #4e73df;
    --secondary-blue: #224abe;
    --white: #ffffff;
    --shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.premium-card {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}

.profile-header {
    height: 120px;
    width: 100%;
}

.bg-gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
.bg-premium-orange { background: linear-gradient(135deg, #fd7e14 0%, #fb8c00 100%); }
.bg-blue { background-color: #4e73df !important; }
.bg-purple { background-color: #6f42c1 !important; }
.bg-teal { background-color: #20c997 !important; }

.avatar-container-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: white;
    padding: 6px;
    position: relative;
    z-index: 10;
}

.avatar-img-large, .avatar-pseudo-large {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-pseudo-large {
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 2.5rem;
}

.icon-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #f8f9fc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
    flex-shrink: 0;
}

.btn-primary-custom { background: var(--primary-blue); border: none; color: white; border-radius: 10px; font-weight: 600; }
.btn-primary-custom:hover { background: var(--secondary-blue); color: white; }
.hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.hover-lift:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important; }

.btn-action { width: 38px; height: 38px; border-radius: 12px; border: none; transition: 0.2s; display: flex; align-items: center; justify-content: center; }
.btn-action.edit { background: #eef2ff; color: #4e73df; }
.btn-action.delete { background: #fff5f5; color: #e74a3b; }
.btn-action:hover { transform: scale(1.15); filter: contrast(1.1); }
.btn-action:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    filter: grayscale(0.8) !important;
}
.btn-primary-custom:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: #aab5d8 !important;
}


/* Timeline Customization */
.timeline {
    margin: 0 0 30px 0;
    padding: 0;
    position: relative;
}
.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #e9ecef;
    left: 20px;
    margin: 0;
    border-radius: 2px;
}
.timeline>div {
    margin-bottom: 25px;
    position: relative;
    margin-right: 10px;
}
.timeline>div::after {
    content: "";
    display: table;
    clear: both;
}
.timeline>div>.time-label>span {
    font-weight: 600;
    padding: 8px 15px;
    display: inline-block;
}
.timeline>div>.fas {
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 50%;
    text-align: center;
}
.timeline>div>.timeline-item {
    margin-left: 60px;
    margin-right: 0;
    background: #fff;
    color: #444;
}

/* Empty State */
.empty-state-wrapper {
    background: #fff;
    border-radius: 30px;
    border: 2px dashed #eaecf4;
}
.empty-state-icon {
    position: relative;
    background: linear-gradient(135deg, #e0e7ff 0%, #f1f3f9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
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
</style>
@stop

@section('js')
<script>
    function editFormacion(id) {
        fetch(`{{ url('admin/formacionAcademica/show') }}/${id}`)
            .then(response => response.json())
            .then(data => {
                // Actualizar la acción del formulario
                document.getElementById('formEditFormacion').action = `{{ url('admin/formacionAcademica/update') }}/${id}`;
                
                // Llenar datos
                document.getElementById('edit_nivelFormacionAcademica').value = data.nivelFormacionAcademica;
                document.getElementById('edit_anioFormacionAcademica').value = data.anioFormacionAcademica;
                document.getElementById('edit_tituloFormacionAcademica').value = data.tituloFormacionAcademica;
                document.getElementById('edit_institucionFormacionAcademica').value = data.institucionFormacionAcademica;
                
                // Resetear label de archivo
                document.getElementById('label_edit_archivo').innerText = 'Seleccionar archivo en PDF o Imagen...';
                document.getElementById('label_edit_archivo').style.color = '';
                document.getElementById('label_edit_archivo').style.fontWeight = '';

                // Mostrar badge si hay archivo actual
                if(data.archivoFormacionAcademica) {
                    document.getElementById('current_file_container').style.display = 'block';
                } else {
                    document.getElementById('current_file_container').style.display = 'none';
                }

                // Mostrar modal
                $('#modalEditFormacion').modal('show');
            })
            .catch(error => {
                console.error("Error al cargar los datos para editar:", error);
                Swal.fire('Error', 'No se pudieron cargar los datos de la formación.', 'error');
            });
    }

    function deleteFormacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará permanentemente este registro de formación académica.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4b5c',
            cancelButtonColor: '#007bff',
            confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger px-4 mx-2',
                cancelButton: 'btn btn-primary px-4 mx-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear form virtual para eliminar
                let form = document.createElement('form');
                form.action = `{{ url('admin/formacionAcademica/delete') }}/${id}`;
                form.method = 'POST';
                
                let csrfToken = document.createElement('input');
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                csrfToken.type = 'hidden';

                let methodProp = document.createElement('input');
                methodProp.name = '_method';
                methodProp.value = 'DELETE';
                methodProp.type = 'hidden';

                form.appendChild(csrfToken);
                form.appendChild(methodProp);
                document.body.appendChild(form);
                
                form.submit();
            }
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
        $('#modalCreateFormacion').modal('show');
    @endif
</script>
@stop
