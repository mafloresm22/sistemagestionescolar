<!-- Modal para crear nueva gestión -->
<div class="modal fade" id="modalCrearGestion" tabindex="-1" role="dialog" aria-labelledby="modalCrearGestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-info text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearGestionLabel">
                    <i class="fas fa-calendar-plus mr-2"></i>Crear Nueva Gestión
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.gestiones.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label for="nombreGestion" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-tag mr-1"></i> Nombre de la Gestión <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-info">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="number" 
                                   class="form-control border-0 @error('nombreGestion') is-invalid @enderror" 
                                   id="nombreGestion" 
                                   name="nombreGestion" 
                                   placeholder="Ej: 2026" 
                                   value="{{ old('nombreGestion') }}"
                                   required
                                   style="font-size: 1.1rem; font-weight: 500;">
                        </div>
                        @error('nombreGestion')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <p class="text-muted small mt-3 mb-0">
                            <i class="fas fa-info-circle mr-1"></i> Ingrese el periodo académico o año educativo que desea habilitar.
                        </p>
                    </div>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-info px-4 shadow-sm btn-save-custom" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Gestión
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-modal-animation {
        animation: modalEntrance 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntrance {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .form-control:focus {
        box-shadow: none !important;
    }

    .input-group:focus-within {
        border-color: #17a2b8 !important;
        box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.15) !important;
    }

    .btn-save-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3) !important;
    }
</style>
