<div class="modal fade animate__animated animate__fadeIn" id="modalShowEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalShowEstudianteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px !important; overflow: hidden;">
            <!-- Botón de Cerrar (Mejorado para no sobreponerse) -->
            <div class="modal-header border-0 p-0" style="position: absolute; right: 15px; top: 10px; z-index: 1000;">
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; text-shadow: 0 2px 4px rgba(0,0,0,0.5); font-size: 1.8rem; outline: none; border: none; background: transparent;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row no-gutters text-break">
                    <!-- Columna Izquierda: Perfil Visual -->
                    <div class="col-md-4 bg-gradient-premium d-flex flex-column align-items-center justify-content-center py-5 text-white">
                        <div class="position-relative mb-3">
                            <img id="show_foto" src="" alt="Foto" class="rounded-circle shadow-lg border border-white p-1" 
                                 style="width: 140px; height: 140px; object-fit: cover; background: white;">
                            <div class="status-indicator bg-success border border-white rounded-circle shadow-sm" 
                                 style="position: absolute; bottom: 10px; right: 10px; width: 22px; height: 22px;"></div>
                        </div>
                        <h4 class="font-weight-bold mb-1 text-center px-3" id="show_nombre_completo">---</h4>
                        <p class="mb-0 opacity-8 text-uppercase" style="font-size: 0.75rem; letter-spacing: 2px;">Estudiante Matriculado</p>
                        
                        <div class="mt-4 px-4 w-100">
                             <div class="d-flex align-items-center mb-2 bg-white-opacity-1 p-2 rounded-lg" style="background: rgba(255,255,255,0.15); border-radius: 12px;">
                                <i class="fas fa-id-card mx-3 opacity-8"></i>
                                <div>
                                    <small class="d-block opacity-6 text-uppercase" style="font-size: 0.6rem;">DNI Estudiante</small>
                                    <span class="font-weight-bold" id="show_dni">---</span>
                                </div>
                             </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Datos Detallados -->
                    <div class="col-md-8 bg-white p-4">
                        <!-- Selector Segmentado (Nueva Forma de Pestañas) -->
                        <div class="d-flex bg-light p-1 mb-4 shadow-sm" style="border-radius: 15px;">
                            <button type="button" class="btn btn-segmented flex-fill active" id="btn-tab-personal" onclick="switchStudentTab('personal')">
                                <i class="fas fa-user-graduate mr-2"></i> Personal
                            </button>
                            <button type="button" class="btn btn-segmented flex-fill" id="btn-tab-parent" onclick="switchStudentTab('parent')">
                                <i class="fas fa-user-shield mr-2"></i> Apoderado
                            </button>
                        </div>

                        <div class="student-details-container">
                            <!-- Contenido: Información Personal -->
                            <div id="content-tab-personal" class="student-tab-content animate__animated animate__fadeIn">
                                <div class="row">
                                    <div class="col-sm-6 mb-4">
                                        <label class="text-muted small text-uppercase font-weight-bold mb-1 ml-1 d-block opacity-7">Género</label>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle-soft mr-3 bg-primary-soft">
                                                <i class="fas fa-venus-mars text-primary"></i>
                                            </div>
                                            <span class="font-weight-600 text-dark" id="show_genero">---</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label class="text-muted small text-uppercase font-weight-bold mb-1 ml-1 d-block opacity-7">Fecha Nacimiento</label>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle-soft mr-3 bg-info-soft">
                                                <i class="fas fa-calendar-alt text-info"></i>
                                            </div>
                                            <span class="font-weight-600 text-dark" id="show_fecha_nacimiento">---</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label class="text-muted small text-uppercase font-weight-bold mb-1 ml-1 d-block opacity-7">Celular / Contacto</label>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle-soft mr-3 bg-success-soft">
                                                <i class="fas fa-phone-alt text-success"></i>
                                            </div>
                                            <span class="font-weight-600 text-dark" id="show_celular">---</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label class="text-muted small text-uppercase font-weight-bold mb-1 ml-1 d-block opacity-7">Correo Electrónico</label>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle-soft mr-3 bg-warning-soft">
                                                <i class="fas fa-envelope text-warning"></i>
                                            </div>
                                            <span class="font-weight-600 text-dark" id="show_correo" style="font-size: 0.9rem;">---</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-muted small text-uppercase font-weight-bold mb-1 ml-1 d-block opacity-7">Dirección de Domicilio</label>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle-soft mr-3 bg-secondary-soft">
                                                <i class="fas fa-map-marker-alt text-secondary"></i>
                                            </div>
                                            <span class="font-weight-600 text-dark" id="show_direccion">---</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenido: Datos Apoderado -->
                            <div id="content-tab-parent" class="student-tab-content animate__animated animate__fadeIn d-none">
                                <div class="card border-0 rounded-lg p-3 shadow-sm mb-0" style="background: #f8fafc; border: 1px solid #edf2f7 !important;">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="avatar-sm mr-3">
                                            <div class="rounded-circle bg-primary-custom d-flex align-items-center justify-content-center shadow-sm" style="width: 54px; height: 54px; color: white;">
                                                <i class="fas fa-user-shield fa-lg"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 font-weight-bold text-dark" id="show_apoderado_nombre">---</h5>
                                            <small class="text-muted font-weight-bold">Apoderado Responsable</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="col-6 mb-3">
                                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1 opacity-7" style="font-size: 0.65rem;">DNI Apoderado</small>
                                            <span class="text-dark font-weight-bold" id="show_apoderado_dni" style="font-size: 0.95rem;">---</span>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1 opacity-7" style="font-size: 0.65rem;">Celular de Contacto</small>
                                            <span class="text-dark font-weight-bold" id="show_apoderado_celular" style="font-size: 0.95rem;">---</span>
                                        </div>
                                        <div class="col-12 mt-2 pt-2 border-top">
                                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1 opacity-7" style="font-size: 0.65rem;">Correo de Comunicación</small>
                                            <span class="text-primary font-weight-bold" id="show_apoderado_correo">---</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <span class="badge badge-info-soft px-3 py-2 rounded-pill font-italic" style="font-size: 0.75rem;">
                                        <i class="fas fa-info-circle mr-1"></i> Familiar principal registrado en el sistema.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-0 py-3 d-flex justify-content-center">
                <button type="button" class="btn btn-danger rounded-pill px-5 shadow-sm hover-lift font-weight-bold" data-dismiss="modal">
                     <i class="fas fa-times-circle mr-2"></i> Cerrar Detalle
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-premium {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    position: relative;
    overflow: hidden;
}

