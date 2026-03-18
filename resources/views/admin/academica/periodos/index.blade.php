<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-dark font-weight-bold">
        <i class="fas fa-layer-group text-primary mr-2"></i>Gestión de Periodos Académicos
    </h4>
    <button class="btn btn-primary rounded-pill shadow-sm px-4 btn-hover-grow" data-toggle="modal" data-target="#modalCrearPeriodo">
        <i class="fas fa-plus-circle mr-2"></i>Nuevo Periodo
    </button>
</div>

<div class="table-scroll-container shadow-sm rounded-lg" style="background: white; border: 1px solid #e3e6f0;">
    <table class="table table-hover mb-0 align-middle">
        <thead class="bg-primary text-white text-uppercase small font-weight-bold sticky-thead">
            <tr>
                <th class="py-3 px-4" style="width: 200px;">Gestión</th>
                <th class="py-3">Periodos Registrados</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gestions as $gestion)
                @if($gestion->periodos->count() > 0)
                <tr class="fade-in-row">
                    <td class="align-middle px-4">
                        <div class="d-flex align-items-center">
                            <div class="gestion-icon-box mr-3">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <div>
                                <span class="d-block font-weight-bold text-dark h6 mb-0">{{ $gestion->nombreGestion }}</span>
                                <small class="text-muted text-uppercase">{{ $gestion->periodos->count() }} Periodos</small>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="d-flex flex-wrap">
                            @foreach($gestion->periodos as $periodo)
                            <div class="period-chip shadow-xs border rounded-pill px-3 py-2 mr-2 mb-2 d-flex align-items-center bg-light">
                                <div class="period-dot mr-2"></div>
                                <span class="font-weight-bold text-dark small mr-3">{{ $periodo->nombrePeriodo }}</span>
                                <div class="period-actions">
                                    <button class="btn btn-link btn-xs text-warning p-0 mr-1" 
                                            title="Editar"
                                            data-toggle="modal" 
                                            data-target="#modalEditarPeriodo{{ $periodo->id }}">
                                        <i class="fas fa-edit fa-xs"></i>
                                    </button>
                                    <form id="delete-form-{{ $periodo->id }}" action="{{ route('admin.periodos.destroy', $periodo->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button class="btn btn-link btn-xs text-danger p-0" title="Eliminar" 
                                            onclick="confirmDelete(event, 'delete-form-{{ $periodo->id }}')">
                                        <i class="fas fa-trash-alt fa-xs"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="2" class="text-center py-5">
                        <div class="empty-state-container">
                            <i class="fas fa-folder-open fa-4x text-gray-200 mb-3"></i>
                            <h5 class="text-gray-500 font-weight-bold">No hay periodos registrados</h5>
                            <p class="text-gray-400">Las gestiones aparecerán aquí conforme les asignes periodos.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .table-scroll-container {
        max-height: 380px; /* Altura aproximada para 3-4 registros */
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #4e73df #f8f9fc;
    }

    /* Scrollbar estilizado para Chrome/Edge/Safari */
    .table-scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .table-scroll-container::-webkit-scrollbar-track {
        background: #f8f9fc;
        border-radius: 10px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb {
        background: #4e73df;
        border-radius: 10px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #2e59d9;
    }

    .sticky-thead {
        position: sticky;
        top: 0;
        z-index: 100;
        background-color: #4e73df !important;
    }
    
    .gestion-icon-box {
        width: 40px;
        height: 40px;
        background: #f0f2f9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .period-chip {
        transition: all 0.2s ease;
        background: #fff !important;
    }

    .period-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        border-color: #4e73df;
    }

    .period-dot {
        width: 8px;
        height: 8px;
        background: #4e73df;
        border-radius: 50%;
    }

    .period-actions {
        border-left: 1px solid #e3e6f0;
        padding-left: 8px;
        display: flex;
        align-items: center;
    }

    .btn-xs { padding: 0.1rem 0.2rem; font-size: 0.75rem; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    
    .fade-in-row {
        animation: fadeInRow 0.4s ease-out forwards;
    }
    .btn-hover-grow { transition: transform 0.2s; }
    .btn-hover-grow:hover { transform: scale(1.05); }

    @keyframes fadeInRow {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .empty-state-container {
        max-width: 400px;
        margin: 0 auto;
    }
</style>

@push('js')
<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro de eliminar este periodo?',
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
@endpush