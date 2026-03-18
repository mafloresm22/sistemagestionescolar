@extends('adminlte::page')

@section('title', 'Gestion de Roles')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    <i class="fas fa-user-tag mr-2 text-primary"></i>Gestión de Roles
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalCrearRol" style="border-radius: 20px;">
                    <i class="fas fa-plus-circle mr-1"></i> Crear Nuevo Rol
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            @forelse ($roles as $rol)
                @php
                    $nombre = mb_strtolower($rol->name, 'UTF-8');
                    $style = [
                        'icon' => 'fa-user-cog',
                        'gradient' => 'linear-gradient(135deg, #6c757d 0%, #495057 100%)',
                        'shadow' => 'rgba(108, 117, 125, 0.3)',
                        'border' => '#6c757d'
                    ];

                    if (str_contains($nombre, 'admin')) {
                        $style = [
                            'icon' => 'fa-user-shield',
                            'gradient' => 'linear-gradient(135deg, #f1c40f 0%, #f39c12 100%)',
                            'shadow' => 'rgba(241, 196, 15, 0.4)',
                            'border' => '#f1c40f'
                        ];
                    } elseif (str_contains($nombre, 'prof') || str_contains($nombre, 'doce')) {
                        $style = [
                            'icon' => 'fa-chalkboard-teacher',
                            'gradient' => 'linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%)',
                            'shadow' => 'rgba(0, 210, 255, 0.4)',
                            'border' => '#00d2ff'
                        ];
                    } elseif (str_contains($nombre, 'estu') || str_contains($nombre, 'alum')) {
                        $style = [
                            'icon' => 'fa-user-graduate',
                            'gradient' => 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
                            'shadow' => 'rgba(17, 153, 142, 0.4)',
                            'border' => '#11998e'
                        ];
                    } elseif (str_contains($nombre, 'secre')) {
                        $style = [
                            'icon' => 'fa-user-tie',
                            'gradient' => 'linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%)',
                            'shadow' => 'rgba(142, 45, 226, 0.4)',
                            'border' => '#8e2de2'
                        ];
                    }
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="role-card" style="background: {{ $style['gradient'] }}; box-shadow: 0 8px 15px {{ $style['shadow'] }}; border-left: 4px solid {{ $style['border'] }};">
                        <div class="card-content">
                            <div class="icon-section">
                                <i class="fas {{ $style['icon'] }} side-icon"></i>
                            </div>
                            <div class="text-section">
                                <span class="badge badge-light mb-1" style="font-size: 0.7rem; opacity: 0.8;">Credencial de Rol</span>
                                <h2 class="role-title">{{ strtoupper($rol->name) }}</h2>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            <form action="{{ route('admin.roles.destroy', $rol->id) }}" method="POST" id="formDelete{{ $rol->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="confirmDelete(event, 'formDelete{{ $rol->id }}')" title="Eliminar Rol">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <div class="empty-icon-wrapper mb-4">
                            <i class="fas fa-user-tag fa-4x text-muted opacity-25"></i>
                        </div>
                        <h3 class="text-muted font-weight-light">No hay roles registrados</h3>
                        <p class="text-secondary">Comienza registrando los roles necesarios para el control de acceso.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @include('admin.roles.create')
@stop

@section('css')
<style>
    :root {
        --card-radius: 15px;
    }

    .role-card {
        border-radius: var(--card-radius);
        padding: 20px;
        position: relative;
        overflow: hidden;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-height: 140px;
        height: auto;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 1;
    }

    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2) !important;
    }

    .role-card::before {
        content: '';
        position: absolute;
        top: -10%;
        right: -10%;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        z-index: -1;
    }

    .card-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .side-icon {
        font-size: 2.2rem;
        opacity: 0.8;
        filter: drop-shadow(0 2px 5px rgba(0,0,0,0.1));
    }

    .role-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .card-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .btn-delete {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #dc3545;
        border-color: transparent;
        transform: scale(1.1);
    }

    .empty-state {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: var(--card-radius);
        padding: 40px;
    }

    /* Simple Entrance Animation */
    .col-xl-3 {
        animation: fadeIn 0.4s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@stop

@section('js')
<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro de eliminar este rol?',
            text: "Esta acción no se puede deshacer y revocará el acceso a los usuarios con este rol.",
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

    @if(session('mensaje') && session('icono'))
        Swal.fire({
            icon: "{{ session('icono') }}", 
            title: "{{ session('mensaje') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif
</script>
@stop
