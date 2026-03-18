<!-- Modal para crear nuevo rol -->
<div class="modal fade" id="modalCrearRol" tabindex="-1" role="dialog" aria-labelledby="modalCrearRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-role-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearRolLabel">
                    <i class="fas fa-user-tag mr-2"></i>Crear Nuevo Rol
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label for="name" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-id-card mr-1"></i> Nombre del Rol <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-primary">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="name" id="name" class="form-control border-0 @error('name') is-invalid @enderror" 
                                   placeholder="Ej: ADMINISTRADOR, PROFESOR..." 
                                   value="{{ old('name') }}" required 
                                   style="font-size: 1.1rem; font-weight: 500; text-transform: uppercase;">
                        </div>
                        @error('name')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <p class="text-muted small mt-3 mb-0">
                            <i class="fas fa-info-circle mr-1"></i> Ingrese el nombre del rol para el control de acceso al sistema.
                        </p>
                    </div>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm btn-save-role" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Rol
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-modal-role-animation {
        animation: modalEntranceRole 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntranceRole {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .input-group:focus-within {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15) !important;
    }

    .btn-save-role:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3) !important;
    }
</style>
