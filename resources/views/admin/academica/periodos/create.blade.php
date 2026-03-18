<!-- Modal para crear nuevo periodo -->
<div class="modal fade" id="modalCrearPeriodo" tabindex="-1" role="dialog" aria-labelledby="modalCrearPeriodoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearPeriodoLabel">
                    <i class="fas fa-calendar-plus mr-2"></i>Crear Nuevo Periodo
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.periodos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Campo: Nombre del Periodo -->
                    <div class="form-group mb-4">
                        <label for="nombrePeriodo" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-tag mr-1"></i> Nombre del Periodo <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm border-2-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-primary">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>
                            <input type="text" 
                                   class="form-control border-0 @error('nombrePeriodo') is-invalid @enderror" 
                                   id="nombrePeriodo" 
                                   name="nombrePeriodo" 
                                   placeholder="Ej: Primer Bimestre" 
                                   value="{{ old('nombrePeriodo') }}"
                                   required
                                   style="font-size: 1rem; font-weight: 500;">
                        </div>
                        @error('nombrePeriodo')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Campo: Selección de Gestión -->
                    <div class="form-group mb-0">
                        <label for="gestionID" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-calendar-check mr-1"></i> Gestión Asociada <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm border-2-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-primary">
                                    <i class="fas fa-university"></i>
                                </span>
                            </div>
                            <select name="gestionID" id="gestionID" class="form-control border-0 @error('gestionID') is-invalid @enderror" required style="font-size: 1rem; font-weight: 500;">
                                <option value="" disabled selected>Seleccione una gestión...</option>
                                @foreach($gestions as $gestion)
                                    <option value="{{ $gestion->id }}" {{ old('gestionID') == $gestion->id ? 'selected' : '' }}>
                                        {{ $gestion->nombreGestion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('gestionID')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <p class="text-muted small mt-4 mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Los periodos permiten organizar las calificaciones y asistencias dentro de una gestión.
                    </p>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm btn-save-custom" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Periodo
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
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .btn-save-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3) !important;
    }
</style>
