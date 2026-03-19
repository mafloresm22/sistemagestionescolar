<div class="modal fade animate__animated animate__zoomIn" id="modalCreateMatriculacion" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 bg-gradient-primary">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalLabel" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-file-signature mr-2"></i> NUEVA MATRICULACIÓN
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('admin.matriculacion.store') }}" method="POST" class="form-premium">
                @csrf
                <div class="modal-body px-4 py-4 bg-light">
                    <div class="row">
                        {{-- SECCIÓN IZQUIERDA: ESTUDIANTE --}}
                        <div class="col-lg-5 mb-4 mb-lg-0">
                            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                                    <h6 class="font-weight-bold text-primary mb-0">
                                        <i class="fas fa-user-graduate mr-2"></i> 1. Seleccione un Estudiante
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <select name="estudianteID" id="estudianteSelect" class="form-control select2" required style="width: 100%;">
                                            <option value="">Buscar por nombre o DNI...</option>
                                            @foreach($estudiantes as $e)
                                                <option value="{{ $e->idEstudiante }}" 
                                                    data-dni="{{ $e->dniEstudiante }}"
                                                    data-nombre="{{ $e->nombreEstudiante }} {{ $e->apellidoEstudiante }}"
                                                    data-celular="{{ $e->celularEstudiante ?? 'No registra' }}"
                                                    data-correo="{{ $e->correoEstudiante ?? 'No registra' }}"
                                                    data-padre="{{ $e->padreFamilia ? $e->padreFamilia->nombrePadreFamilia . ' ' . $e->padreFamilia->apellidoPadreFamilia : 'No registra' }}">
                                                    {{ $e->dniEstudiante }} - {{ $e->nombreEstudiante }} {{ $e->apellidoEstudiante }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- Tarjeta de Previsualización --}}
                                    <div id="previewCard" class="d-none">
                                        <div class="d-flex align-items-center p-3 mb-3 bg-primary-soft" style="border-radius: 12px; border: 1px dashed #007bff;">
                                            <div class="avatar-lg mr-3">
                                                <div id="previewInitials" class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center h2 mb-0 shadow-sm" style="width: 70px; height: 70px; font-weight: bold;">
                                                    --
                                                </div>
                                            </div>
                                            <div>
                                                <h5 id="previewNombre" class="font-weight-bold text-dark mb-1">Nombre Completo</h5>
                                                <span class="badge badge-primary px-2 py-1"><i class="fas fa-id-card mr-1"></i> <span id="previewDNI">00000000</span></span>
                                            </div>
                                        </div>
                                        
                                        <div class="row small text-secondary px-2">
                                            <div class="col-12 mb-2">
                                                <i class="fas fa-phone-alt mr-2 text-primary w-15px"></i> <strong class="text-dark">Celular:</strong> <span id="previewCelular"></span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <i class="fas fa-envelope mr-2 text-primary w-15px"></i> <strong class="text-dark">Correo:</strong> <span id="previewCorreo"></span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <i class="fas fa-user-shield mr-2 text-primary w-15px"></i> <strong class="text-dark">Apoderado:</strong> <span id="previewPadre"></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="noSelectionMsg" class="text-center py-5 text-muted">
                                        <i class="fas fa-search fa-3x mb-3" style="opacity: 0.2"></i>
                                        <p>Seleccione un estudiante de la lista para ver sus detalles aquí.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECCIÓN DERECHA: DATOS DE MATRÍCULA --}}
                        <div class="col-lg-7">
                            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                                    <h6 class="font-weight-bold text-primary mb-0">
                                        <i class="fas fa-clipboard-list mr-2"></i> 2. Datos Académicos
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="small-label">Nivel <span class="text-danger">*</span></label>
                                            <select name="nivelesID" id="nivelesID" class="form-control form-control-sm" required>
                                                <option value="" disabled selected>Seleccione...</option>
                                                @foreach($niveles as $n)
                                                    <option value="{{ $n->id }}">{{ $n->nombreNivel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="small-label">Grado <span class="text-danger">*</span></label>
                                            <select name="gradosID" id="gradosID" class="form-control form-control-sm" required disabled>
                                                <option value="" disabled selected>Seleccione un nivel primero...</option>
                                                @foreach($grados as $g)
                                                    <option value="{{ $g->id }}" data-nivel="{{ $g->nivelID }}">{{ $g->nombreGrado }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label class="small-label">Sección <span class="text-danger">*</span></label>
                                            <select name="seccionID" id="seccionID" class="form-control form-control-sm" required disabled>
                                                <option value="" disabled selected>Seleccione un grado primero...</option>
                                                @foreach($secciones as $s)
                                                    <option value="{{ $s->idSeccion }}" data-grado="{{ $s->gradoID }}">{{ $s->nombreSeccion }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label class="small-label">Turno <span class="text-danger">*</span></label>
                                            <select name="turnoID" id="turnoID" class="form-control form-control-sm" required>
                                                <option value="" disabled selected>Seleccione...</option>
                                                @foreach($turnos as $t)
                                                    <option value="{{ $t->id }}">{{ $t->nombreTurno }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label class="small-label">Gestión <span class="text-danger">*</span></label>
                                            <select name="gestionID" id="gestionID" class="form-control form-control-sm" required>
                                                <option value="" disabled selected>Seleccione...</option>
                                                @foreach($gestiones as $ges)
                                                    <option value="{{ $ges->id }}">{{ $ges->nombreGestion }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label class="small-label">Fecha de Matrícula <span class="text-danger">*</span></label>
                                            <input type="date" name="fechaMatriculacion" id="fechaMatriculacion" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        
                                        <div class="col-12 form-group mb-0 mt-2">
                                            <label class="small-label">Observaciones (Opcional)</label>
                                            <textarea name="observacionesMatriculacion" class="form-control" rows="2" placeholder="Alguna anotación importante sobre la matrícula..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-white py-3 justify-content-end border-top">
                    <button type="button" class="btn btn-danger px-4 py-2 mr-2" data-dismiss="modal" style="font-weight: 600; border-radius: 10px;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-custom px-5 py-2 shadow-sm hover-lift" style="border-radius: 10px; font-weight: 700;">
                        <i class="fas fa-check-circle mr-2"></i> MATRICULAR ESTUDIANTE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* --- ESTILOS COMPACTOS PREMIUM MATCH --- */
.small-label {
    font-size: 0.75rem;
    font-weight: 800;
    color: #4e5e7a;
    margin-bottom: 5px;
    margin-left: 2px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-premium .form-control, .form-premium .form-control-sm {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.375rem 0.75rem;
    transition: all 0.3s ease;
}

.form-premium .form-control:focus, .form-premium .form-control-sm:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.bg-gradient-primary { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }

/* Ajustes Select2 para coincidir con estilo Premium */
.select2-container--default .select2-selection--single {
    height: 42px !important;
    border-radius: 8px !important;
    border: 1px solid #ced4da !important;
    display: flex;
    align-items: center;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
}

.w-15px { width: 15px; text-align: center; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Select2 al abrir el modal para evitar bugs de focus
        $('#modalCreateMatriculacion').on('shown.bs.modal', function () {
            $('#estudianteSelect').select2({
                dropdownParent: $('#modalCreateMatriculacion'),
                placeholder: "Buscar por nombre o DNI...",
                allowClear: true,
                width: '100%'
            });
        });

        // Evento cambio de estudiante
        $('#estudianteSelect').on('change', function() {
            let option = $(this).find('option:selected');
            
            if(option.val() !== "") {
                // Hay selección
                let nombre = option.data('nombre');
                let dni = option.data('dni');
                let celular = option.data('celular');
                let correo = option.data('correo');
                let padre = option.data('padre');
                
                // Extraer iniciales (ej: Juan Perez -> JP)
                let parts = nombre.split(" ");
                let inits = "";
                if(parts.length > 0) inits += parts[0].charAt(0);
                if(parts.length > 1) inits += parts[1].charAt(0);
                
                $('#previewInitials').text(inits.toUpperCase());
                $('#previewNombre').text(nombre);
                $('#previewDNI').text(dni);
                $('#previewCelular').text(celular);
                $('#previewCorreo').text(correo);
                $('#previewPadre').text(padre);
                
                // Mostrar tarjeta
                $('#noSelectionMsg').addClass('d-none');
                $('#previewCard').removeClass('d-none').addClass('animate__animated animate__fadeIn');
            } else {
                // No hay selección
                $('#previewCard').addClass('d-none').removeClass('animate__animated animate__fadeIn');
                $('#noSelectionMsg').removeClass('d-none');
            }
        });
        
        // --- CASCADA DE SELECTS: Nivel -> Grado -> Sección --- //
        
        // 1. Al cambiar Nivel
        $('#nivelesID').on('change', function() {
            let nivelId = $(this).val();
            let $selectGrado = $('#gradosID');
            let $selectSeccion = $('#seccionID');
            
            // Reiniciar Grados
            $selectGrado.val('').prop('disabled', false);
            $selectGrado.find('option').each(function() {
                if($(this).val() === "") {
                    $(this).text("Seleccione un grado...");
                    return;
                }
                // Si coincide el nivel, lo mostramos, si no lo ocultamos/deshabilitamos
                if($(this).data('nivel') == nivelId) {
                    $(this).show().prop('disabled', false);
                } else {
                    $(this).hide().prop('disabled', true);
                }
            });
            
            // Reiniciar y deshabilitar Secciones porque cambió Nivel y aún no hay Grado
            $selectSeccion.val('').prop('disabled', true);
            $selectSeccion.find('option[value=""]').text("Seleccione un grado primero...");
        });

        // 2. Al cambiar Grado
        $('#gradosID').on('change', function() {
            let gradoId = $(this).val();
            let $selectSeccion = $('#seccionID');
            
            // Habilitar y filtrar Secciones
            $selectSeccion.val('').prop('disabled', false);
            $selectSeccion.find('option').each(function() {
                if($(this).val() === "") {
                    $(this).text("Seleccione una sección...");
                    return;
                }
                // Mostrar solo las secciones que pertenecen a este grado
                if($(this).data('grado') == gradoId) {
                    $(this).show().prop('disabled', false);
                } else {
                    $(this).hide().prop('disabled', true);
                }
            });
        });

    });
</script>
