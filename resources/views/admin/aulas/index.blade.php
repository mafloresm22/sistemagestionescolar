@extends('adminlte::page')

@section('title', 'Gestión de Aulas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
        <div>
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
@stop

@section('content')
<div class="container-fluid">
    {{-- Barra de Búsqueda --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="input-group" style="height: 60px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0 bg-white pl-4 pr-3">
                            <i class="fas fa-search text-primary" style="font-size: 1.2rem;"></i>
                        </span>
                    </div>
                    <input type="text" id="aulasSearch" class="form-control border-0 h-100" placeholder="Escribe el nombre del aula o capacidad para buscar..." style="font-size: 1.05rem; box-shadow: none;">
                    <div class="input-group-append p-2 bg-white">
                        <span class="badge badge-light d-flex align-items-center px-3" style="border-radius: 10px; font-weight: 600;">
                            <span id="aulasCount" class="mr-1">{{ count($aulas) }}</span> Aulas
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="aulasContainer">
        @forelse($aulas as $aula)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4 aula-item" 
             data-nombre="{{ strtolower($aula->nombreAula) }}" 
             data-capacidad="{{ $aula->capacidadAula }}">
            <div class="card shadow-sm h-100 aula-card" style="border-radius: 12px; border: 1px solid #eee;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box {{ $aula->estadoAula == 'Disponible' ? 'bg-success' : 'bg-danger' }} rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fas fa-door-open text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold">{{ $aula->nombreAula }}</h5>
                            <small class="text-muted"><i class="fas fa-users mr-1"></i> Capacidad: {{ $aula->capacidadAula }}</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <span class="badge {{ $aula->estadoAula == 'Disponible' ? 'badge-success' : 'badge-danger' }} badge-pill px-3">
                            {{ $aula->estadoAula }}
                        </span>
                        
                        <div class="btn-group">
                            <form action="{{ route('admin.aulas.toggle-status', $aula->idAulas) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-light border mr-1" title="Cambiar Estado">
                                    <i class="fas fa-sync-alt {{ $aula->estadoAula == 'Disponible' ? 'text-warning' : 'text-success' }}"></i>
                                </button>
                            </form>

                            <button type="button" class="btn btn-sm btn-light border btn-edit-aula mr-1" 
                                data-id="{{ $aula->idAulas }}"
                                data-nombre="{{ $aula->nombreAula }}"
                                data-capacidad="{{ $aula->capacidadAula }}"
                                title="Editar">
                                <i class="fas fa-edit text-info"></i>
                            </button>

                            <form action="{{ route('admin.aulas.destroy', $aula->idAulas) }}" method="POST" class="d-inline formulario-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border" title="Eliminar">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center px-4 animate__animated animate__fadeIn" id="emptyState">
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

    {{-- Estado cuando no hay resultados de búsqueda --}}
    <div id="noResults" class="col-12 py-5 text-center d-none">
        <div class="card border-0 shadow-sm p-5" style="border-radius: 25px;">
            <i class="fas fa-search fa-4x text-muted mb-4" style="opacity: 0.3;"></i>
            <h4 class="text-muted">No se encontraron aulas que coincidan con tu búsqueda.</h4>
            <p class="text-muted">Intenta con otro término o revisa la ortografía.</p>
        </div>
    </div>

    {{-- Paginación --}}
    <div id="pagination-controls" class="d-flex justify-content-center align-items-center mt-4">
        {{-- Se genera por JS --}}
    </div>
</div>

@include('admin.aulas.create')
@include('admin.aulas.edit')
@stop

@section('css')
<style>
    .aula-card {
        transition: transform 0.2s ease;
    }
    .aula-card:hover {
        transform: translateY(-3px);
    }

    /* Paginación */
    .pag-btn {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background: #fff;
        color: #007bff;
        margin: 0 4px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .pag-btn:hover:not(:disabled) {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }
    .pag-btn.active {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
        box-shadow: 0 2px 5px rgba(0,123,255,0.3);
    }
    .pag-btn:disabled {
        background: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Pagination & Search Logic
        const container = document.getElementById('aulasContainer');
        const items = Array.from(container.getElementsByClassName('aula-item'));
        const paginationContainer = document.getElementById('pagination-controls');
        const searchInput = document.getElementById('aulasSearch');
        const noResults = document.getElementById('noResults');
        const countSpan = document.getElementById('aulasCount');
        
        let currentPage = 1;
        const itemsPerPage = 12;
        let filteredItems = [...items];

        function renderPagination() {
            const pageCount = Math.ceil(filteredItems.length / itemsPerPage);
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

            // Números de página
            const range = 2;
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

            items.forEach(item => item.classList.add('d-none'));

            if (filteredItems.length === 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
                filteredItems.forEach((item, index) => {
                    if (index >= start && index < end) {
                        item.classList.remove('d-none');
                    }
                });
            }

            countSpan.innerText = filteredItems.length;
            renderPagination();
        }

        // Search logic
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            
            filteredItems = items.filter(item => {
                const nombre = item.getAttribute('data-nombre');
                const capacidad = item.getAttribute('data-capacidad');
                return nombre.includes(term) || capacidad.includes(term);
            });

            currentPage = 1;
            updateDisplay();
        });

        // Initial display
        updateDisplay();

        // Edit button click
        $(document).on('click', '.btn-edit-aula', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            let capacidad = $(this).data('capacidad');

            $('#editNombre').val(nombre);
            $('#editCapacidad').val(capacidad);
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
