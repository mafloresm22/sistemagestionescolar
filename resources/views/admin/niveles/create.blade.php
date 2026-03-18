<!-- Modal para crear nuevo nivel -->
<div class="modal fade" id="modalCrearNivel" tabindex="-1" role="dialog" aria-labelledby="modalCrearNivelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-nivel-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearNivelLabel">
                    <i class="fas fa-layer-group mr-2"></i>Crear Nuevo Nivel
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.niveles.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label for="nombreNivel" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-tag mr-1"></i> Nombre del Nivel <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-primary">
                                    <i class="fas fa-list-ul"></i>
                                </span>
                            </div>
                            <select name="nombreNivel" id="nombreNivel" class="form-control border-0 @error('nombreNivel') is-invalid @enderror" required style="font-size: 1.1rem; font-weight: 500;">
                                <option value="" disabled selected>Seleccione un nivel...</option>
                                <option value="INICIAL" {{ old('nombreNivel') == 'INICIAL' ? 'selected' : '' }}>INICIAL</option>
                                <option value="PRIMARIA" {{ old('nombreNivel') == 'PRIMARIA' ? 'selected' : '' }}>PRIMARIA</option>
                                <option value="SECUNDARIA" {{ old('nombreNivel') == 'SECUNDARIA' ? 'selected' : '' }}>SECUNDARIA</option>
                            </select>
                        </div>
                        @error('nombreNivel')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <p class="text-muted small mt-3 mb-0">
                            <i class="fas fa-info-circle mr-1"></i> Ingrese el nivel académico para los alumnos.
                        </p>
                    </div>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm btn-save-nivel" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Nivel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-modal-nivel-animation {
        animation: modalEntranceNivel 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntranceNivel {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .input-group:focus-within {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15) !important;
    }

    .btn-save-nivel:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3) !important;
    }
</style>
