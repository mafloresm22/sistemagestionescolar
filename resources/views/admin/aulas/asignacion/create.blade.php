{{-- MODAL CREATE ASIGNACION --}}
<div class="modal fade" id="modalCreateAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Nueva Asignación de Aula</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.asignar-secciones-aulas.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm border mb-2" style="width: 80px; height: 80px;">
                            <i class="fas fa-link text-primary fa-2x"></i>
                        </div>
                        <p class="text-muted small">Vincula un espacio físico con una sección y docente</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-door-open mr-1 text-primary"></i> Seleccionar Aula <span class="text-danger">*</span></label>
                            <select name="aulaID" class="form-control select2 rounded-pill-select" style="width: 100%" required>
                                <option value="">-- Buscar Aula --</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->idAulas }}">{{ $aula->nombreAula }} (Cap: {{ $aula->capacidadAula }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-chalkboard mr-1 text-primary"></i> Seleccionar Sección <span class="text-danger">*</span></label>
                            <select name="seccionID" class="form-control select2 rounded-pill-select" style="width: 100%" required>
                                <option value="">-- Buscar Sección --</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion->idSeccion }}">{{ $seccion->nombreSeccion }} - {{ $seccion->grados->nombreGrado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-user-tie mr-1 text-primary"></i> Docente Responsable <span class="text-danger">*</span></label>
                            <select name="personalID" class="form-control select2 rounded-pill-select" style="width: 100%" required>
                                <option value="">-- buscar Docente --</option>
                                @foreach($personals as $p)
                                    <option value="{{ $p->idPersonal }}">{{ $p->nombrePersonal }} {{ $p->apellidoPersonal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-calendar-alt mr-1 text-primary"></i> Gestión <span class="text-danger">*</span></label>
                            <select name="gestionID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($gestions as $g)
                                    <option value="{{ $g->id }}" 
                                        {{ trim($g->nombreGestion) == date('Y') ? 'selected' : '' }}>
                                        {{ $g->nombreGestion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold"><i class="fas fa-clock mr-1 text-primary"></i> Turno <span class="text-danger">*</span></label>
                            <select name="turnoID" class="form-control border-0 bg-light rounded-pill" style="height: calc(1.5em + 1rem + 2px);" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($turnos as $t)
                                    <option value="{{ $t->id }}">{{ $t->nombreTurno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold"><i class="fas fa-comment-dots mr-1 text-primary"></i> Observaciones</label>
                        <textarea name="observacionesAsignarSeccionAula" class="form-control border-0 bg-light" rows="2" style="border-radius: 15px;" placeholder="Notas opcionales..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Guardar Asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilo para que el Select2 combine con el diseño de Aulas */
    .rounded-pill-select + .select2-container--bootstrap4 .select2-selection--single {
        border-radius: 50px !important;
        background-color: #f8f9fa !important;
        border: none !important;
        height: calc(1.5em + 1rem + 2px) !important;
        padding-top: 0.5rem !important;
    }
</style>
