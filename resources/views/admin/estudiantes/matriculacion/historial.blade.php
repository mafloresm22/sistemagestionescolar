<div class="modal fade" id="modalHistorialEstudiante" tabindex="-1" role="dialog"
    aria-labelledby="modalHistorialEstudianteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 15px; border: none; overflow: hidden;">
            <!-- Cabecera Compacta -->
            <div class="modal-header text-white py-3 border-0 d-flex align-items-center"
                style="background: #f6bc3f;">
                <h5 class="modal-title font-weight-bold" id="modalHistorialEstudianteLabel">
                    <i class="fas fa-history mr-2 text-warning animate__animated animate__rotateIn"></i>
                    Historial Académico
                </h5>
                <div class="ml-auto d-flex align-items-center">
                    <div class="search-box-compact shadow-sm mr-3">
                        <div class="input-group">
                            <input type="text" id="inputBuscarHistorial" class="form-control"
                                placeholder="DNI o Nombre..."
                                style="border-radius: 10px 0 0 10px; border: 1.5px solid #f8a712; height: 38px; width: 250px;">
                            <div class="input-group-append">
                                <button class="btn btn-warning text-white" id="btnBuscarHistorial"
                                    style="border-radius: 0 10px 10px 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close text-white opacity-8" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="modal-body p-0 bg-light">
                <!-- Contenedor con Scroll Personalizado -->
                <div id="contenedorScrollHistorial" class="custom-scrollbar" style="max-height: 65vh; overflow-y: auto;">
                    <div id="contenedorResultadosHistorial" class="p-4">
                        <div class="text-center py-5 transition-all" id="placeholderHistorial">
                            <div class="display-4 text-warning opacity-25 mb-3">
                                <i class="fas fa-search-plus"></i>
                            </div>
                            <h5 class="text-secondary font-weight-light">Inicia una búsqueda para visualizar el histórico del alumno.</h5>
                        </div>
                        
                        <div id="tablaResultados" class="d-none">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover align-middle mb-0 bg-white shadow-sm" 
                                       style="border-radius: 12px; overflow: hidden;">
                                    <thead class="bg-gray-100 text-secondary small font-weight-bold text-uppercase border-bottom">
                                        <tr>
                                            <th class="py-3 px-4">Periodo</th>
                                            <th class="py-3">Estudiante Encontrado</th>
                                            <th class="py-3">Grado y Sección</th>
                                            <th class="py-3">Turno</th>
                                            <th class="py-3 text-center">Estado</th>
                                            <th class="py-3 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyResultadosHistorial">
                                        <!-- Se llena vía AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-white border-top-0 py-2">
                <small class="text-muted mr-auto pl-3"><i class="fas fa-info-circle mr-1 text-warning"></i> Se muestran los resultados ordenados por fecha descendente.</small>
                <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal"
                    style="border-radius: 8px; font-size: 0.9rem; font-weight: 600;">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gray-100 {
        background-color: #f8f9fc;
    }
    
    /* Scrollbar Personalizado Premium */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #f8a712;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #f18000;
    }

    /* Estilos de Fila */
    #bodyResultadosHistorial tr {
        transition: all 0.2s;
        border-bottom: 1px solid #f1f1f1;
    }
    #bodyResultadosHistorial tr:hover {
        background-color: #fffaf0 !important;
    }
    
    .search-box-compact input:focus {
        box-shadow: 0 0 10px rgba(248, 167, 18, 0.2);
        border-color: #f8a712 !important;
        outline: none;
    }

    .badge-soft-success {
        background-color: #d4edda;
        color: #155724;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
    }

    .gestion-tag {
        background: #e7f3ff;
        color: #007bff;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 700;
        border: 1px solid #cce5ff;
    }
</style>

