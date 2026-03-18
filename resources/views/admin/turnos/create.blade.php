<!-- Modal para registrar nuevo turno -->
<div class="modal fade" id="modalCrearTurno" tabindex="-1" role="dialog" aria-labelledby="modalCrearTurnoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-modal-turno-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearTurnoLabel">
                    <i class="fas fa-clock mr-2"></i>Registrar Nuevo Turno
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.turnos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label for="nombreTurno" class="text-secondary font-weight-bold mb-2">
                            <i class="fas fa-tag mr-1"></i> Nombre del Turno <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 text-primary">
                                    <i class="fas fa-history"></i>
                                </span>
                            </div>
                            <select name="nombreTurno" id="nombreTurno" class="form-control border-0 @error('nombreTurno') is-invalid @enderror" required style="font-size: 1.1rem; font-weight: 500;">
                                <option value="" disabled selected>Seleccione un turno...</option>
                                <option value="MAÑANA" @if($turnos->contains('nombreTurno', 'MAÑANA')) disabled @endif>MAÑANA @if($turnos->contains('nombreTurno', 'MAÑANA')) (Ya registrado) @endif</option>
                                <option value="TARDE" @if($turnos->contains('nombreTurno', 'TARDE')) disabled @endif>TARDE @if($turnos->contains('nombreTurno', 'TARDE')) (Ya registrado) @endif</option>
                                <option value="NOCHE" @if($turnos->contains('nombreTurno', 'NOCHE')) disabled @endif>NOCHE @if($turnos->contains('nombreTurno', 'NOCHE')) (Ya registrado) @endif</option>
                            </select>
                        </div>
                        @error('nombreTurno')
                            <div class="text-danger mt-2 small">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <p class="text-muted small mt-3 mb-0">
                            <i class="fas fa-info-circle mr-1"></i> El sistema solo permite un registro por cada turno disponible.
                        </p>
                    </div>
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm btn-save-turno" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-save mr-1"></i> Guardar Turno
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-modal-turno-animation {
        animation: modalEntranceTurno 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntranceTurno {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .input-group:focus-within {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15) !important;
    }

    .btn-save-turno:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3) !important;
    }
</style>
