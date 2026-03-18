<!-- Modal para crear nuevo grado -->
<div class="modal fade" id="modalCrearGrado" tabindex="-1" role="dialog" aria-labelledby="modalCrearGradoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-info text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearGradoLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Nuevo Grado
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.grados.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Campo: Nombre del Grado -->
                    <div class="form-group mb-4">
                        <label for="nombreGrado" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-tag mr-1"></i> Nombre del Grado <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm border-2-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-info">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>
                            <input type="text" 
                                   class="form-control border-0 @error('nombreGrado') is-invalid @enderror" 
                                   id="nombreGrado" 
                                   name="nombreGrado" 
                                   placeholder="Ej: Primero de Primaria" 
                                   value="{{ old('nombreGrado') }}"
                                   required
                                   style="font-size: 1rem; font-weight: 500;">
                        </div>
                        @error('nombreGrado')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Campo: Selección de Nivel -->
                    <div class="form-group mb-0">
                        <label for="nivelID" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-layer-group mr-1"></i> Nivel Académico <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm border-2-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-info">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                            </div>
                            <select name="nivelID" id="nivelID" class="form-control border-0 @error('nivelID') is-invalid @enderror" required style="font-size: 1rem; font-weight: 500;">
                                <option value="" disabled selected>Seleccione un nivel...</option>
                                @foreach($niveles as $nivel)
                                    <option value="{{ $nivel->id }}" {{ old('nivelID') == $nivel->id ? 'selected' : '' }}>
                                        {{ $nivel->nombreNivel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('nivelID')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <p class="text-muted small mt-4 mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Los grados permiten organizar a los estudiantes por niveles educativos dentro de la institución.
                    </p>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-info px-4 shadow-sm btn-save-custom text-white" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Grado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-modal-animation {
        animation: modalEntrance gr0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntrance {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .border-2-custom {
        border-radius: 12px; 
        overflow: hidden; 
        border: 2px solid #e9ecef;
        transition: all 0.3s;
    }

    .form-control:focus {
        box-shadow: none !important;
    }

    .input-group:focus-within {
        border-color: #36b9cc !important;
        box-shadow: 0 0 0 0.2rem rgba(54, 185, 204, 0.15) !important;
    }

    .btn-save-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(54, 185, 204, 0.3) !important;
    }
</style>
