{{-- MODAL EDIT ASIGNACION --}}
<div class="modal fade" id="modalEditAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Editar Asignación</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditAsignacion" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm border mb-2" style="width: 80px; height: 80px;">
                            <i class="fas fa-sync-alt text-success fa-2x"></i>
                        </div>
                        <p class="text-muted small">Actualiza los datos de vinculación del aula</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-door-open mr-1 text-success"></i> Aula</label>
                            <select name="aulaID" id="editAulaID" class="form-control select2 edit-rounded-pill-select" style="width: 100%" required>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->idAulas }}">{{ $aula->nombreAula }} (Cap: {{ $aula->capacidadAula }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-chalkboard mr-1 text-success"></i> Sección</label>
                            <select name="seccionID" id="editSeccionID" class="form-control select2 edit-rounded-pill-select" style="width: 100%" required>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion->idSeccion }}">{{ $seccion->nombreSeccion }} - {{ $seccion->grados->nombreGrado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-user-tie mr-1 text-success"></i> Docente Responsable</label>
                            <select name="personalID" id="editPersonalID" class="form-control select2 edit-rounded-pill-select" style="width: 100%" required>
                                @foreach($personals as $p)
                                    <option value="{{ $p->idPersonal }}">{{ $p->nombrePersonal }} {{ $p->apellidoPersonal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-calendar-alt mr-1 text-success"></i> Gestión</label>
                            <select name="gestionID" id="editGestionID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                @foreach($gestiones as $g)
                                    <option value="{{ $g->idGestion }}">{{ $g->nombreGestion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-clock mr-1 text-success"></i> Turno</label>
                            <select name="turnoID" id="editTurnoID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                @foreach($turnos as $t)
                                    <option value="{{ $t->idTurno }}">{{ $t->nombreTurno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold"><i class="fas fa-comment-dots mr-1 text-success"></i> Observaciones</label>
                        <textarea name="observacionesAsignarSeccionAula" id="editObs" class="form-control border-0 bg-light" rows="2" style="border-radius: 15px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm text-white">Actualizar Asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .edit-rounded-pill-select + .select2-container--bootstrap4 .select2-selection--single {
        border-radius: 50px !important;
        background-color: #f8f9fa !important;
        border: none !important;
        height: calc(1.5em + 1rem + 2px) !important;
        padding-top: 0.5rem !important;
    }
</style>