.icon-circle-soft {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.bg-primary-soft { background: #eef2ff; color: #4e73df; }
.bg-info-soft { background: #e0f2fe; color: #0ea5e9; }
.bg-success-soft { background: #f0fdf4; color: #22c55e; }
.bg-warning-soft { background: #fffbeb; color: #f59e0b; }
.bg-secondary-soft { background: #f8fafc; color: #64748b; }
.badge-info-soft { background: #e0f2fe; color: #0369a1; }

.font-weight-600 { font-weight: 600; }

.btn-segmented {
    border: none;
    background: transparent;
    color: #858796;
    font-weight: 700;
    padding: 10px;
    border-radius: 12px;
    transition: all 0.3s;
}

.btn-segmented.active {
    background: white;
    color: #4e73df;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.student-tab-content {
    min-height: 250px;
}

.hover-lift { transition: transform 0.2s, box-shadow 0.2s; }
.hover-lift:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>

<script>
function switchStudentTab(tab) {
    // Botones
    document.getElementById('btn-tab-personal').classList.remove('active');
    document.getElementById('btn-tab-parent').classList.remove('active');
    
    // Contenidos
    document.getElementById('content-tab-personal').classList.add('d-none');
    document.getElementById('content-tab-parent').classList.add('d-none');
    
    if(tab === 'personal') {
        document.getElementById('btn-tab-personal').classList.add('active');
        document.getElementById('content-tab-personal').classList.remove('d-none');
    } else {
        document.getElementById('btn-tab-parent').classList.add('active');
        document.getElementById('content-tab-parent').classList.remove('d-none');
    }
}
</script>
