{{-- MODAL TOMAR ASISTENCIA --}}
<div class="modal fade" id="modalTomarAsistencia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-check-double mr-2"></i>Registro de Asistencia Diaria</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.cursos-docentes-asistencias.store', $asignacion->idAsignarCursoDocente) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert bg-light border mb-4 shadow-sm" style="border-radius: 12px;">
                        <div class="row align-items-center">
                            <div class="col-md-6 border-right">
                                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Cuso / Aula</small>
                                <div class="font-weight-bold text-primary">
                                    <i class="fas fa-book mr-1"></i> {{ $asignacion->curso->nombreCurso }}
                                    <span class="mx-2 text-muted">|</span> 
                                    <i class="fas fa-door-open mr-1"></i> {{ $aulaAsignada->aula->nombreAula ?? 'Sin Aula' }}
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-4">
                                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Grado / Sección / Turno</small>
                                <div class="text-dark">
                                    {{ $asignacion->grado->nombreGrado }} - "{{ $asignacion->seccion->nombreSeccion }}" ({{ $asignacion->turno->nombreTurno }})
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="font-weight-bold small text-muted">Fecha del Registro</label>
                            <input type="date" name="fechaAsistencias" class="form-control rounded-pill border-0 bg-light shadow-none" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="font-weight-bold small text-muted">Observaciones Generales (Opcional)</label>
                            <input type="text" name="observacionAsistencias" class="form-control rounded-pill border-0 bg-light shadow-none" placeholder="Ej: Clase de repaso, alumnos laboratorios...">
                        </div>
                    </div>

                    <h6 class="font-weight-bold mb-3 d-flex align-items-center">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>
                        Listado de Alumnos ({{ $estudiantes->count() }})
                        <div class="ml-auto">
                            <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2 mr-1" onclick="markAll('Presente')">Todo P</button>
                            <button type="button" class="btn btn-xs btn-outline-danger rounded-pill px-2" onclick="markAll('Falta')">Todo F</button>
                        </div>
                    </h6>

                    <div class="table-container shadow-sm border rounded-lg" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped mb-0">
                            <thead class="bg-light position-sticky" style="top: 0; z-index: 1;">
                                <tr>
                                    <th class="border-0 px-3 py-2 small">Estudiante</th>
                                    <th class="border-0 text-center py-2 small" style="width: 250px;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $e)
                                    <tr>
                                        <td class="align-middle px-3 py-1">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light border mr-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.7rem;">
                                                    {{ strtoupper(substr($e->estudiante->nombreEstudiante, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold small" style="line-height:1">{{ $e->estudiante->nombreEstudiante }} {{ $e->estudiante->apellidoEstudiante }}</div>
                                                    <small class="text-muted" style="font-size: 0.65rem;">DNI: {{ $e->estudiante->dniEstudiante }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-xs flex-fill m-0 rounded-0 active" style="font-size: 0.65rem;">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Presente" checked> P
                                                </label>
                                                <label class="btn btn-outline-warning btn-xs flex-fill m-0 rounded-0" style="font-size: 0.65rem;">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Tarde"> T
                                                </label>
                                                <label class="btn btn-outline-danger btn-xs flex-fill m-0 rounded-0" style="font-size: 0.65rem;">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Falta"> F
                                                </label>
                                                <label class="btn btn-outline-secondary btn-xs flex-fill m-0 rounded-pill-right" style="font-size: 0.65rem;">
                                                    <input type="radio" name="asistencias[{{ $e->estudiante->idEstudiante }}]" value="Justificada"> J
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Guardar Asistencia</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-group-toggle .btn { border-radius: 0; }
    .btn-group-toggle .btn:first-child { border-top-left-radius: 20px; border-bottom-left-radius: 20px; }
    .btn-group-toggle .btn:last-child { border-top-right-radius: 20px; border-bottom-right-radius: 20px; }
    .rounded-pill-right { border-top-right-radius: 20px; border-bottom-right-radius: 20px; }
</style>
