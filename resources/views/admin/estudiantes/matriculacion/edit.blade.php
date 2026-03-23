<div class="modal fade animate__animated animate__zoomIn" id="modalEditMatriculacion" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 bg-gradient-info">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalEditLabel" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-edit mr-2"></i> EDITAR MATRICULACIÓN
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formEditMatriculacion" method="POST" class="form-premium">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4 bg-light">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="alert alert-info border-0 shadow-xs mb-0" style="border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-graduate fa-2x mr-3 opacity-50"></i>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold" id="editEstudianteNombre">Nombre del Estudiante</h6>
                                        <small id="editEstudianteDNI">DNI: 00000000</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="small-label">Nivel <span class="text-danger">*</span></label>
                            <select name="nivelesID" id="editNivelesID" class="form-control form-control-sm" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($niveles as $n)
                                    <option value="{{ $n->id }}">{{ $n->nombreNivel }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 form-group mb-3">
                            <label class="small-label">Grado <span class="text-danger">*</span></label>
                            <select name="gradosID" id="editGradosID" class="form-control form-control-sm" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($grados as $g)
                                    <option value="{{ $g->id }}" data-nivel="{{ $g->nivelID }}">{{ $g->nombreGrado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="small-label">Sección <span class="text-danger">*</span></label>
                            <select name="seccionID" id="editSeccionID" class="form-control form-control-sm" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($secciones as $s)
                                    <option value="{{ $s->idSeccion }}" data-grado="{{ $s->gradoID }}">{{ $s->nombreSeccion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="small-label">Turno <span class="text-danger">*</span></label>
                            <select name="turnoID" id="editTurnoID" class="form-control form-control-sm" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($turnos as $t)
                                    <option value="{{ $t->id }}">{{ $t->nombreTurno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-white py-3 justify-content-end border-top">
                    <button type="button" class="btn btn-danger px-4 py-2 mr-2" data-dismiss="modal" style="font-weight: 600; border-radius: 10px;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-info px-5 py-2 shadow-sm hover-lift text-white" style="border-radius: 10px; font-weight: 700;">
                        <i class="fas fa-save mr-2"></i> ACTUALIZAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient-info { background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); }
</style>
