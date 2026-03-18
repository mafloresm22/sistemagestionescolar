<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-dark font-weight-bold mb-0">
        <i class="fas fa-sitemap text-warning mr-2"></i>Gestión de Secciones (Paralelos)
    </h4>
    <div class="d-flex align-items-center">
        <!-- JS Select list extracted from loaded levels directly -->
        @php
            $uniqueNiveles = collect($grados)->pluck('nivel')->filter()->unique('id');
        @endphp
        <div class="input-group shadow-sm mr-3 bg-white" style="width: 250px; border-radius: 20px; border: 2px solid #e9ecef; overflow: hidden;">
            <div class="input-group-prepend">
                <span class="input-group-text bg-white border-0 text-warning">
                    <i class="fas fa-filter"></i>
                </span>
            </div>
            <select id="filterNivel" class="form-control border-0 font-weight-bold text-secondary" style="font-size: 0.9rem; cursor: pointer; background: transparent; box-shadow: none;">
                <option value="all">Todos los niveles</option>
                @foreach($uniqueNiveles as $nivel)
                    <option value="{{ $nivel->id }}">{{ $nivel->nombreNivel }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-warning rounded-pill shadow-sm px-4 btn-hover-grow text-dark font-weight-bold" data-toggle="modal" data-target="#modalCrearSeccion">
            <i class="fas fa-plus-circle mr-2"></i>Nueva Sección
        </button>
    </div>
</div>

<div class="table-scroll-container shadow-sm rounded-lg" style="background: white; border: 1px solid #e3e6f0;">
    <table class="table table-hover mb-0 align-middle">
        <thead class="bg-warning text-dark text-uppercase small font-weight-bold sticky-thead">
            <tr>
                <th class="py-3 px-4" style="width: 250px;">Grado Académico</th>
                <th class="py-3">Secciones / Paralelos</th>
            </tr>
        </thead>
        <tbody>
            @php $countSeccionesTotales = 0; @endphp
            @foreach($grados as $grado)
                @if($grado->secciones->count() > 0)
                @php $countSeccionesTotales += $grado->secciones->count(); @endphp
                <tr class="fade-in-row seccion-row" data-nivel="{{ $grado->nivel ? $grado->nivel->id : 'none' }}">
                    <td class="align-middle px-4">
                        <div class="d-flex align-items-center">
                            <div class="seccion-icon-box mr-3">
                                <i class="fas fa-chalkboard text-warning"></i>
                            </div>
                            <div>
                                <span class="d-block font-weight-bold text-dark h6 mb-0">{{ $grado->nombreGrado }}</span>
                                <small class="text-muted text-uppercase">
                                    {{ $grado->nivel ? $grado->nivel->nombreNivel : 'Nivel no asignado' }}
                                </small>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="d-flex flex-wrap">
                            @foreach($grado->secciones as $seccion)
                            <div class="seccion-chip shadow-xs border rounded-pill px-3 py-2 mr-2 mb-2 d-flex align-items-center bg-light">
                                <div class="seccion-dot mr-2"></div>
                                <span class="font-weight-bold text-dark small mr-3">"{{ $seccion->nombreSeccion }}"</span>
                                <div class="seccion-actions">
                                    <button class="btn btn-link btn-xs text-info p-0 mr-1" 
                                            title="Editar"
                                            data-toggle="modal" 
                                            data-target="#modalEditarSeccion{{ $seccion->idSeccion }}">
                                        <i class="fas fa-edit fa-xs"></i>
                                    </button>
                                    <form id="delete-form-seccion-{{ $seccion->idSeccion }}" action="{{ route('admin.secciones.destroy', $seccion->idSeccion) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button class="btn btn-link btn-xs text-danger p-0" title="Eliminar" 
                                            onclick="confirmDeleteSeccion(event, 'delete-form-seccion-{{ $seccion->idSeccion }}')">
                                        <i class="fas fa-trash-alt fa-xs"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
            @endforeach

            @if($countSeccionesTotales == 0)
                <tr id="empty-state-row-zero">
                    <td colspan="2" class="text-center py-5">
                        <div class="empty-state-container">
                            <i class="fas fa-shapes fa-4x text-gray-200 mb-3"></i>
                            <h5 class="text-gray-500 font-weight-bold">No hay secciones registradas</h5>
                            <p class="text-gray-400">Los grados aparecerán aquí conforme les asignes secciones (paralelos).</p>
                        </div>
                    </td>
                </tr>
            @else
                <tr id="empty-state-row-filter" style="display: none;">
                    <td colspan="2" class="text-center py-5">
                        <div class="empty-state-container">
                            <i class="fas fa-filter fa-4x text-gray-200 mb-3"></i>
                            <h5 class="text-gray-500 font-weight-bold">No se encontraron paralelos</h5>
                            <p class="text-gray-400">No hay secciones registradas en este nivel.</p>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<style>
    .table-scroll-container {
        max-height: 380px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #f6c23e #f8f9fc;
    }

    .table-scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .table-scroll-container::-webkit-scrollbar-track {
        background: #f8f9fc;
        border-radius: 10px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb {
        background: #f6c23e;
        border-radius: 10px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #dfa822;
    }

    .sticky-thead {
        position: sticky;
        top: 0;
        z-index: 100;
        background-color: #f6c23e !important;
    }
    
    .seccion-icon-box {
        width: 40px;
        height: 40px;
        background: #fef5d9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .seccion-chip {
        transition: all 0.2s ease;
        background: #fff !important;
    }

    .seccion-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        border-color: #f6c23e !important;
    }

    .seccion-dot {
        width: 8px;
        height: 8px;
        background: #f6c23e;
        border-radius: 50%;
    }

    .seccion-actions {
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
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filterNivel');
        const rows = document.querySelectorAll('.seccion-row');
        const defaultEmptyState = document.getElementById('empty-state-row-zero');
        const filterEmptyState = document.getElementById('empty-state-row-filter');
        
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const selectedNivel = this.value;
                let visibleCount = 0;
                
                rows.forEach(row => {
                    // Si elegimos 'all' (todos) o coincide el data-nivel de la fila
                    if (selectedNivel === 'all' || row.dataset.nivel === selectedNivel) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Lógica para mostrar mensaje cuando un filtro no tiene ninguna fila
                if (filterEmptyState) {
                    if (visibleCount === 0) {
                        filterEmptyState.style.display = '';
                    } else {
                        filterEmptyState.style.display = 'none';
                    }
                }
            });
        }
    });

    function confirmDeleteSeccion(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la sección permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4b5c',
            cancelButtonColor: '#f6c23e',
            confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger px-4 mx-2',
                cancelButton: 'btn btn-warning px-4 mx-2 text-dark font-weight-bold'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush
