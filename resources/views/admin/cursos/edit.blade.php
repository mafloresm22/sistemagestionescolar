<!-- Modal para editar curso -->
<div class="modal fade" id="modalEditarCurso" tabindex="-1" role="dialog" aria-labelledby="modalEditarCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content custom-modal-edit-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-warning text-dark p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalEditarCursoLabel">
                    <i class="fas fa-edit mr-2"></i>Editar Curso: <span id="edit_nombre_display" class="text-uppercase"></span>
                </h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarCurso" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Código del Curso (Informativo) -->
                        <div class="col-md-6 mb-3">
                            <label class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-barcode mr-1"></i> Código del Curso (No editable)
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef; background-color: #f8f9fa;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-0 text-muted">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <input type="text" id="edit_codigoCurso" class="form-control border-0 bg-transparent text-muted" readonly style="font-size: 1.1rem; font-weight: 500;">
                            </div>
                        </div>

                        <!-- Grado (Informativo en edición según el controlador) -->
                        <div class="col-md-6 mb-3">
                            <label class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-graduation-cap mr-1"></i> Grado
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef; background-color: #f8f9fa;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-0 text-muted">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <input type="text" id="edit_gradoNombre" class="form-control border-0 bg-transparent text-muted" readonly style="font-size: 1.1rem; font-weight: 500;">
                                <input type="hidden" name="gradoID" id="edit_gradoID">
                            </div>
                        </div>

                        <!-- Nombre del Curso -->
                        <div class="col-md-12 mb-3">
                            <label for="edit_nombreCurso" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-font mr-1"></i> Nombre del Curso <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-warning">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                </div>
                                <input type="text" name="nombreCurso" id="edit_nombreCurso" class="form-control border-0" 
                                    placeholder="Ej: Matemáticas Avanzadas" required style="font-size: 1.1rem; font-weight: 500;">
                            </div>
                        </div>

                        <!-- Descripción del Curso -->
                        <div class="col-md-12 mb-3">
                            <label for="edit_descripcionCurso" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-align-left mr-1"></i> Descripción del Curso
                            </label>
                            <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-warning align-items-start pt-3">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </div>
                                <textarea name="descripcionCurso" id="edit_descripcionCurso" class="form-control border-0" 
                                    placeholder="Breve descripción del curso..." rows="3" style="font-size: 1.1rem; font-weight: 500; resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm btn-update-curso" style="border-radius: 10px; font-weight: 600; transition: all 0.3s; color: #000;">
                        <i class="fas fa-sync-alt mr-1"></i> Actualizar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-modal-edit-animation {
        animation: modalEntranceEdit 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntranceEdit {
        from { opacity: 0; transform: scale(0.8) translateY(-30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    #formEditarCurso .input-group:focus-within {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15) !important;
    }

    .btn-update-curso:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3) !important;
    }
</style>
