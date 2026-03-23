@extends('adminlte::page')

@section('title', 'Gestión de Aulas')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2 align-items-center animate__animated animate__fadeIn">
        <div class="col-sm-6">
            <h1 class="font-weight-bold text-dark" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-door-open mr-2 text-primary"></i>Gestión de Aulas
            </h1>
            <p class="text-muted small mb-0">Administra los espacios físicos de la institución.</p>
        </div>
        <div class="col-sm-6 text-right">
            <button type="button" class="btn btn-primary-custom px-4 shadow-sm hover-lift" data-toggle="modal" data-target="#modalCreateAula">
                <i class="fas fa-plus-circle mr-2"></i>Nueva Aula
            </button>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    <div class="row animate__animated animate__fadeInUp">
        @forelse($aulas as $aula)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 aula-card text-center overflow-hidden" style="border-radius: 20px; transition: all 0.3s ease;">
                {{-- Status Ribbon --}}
                <div class="status-ribbon {{ $aula->estadoAula == 'Disponible' ? 'bg-success' : 'bg-danger' }}">
                    {{ strtoupper($aula->estadoAula) }}
                </div>
                
                <div class="card-body p-4 mt-2">
                    <div class="img-wrapper mb-3 mx-auto shadow-sm rounded-circle border p-1 bg-white" style="width: 100px; height: 100px; overflow: hidden; transition: all 0.4s ease;">
                        <img src="{{ asset('vendor/adminlte/dist/img/aulaImagen.webp') }}" alt="Aula" class="img-fluid rounded-circle h-100 w-100" style="object-fit: cover;">
                    </div>
                    
                    <h5 class="font-weight-bold text-dark mb-1">{{ $aula->nombreAula }}</h5>
                    <p class="text-muted small mb-3">Espacio Físico Académico</p>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <div class="capacity-bubble px-3 py-2 rounded-pill bg-light border shadow-xs d-flex align-items-center">
                            <i class="fas fa-users mr-2 text-primary"></i>
                            <span class="font-weight-bold text-primary" style="font-size: 1.1rem;">{{ $aula->capacidadAula }}</span>
                            <span class="text-muted small ml-1 mt-1">Capacidad</span>
                        </div>
                    </div>
                    
                    <div class="btn-group-wrapper d-flex justify-content-center pt-2 mt-auto">
                        <button type="button" class="btn btn-info-custom rounded-circle shadow-sm btn-edit-aula mr-3" 
                            data-id="{{ $aula->idAulas }}"
                            data-nombre="{{ $aula->nombreAula }}"
                            data-capacidad="{{ $aula->capacidadAula }}"
                            data-estado="{{ $aula->estadoAula }}"
                            title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <form action="{{ route('admin.aulas.destroy', $aula->idAulas) }}" method="POST" class="d-inline formulario-eliminar">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-custom rounded-circle shadow-sm" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center px-4 animate__animated animate__fadeIn">
            <div class="card border-0 shadow-sm p-5" style="border-radius: 25px;">
                <i class="fas fa-door-closed fa-4x text-muted mb-4" style="opacity: 0.3;"></i>
                <h4 class="text-muted font-weight-light">¡Ups! No hay aulas registradas todavía.</h4>
                <p class="text-muted mb-4">Parece que aún no has configurado tus salones de clase.</p>
                <div class="col-md-4 mx-auto">
                    <button class="btn btn-primary-custom btn-block rounded-pill" data-toggle="modal" data-target="#modalCreateAula">
                        <i class="fas fa-plus mr-2"></i>Registra tu primera Aula
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    {{-- Espaciador --}}
    <div class="mt-4 pb-4"></div>
</div>

@include('admin.aulas.create')
@include('admin.aulas.edit')
@stop

@section('css')
<style>
    :root {
        --primary-soft: #e7f1ff;
    }
    
    .aula-card {
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .aula-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    
    .aula-card:hover .img-wrapper {
        transform: scale(1.1);
        border-color: #007bff !important;
    }

    .status-ribbon {
        position: absolute;
        top: 0;
        right: 0;
        padding: 5px 20px;
        font-size: 0.65rem;
        font-weight: 800;
        color: white;
        border-bottom-left-radius: 15px;
        letter-spacing: 1px;
        box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .capacity-bubble {
        transition: all 0.3s ease;
    }
    
    .aula-card:hover .capacity-bubble {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    
    .aula-card:hover .capacity-bubble i,
    .aula-card:hover .capacity-bubble span {
        color: white !important;
    }

    .btn-info-custom, .btn-danger-custom {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-info-custom { background-color: #17a2b8; color: white; }
    .btn-info-custom:hover { background-color: #117a8b; transform: rotate(15deg); }
    
    .btn-danger-custom { background-color: #dc3545; color: white; }
    .btn-danger-custom:hover { background-color: #c82333; transform: rotate(-15deg); }

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

    .rounded-pill { border-radius: 50rem !important; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

    .animate__animated { animation-duration: 0.8s; }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Edit button click
        $(document).on('click', '.btn-edit-aula', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            let capacidad = $(this).data('capacidad');
            let estado = $(this).data('estado');

            $('#editNombre').val(nombre);
            $('#editCapacidad').val(capacidad);
            $('#editEstado').val(estado);
            $('#formEditAula').attr('action', "{{ url('admin/aulas/update') }}/" + id);
            $('#modalEditAula').modal('show');
        });

        // Notifications
        @if(session('mensaje') && session('icono'))
            Swal.fire({
                title: "¡Hecho!",
                text: "{{ session('mensaje') }}",
                icon: "{{ session('icono') }}",
                timer: 4000,
                timerProgressBar: true,
                confirmButtonColor: '#007bff'
            });
        @endif

        // SweetAlert Delete Confirmation
        $(document).on('submit', '.formulario-eliminar', function(e){
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
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
            })
        });
    });
</script>
@stop
