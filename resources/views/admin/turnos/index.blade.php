@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    <i class="fas fa-clock mr-2 text-primary"></i>Configuración de Turnos
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                @if ($turnos->count() >= 3)
                    <button type="button" class="btn btn-secondary shadow-sm" disabled style="border-radius: 20px;">
                        <i class="fas fa-lock mr-1"></i> Turnos Completos
                    </button>
                @else
                    <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalCrearTurno" style="border-radius: 20px; transition: all 0.3s ease;">
                        <i class="fas fa-plus-circle mr-1"></i> Crear Nuevo Turno
                    </button>
                @endif
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            @forelse ($turnos as $turno)
                @php
                    $nombre = mb_strtolower($turno->nombreTurno, 'UTF-8');
                    $style = [
                        'icon' => 'fa-clock',
                        'gradient' => 'linear-gradient(135deg, #6c757d 0%, #495057 100%)',
                        'shadow' => 'rgba(108, 117, 125, 0.3)',
                        'border' => '#6c757d'
                    ];

                    if (str_contains($nombre, 'mañ')) {
                        $style = [
                            'icon' => 'fa-sun',
                            'gradient' => 'linear-gradient(135deg, #FFD700 0%, #FFA500 100%)',
                            'shadow' => 'rgba(255, 215, 0, 0.4)',
                            'border' => '#FFD700'
                        ];
                    } elseif (str_contains($nombre, 'tard')) {
                        $style = [
                            'icon' => 'fa-cloud-sun',
                            'gradient' => 'linear-gradient(135deg, #FF8C00 0%, #FF4500 100%)',
                            'shadow' => 'rgba(255, 140, 0, 0.4)',
                            'border' => '#FF8C00'
                        ];
                    } elseif (str_contains($nombre, 'noch')) {
                        $style = [
                            'icon' => 'fa-moon',
                            'gradient' => 'linear-gradient(135deg, #4B0082 0%, #000080 100%)',
                            'shadow' => 'rgba(75, 0, 130, 0.4)',
                            'border' => '#4B0082'
                        ];
                    }
                @endphp

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="turno-card" style="background: {{ $style['gradient'] }}; box-shadow: 0 15px 35px {{ $style['shadow'] }}; border-left: 5px solid {{ $style['border'] }};">
                        <div class="card-content">
                            <div class="icon-section">
                                <i class="fas {{ $style['icon'] }} float-icon"></i>
                            </div>
                            <div class="text-section">
                                <span class="badge badge-light mb-2">Turno</span>
                                <h2 class="turno-title">{{ $turno->nombreTurno }}</h2>
                                <p class="turno-date">
                                    <i class="fas fa-calendar-alt mr-1"></i> Registrado: {{ $turno->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            <form action="{{ route('admin.turnos.destroy', $turno->id) }}" method="POST" id="formDelete{{ $turno->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="confirmDelete(event, 'formDelete{{ $turno->id }}')">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar Turno
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <div class="empty-icon-wrapper mb-4">
                            <i class="fas fa-clock fa-5x text-muted opacity-25"></i>
                        </div>
                        <h3 class="text-muted font-weight-light">No hay turnos disponibles</h3>
                        <p class="text-secondary lead">Comienza creando los turnos para la gestión escolar (Mañana, Tarde, Noche).</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @include('admin.turnos.create')
@stop

@section('css')
<style>
    :root {
        --card-radius: 20px;
    }

    .turno-card {
        border-radius: var(--card-radius);
        padding: 30px;
        position: relative;
        overflow: hidden;
        color: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 220px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 1;
    }

    .turno-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.2) !important;
    }

    .turno-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        z-index: -1;
    }

    .card-content {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .float-icon {
        font-size: 4rem;
        opacity: 0.9;
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .turno-title {
        font-weight: 800;
        font-size: 2.2rem;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .turno-date {
        font-size: 0.95rem;
        opacity: 0.85;
        margin: 0;
    }

    .card-action {
        display: flex;
        justify-content: flex-end;
    }

    .btn-delete {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: rgba(220, 53, 69, 0.9);
        border-color: transparent;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    .empty-state {
        background: #f8f9fa;
        border: 3px dashed #dee2e6;
        border-radius: var(--card-radius);
        padding: 60px;
        transition: all 0.3s ease;
    }

    .empty-state:hover {
        border-color: #adb5bd;
        background: #f1f3f5;
    }

    /* Column Entrance Animation */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .col-lg-4 {
        animation: slideUp 0.6s ease-out forwards;
    }

    .col-lg-4:nth-child(1) { animation-delay: 0.1s; }
    .col-lg-4:nth-child(2) { animation-delay: 0.2s; }
    .col-lg-4:nth-child(3) { animation-delay: 0.3s; }
</style>
@stop

@section('js')
<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro de eliminar este turno?',
            text: "Los niveles y secciones asociados podrían verse afectados.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4b5c',
            cancelButtonColor: '#6c757d',
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

    // Success notification if session has message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Operación Exitosa!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif
</script>
@stop
