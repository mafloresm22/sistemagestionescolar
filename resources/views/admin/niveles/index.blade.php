@extends('adminlte::page')

@section('title', 'Niveles')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    <i class="fas fa-layer-group mr-2 text-primary"></i>Niveles Académicos
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalCrearNivel" style="border-radius: 20px;">
                    <i class="fas fa-plus-circle mr-1"></i> Crear Nuevo Nivel
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            @forelse ($niveles as $nivel)
                @php
                    $nombre = mb_strtolower($nivel->nombreNivel, 'UTF-8');
                    $style = [
                        'icon' => 'fa-graduation-cap',
                        'gradient' => 'linear-gradient(135deg, #6c757d 0%, #495057 100%)',
                        'shadow' => 'rgba(108, 117, 125, 0.3)',
                        'border' => '#6c757d'
                    ];

                    if (str_contains($nombre, 'inic')) {
                        $style = [
                            'icon' => 'fa-child',
                            'gradient' => 'linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%)',
                            'shadow' => 'rgba(0, 210, 255, 0.4)',
                            'border' => '#00d2ff'
                        ];
                    } elseif (str_contains($nombre, 'prim')) {
                        $style = [
                            'icon' => 'fa-book-reader',
                            'gradient' => 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
                            'shadow' => 'rgba(17, 153, 142, 0.4)',
                            'border' => '#11998e'
                        ];
                    } elseif (str_contains($nombre, 'secu')) {
                        $style = [
                            'icon' => 'fa-user-graduate',
                            'gradient' => 'linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%)',
                            'shadow' => 'rgba(142, 45, 226, 0.4)',
                            'border' => '#8e2de2'
                        ];
                    }
                @endphp

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="nivel-card" style="background: {{ $style['gradient'] }}; box-shadow: 0 15px 35px {{ $style['shadow'] }}; border-left: 5px solid {{ $style['border'] }};">
                        <div class="card-content">
                            <div class="icon-section">
                                <i class="fas {{ $style['icon'] }} float-icon"></i>
                            </div>
                            <div class="text-section">
                                <span class="badge badge-light mb-2">Nivel Académico</span>
                                <h2 class="nivel-title">{{ $nivel->nombreNivel }}</h2>
                                <p class="nivel-subtitle">
                                    <i class="fas fa-check-circle mr-1"></i> Formación Activa
                                </p>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            <form action="{{ route('admin.niveles.destroy', $nivel->id) }}" method="POST" id="formDelete{{ $nivel->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="confirmDelete(event, 'formDelete{{ $nivel->id }}')">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar Nivel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <div class="empty-icon-wrapper mb-4">
                            <i class="fas fa-layer-group fa-5x text-muted opacity-25"></i>
                        </div>
                        <h3 class="text-muted font-weight-light">No hay niveles registrados</h3>
                        <p class="text-secondary lead">Comienza registrando los niveles educativos (Inicial, Primaria, Secundaria).</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @include('admin.niveles.create')
@stop

@section('css')
<style>
    :root {
        --card-radius: 20px;
    }

    .nivel-card {
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

    .nivel-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.2) !important;
    }

    .nivel-card::before {
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

    .nivel-title {
        font-weight: 800;
        font-size: 1.8rem;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .nivel-subtitle {
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
            title: '¿Estás seguro de eliminar este nivel?',
            text: "Esta acción no se puede deshacer y podría afectar a otros registros.",
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
