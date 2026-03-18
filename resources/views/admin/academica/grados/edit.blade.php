@foreach($niveles as $nivel)
    @foreach($nivel->grados as $grado)
    <!-- Modal para editar grado -->
    <div class="modal fade" id="modalEditarGrado{{ $grado->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarGradoLabel{{ $grado->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content custom-modal-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
                <div class="modal-header bg-warning text-white p-4" style="border-bottom: none;">
                    <h5 class="modal-title font-weight-bold" id="modalEditarGradoLabel{{ $grado->id }}">
                        <i class="fas fa-edit mr-2"></i>Editar Grado: {{ $grado->nombreGrado }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.grados.update', $grado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <!-- Campo: Nombre del Grado -->
                        <div class="form-group mb-4">
                            <label for="nombreGrado{{ $grado->id }}" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-tag mr-1"></i> Nombre del Grado <span class="text-danger">*</span>
                            </label>
                            <div class="input-group shadow-sm border-2-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-warning">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                                <input type="text" 
                                       class="form-control border-0 @error('nombreGrado') is-invalid @enderror" 
                                       id="nombreGrado{{ $grado->id }}" 
                                       name="nombreGrado" 
                                       placeholder="Ej: Primero de Primaria" 
                                       value="{{ old('nombreGrado', $grado->nombreGrado) }}"
                                       required
                                       style="font-size: 1rem; font-weight: 500;">
                            </div>
                        </div>

                        <!-- Campo: Selección de Nivel -->
                        <input type="hidden" name="nivelID" value="{{ old('nivelID', $grado->nivelID) }}">
                        <div class="form-group mb-0">
                            <label for="nivelID{{ $grado->id }}" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-layer-group mr-1"></i> Nivel Académico <span class="text-danger">*</span>
                            </label>
                            <div class="input-group shadow-sm border-2-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-warning">
                                        <i class="fas fa-graduation-cap"></i>
                                    </span>
                                </div>
                                <select name="nivel_disabled" id="nivelID{{ $grado->id }}" class="form-control border-0 @error('nivelID') is-invalid @enderror" required style="font-size: 1rem; font-weight: 500; background-color: #f8f9fa; cursor: not-allowed;" disabled>
                                    @foreach($niveles as $n)
                                        <option value="{{ $n->id }}" {{ (old('nivelID', $grado->nivelID) == $n->id) ? 'selected' : '' }}>
                                            {{ $n->nombreNivel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-4" style="border-top: none;">
                        <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-times-circle mr-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning px-4 shadow-sm btn-save-custom text-white" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-sync-alt mr-1"></i> Actualizar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

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
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15) !important;
    }

    .btn-save-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3) !important;
    }
</style>
