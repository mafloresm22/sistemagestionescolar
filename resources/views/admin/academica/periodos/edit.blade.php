@foreach($gestions as $gestion)
    @foreach($gestion->periodos as $periodo)
    <!-- Modal para editar periodo -->
    <div class="modal fade" id="modalEditarPeriodo{{ $periodo->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarPeriodoLabel{{ $periodo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content custom-modal-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
                <div class="modal-header bg-warning text-white p-4" style="border-bottom: none;">
                    <h5 class="modal-title font-weight-bold" id="modalEditarPeriodoLabel{{ $periodo->id }}">
                        <i class="fas fa-edit mr-2"></i>Editar Periodo: {{ $periodo->nombrePeriodo }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.periodos.update', $periodo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <!-- Campo: Nombre del Periodo -->
                        <div class="form-group mb-4">
                            <label for="nombrePeriodo{{ $periodo->id }}" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-tag mr-1"></i> Nombre del Periodo <span class="text-danger">*</span>
                            </label>
                            <div class="input-group shadow-sm border-2-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-warning">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                                <input type="text" 
                                       class="form-control border-0 @error('nombrePeriodo') is-invalid @enderror" 
                                       id="nombrePeriodo{{ $periodo->id }}" 
                                       name="nombrePeriodo" 
                                       placeholder="Ej: Primer Bimestre" 
                                       value="{{ old('nombrePeriodo', $periodo->nombrePeriodo) }}"
                                       required
                                       style="font-size: 1rem; font-weight: 500;">
                            </div>
                        </div>

                        <!-- Campo: Selección de Gestión -->
                        <input type="hidden" name="gestionID" value="{{ old('gestionID', $periodo->gestionID) }}">
                        <div class="form-group mb-0">
                            <label for="gestionID{{ $periodo->id }}" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-calendar-check mr-1"></i> Gestión Asociada <span class="text-danger">*</span>
                            </label>
                            <div class="input-group shadow-sm border-2-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-warning">
                                        <i class="fas fa-university"></i>
                                    </span>
                                </div>
                                <select name="gestion_disabled" id="gestionID{{ $periodo->id }}" class="form-control border-0 @error('gestionID') is-invalid @enderror" required style="font-size: 1rem; font-weight: 500; background-color: #f8f9fa; cursor: not-allowed;" disabled>
                                    @foreach($gestions as $g)
                                        <option value="{{ $g->id }}" {{ (old('gestionID', $periodo->gestionID) == $g->id) ? 'selected' : '' }}>
                                            {{ $g->nombreGestion }}
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
