<!-- Modal para crear nueva sección / paralelo -->
<div class="modal fade" id="modalCrearSeccion" tabindex="-1" role="dialog" aria-labelledby="modalCrearSeccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-warning text-dark p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearSeccionLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Nueva Sección
                </h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.secciones.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Campo: Nombre de la Sección -->
                    <div class="form-group mb-4">
                        <label for="nombreSeccion" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-tag mr-1"></i> Nombre de la Sección <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm border-2-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-warning">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>
                            <input type="text" 
                                   class="form-control border-0 @error('nombreSeccion') is-invalid @enderror" 
                                   id="nombreSeccion" 
                                   name="nombreSeccion" 
                                   placeholder="Ej: A, B, C" 
                                   value="{{ old('nombreSeccion') }}"
                                   required
                                   style="font-size: 1rem; font-weight: 500;">
                        </div>
                        @error('nombreSeccion')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Campo: Selección de Grado -->
                    <div class="form-group mb-0">
                        <label for="gradoID" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-layer-group mr-1"></i> Grado Académico <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm border-2-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-warning">
                                    <i class="fas fa-chalkboard"></i>
                                </span>
                            </div>
                            <select name="gradoID" id="gradoID" class="form-control border-0 @error('gradoID') is-invalid @enderror" required style="font-size: 1rem; font-weight: 500;">
                                <option value="" disabled selected>Seleccione un grado...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado->id }}" {{ old('gradoID') == $grado->id ? 'selected' : '' }}>
                                        {{ $grado->nombreGrado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('gradoID')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <p class="text-muted small mt-4 mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Las secciones (o paralelos) permiten organizar a los estudiantes de un mismo grado en diferentes grupos.
                    </p>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm btn-save-custom-warning text-dark" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Sección
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
        border-color: #f6c23e !important;
        box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.15) !important;
    }

    .btn-save-custom-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(246, 194, 62, 0.3) !important;
    }
</style>
