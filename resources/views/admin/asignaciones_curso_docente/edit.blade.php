<!-- Modal Edit -->
<div class="modal fade" id="modalEditAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header text-white" style="background-color: #ffa63f; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Editar Asignación de Curso</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditAsignacion" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm border mb-2" style="width: 80px; height: 80px;">
                            <i class="fas fa-edit fa-2x" style="color: #ffa63f;"></i>
                        </div>
                        <p class="text-muted small">Actualice la información de asignación docente, curso y horarios.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-user-tie mr-1 text-primary"></i> Docente <span class="text-danger">*</span></label>
                            <select name="docenteId" id="editDocenteID" class="form-control select2 rounded-pill-select" style="width: 100%;" required>
                                <option value="">-- Buscar Docente --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->idPersonal }}">{{ $docente->dniPersonal }} - {{ $docente->nombrePersonal }} {{ $docente->apellidoPersonal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-book mr-1 text-primary"></i> Curso <span class="text-danger">*</span></label>
                            <select name="cursoID" id="editCursoID" class="form-control select2 rounded-pill-select" style="width: 100%;" required>
                                <option value="">-- Buscar Curso --</option>
                                @foreach($cursos->unique('nombreCurso') as $curso)
                                    <option value="{{ $curso->idCurso }}">{{ $curso->nombreCurso }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-layer-group mr-1 text-primary"></i> Nivel <span class="text-danger">*</span></label>
                            <select name="nivelID" id="editNivelID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($niveles as $nivel)
                                    <option value="{{ $nivel->id }}">{{ $nivel->nombreNivel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-graduation-cap mr-1 text-primary"></i> Grado <span class="text-danger">*</span></label>
                            <select name="gradoID" id="editGradosID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado->id }}" data-nivel="{{ $grado->nivelID }}">{{ $grado->nombreGrado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-users mr-1 text-primary"></i> Sección <span class="text-danger">*</span></label>
                            <select name="seccionID" id="editSeccionID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion->idSeccion }}" data-grado="{{ $seccion->gradoID }}">{{ $seccion->nombreSeccion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-calendar-alt mr-1 text-primary"></i> Gestión <span class="text-danger">*</span></label>
                            <select name="gestionID" id="editGestionID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($gestiones as $gestion)
                                    <option value="{{ $gestion->id }}">{{ $gestion->nombreGestion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-clock mr-1 text-primary"></i> Turno <span class="text-danger">*</span></label>
                            <select name="turnoID" id="editTurnoID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($turnos as $turno)
                                    <option value="{{ $turno->id }}">{{ $turno->nombreTurno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background-color: #ffa63f;">Actualizar Asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>
