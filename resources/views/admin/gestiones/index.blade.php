@extends('adminlte::page')

@section('title', 'Gestiones')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>Gestión Educativa
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalCrearGestion" style="border-radius: 20px;">
                    <i class="fas fa-plus-circle mr-1"></i> Crear Nueva Gestión
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-none border-0 bg-transparent">
            <div class="card-header bg-white border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <h3 class="card-title text-muted font-weight-bold">
                    <i class="fas fa-list-ul mr-2"></i>Listado de los años educativos
                </h3>
            </div>
            
            <div class="card-body p-0 scrollable-gestiones">
                <div class="row">
                    @php
                        $colores = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-secondary', 'bg-indigo', 'bg-purple', 'bg-pink', 'bg-orange', 'bg-teal', 'bg-cyan'];
                    @endphp
                    @forelse ($gestiones as $gestion)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <!-- small card -->
                            <div class="small-box {{ $colores[$loop->index % count($colores)] }} gestion-card elevation-3">
                                <div class="inner p-4">
                                    <h3 class="font-weight-bold mb-0" style="font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                                        {{$gestion->nombreGestion}}
                                    </h3>
                                    <p class="opacity-75">
                                        <i class="fas fa-clock mr-1"></i> {{ $gestion->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar float-icon-gestion"></i>
                                </div>
                                <div class="small-box-footer d-flex justify-content-center p-2" style="background: rgba(0,0,0,0.1); border-radius: 0 0 15px 15px;">
                                    <button type="button" class="btn btn-sm btn-light shadow-sm btn-action-gestion mx-1" data-toggle="modal" data-target="#modalEditarGestion{{ $gestion->id }}" title="Editar" {{ $gestion->nombreGestion < date('Y') ? 'disabled' : '' }}>
                                        <i class="fas fa-edit text-warning"></i>
                                    </button>
                                    <form action="{{ route('admin.gestiones.destroy', $gestion->id) }}" method="POST" id="miFormulario{{ $gestion->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light shadow-sm btn-action-gestion mx-1" onclick="preguntar{{ $gestion->id }}(event)" {{ $gestion->nombreGestion < date('Y') ? 'disabled' : '' }}>
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>

                                    <script>
                                        function preguntar{{ $gestion->id }}(event) {
                                            event.preventDefault();

                                            Swal.fire({
                                                title: "¿Deseas eliminar esta gestión?",
                                                text: "Esta acción no se podrá revertir.",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#ff4b5c",
                                                cancelButtonColor: "#007bff",
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
                                                    document.getElementById('miFormulario{{ $gestion->id }}').submit();
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        @include('admin.gestiones.edit')
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="empty-state-gestiones">
                                <div class="icon-wrapper mb-4">
                                    <i class="fas fa-calendar-times fa-5x text-muted opacity-25"></i>
                                </div>
                                <h3 class="text-secondary font-weight-light">No se encontraron gestiones</h3>
                                <p class="text-muted lead">Parece que aún no has registrado ninguna gestión educativa.<br>Empieza creando una nueva.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir modal de crear gestión -->
    @include('admin.gestiones.create')
@stop

@section('css')
    <style>
        .gestion-card {
            border-radius: 15px !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            border: none;
        }

        .gestion-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
        }

        .float-icon-gestion {
            transition: all 0.5s ease;
            font-size: 5rem !important;
            opacity: 0.3;
            top: 15px !important;
            right: 15px !important;
        }

        .gestion-card:hover .float-icon-gestion {
            transform: scale(1.1) rotate(10deg);
            opacity: 0.5;
        }

        .btn-action-gestion {
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-action-gestion:hover {
            transform: scale(1.15);
            background: #fff !important;
        }

        .scrollable-gestiones {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 15px;
        }

        /* Scrollbar Premium */
        .scrollable-gestiones::-webkit-scrollbar {
            width: 8px;
        }
        .scrollable-gestiones::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
            border-radius: 10px;
        }
        .scrollable-gestiones::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        .scrollable-gestiones::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        .empty-state-gestiones {
            background: white;
            border: 3px dashed #e2e8f0;
            border-radius: 20px;
            padding: 80px 20px;
            transition: all 0.3s ease;
        }

        /* Animación de entrada */
        @keyframes fadeInCard {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .col-lg-3 {
            animation: fadeInCard 0.5s ease-out forwards;
            opacity: 0;
        }

        .col-lg-3:nth-child(1) { animation-delay: 0.1s; }
        .col-lg-3:nth-child(2) { animation-delay: 0.2s; }
        .col-lg-3:nth-child(3) { animation-delay: 0.3s; }
        .col-lg-3:nth-child(4) { animation-delay: 0.4s; }
    </style>
@stop

@section('js')
    <script>
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
