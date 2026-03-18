{{-- Modal de Creación Premium - Diseño Compacto para Apoderados --}}
<div class="modal fade animate__animated animate__fadeInDown" id="modalCreatePadre" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 bg-gradient-info">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalLabel" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-user-shield mr-2"></i> REGISTRO DE APODERADO
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('admin.padres.store') }}" method="POST" class="form-premium">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="row align-items-center mb-0">
                        {{-- Sección: Datos del Apoderado --}}
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="small-label">Nombres <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-user icon"></i>
                                        <input type="text" name="nombrePadreFamilia" class="form-control form-control-sm" placeholder="Ej: Juan Antonio" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="small-label">Apellidos <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-user-tag icon"></i>
                                        <input type="text" name="apellidoPadreFamilia" class="form-control form-control-sm" placeholder="Ej: Perez Garcia" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="small-label">DNI <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-id-card icon"></i>
                                        <input type="text" name="dniPadreFamilia" maxlength="8" class="form-control form-control-sm" placeholder="8 dígitos" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="small-label">Género <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-venus-mars icon"></i>
                                        <select name="generoPadreFamilia" class="form-control form-control-sm" required>
                                            <option value="" disabled selected>Seleccione...</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="small-label">F. Nacimiento <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-calendar-alt icon"></i>
                                        <input type="date" name="fechaNacimientoPadreFamilia" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="small-label">Celular <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-phone icon"></i>
                                        <input type="text" name="celularPadreFamilia" maxlength="9" class="form-control form-control-sm" placeholder="987654321" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2 mt-1">
                                    <label class="small-label">Correo Electrónico (Opcional)</label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-envelope icon"></i>
                                        <input type="text" name="correoPadreFamilia" class="form-control form-control-sm" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2 mt-1">
                                    <label class="small-label">Dirección <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-map-marker-alt icon"></i>
                                        <input type="text" name="direccionPadreFamilia" class="form-control form-control-sm" placeholder="Av. Siempre Viva 123..." required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light py-3 justify-content-center border-0">
                    <button type="button" class="btn btn-danger px-4 py-2 shadow hover-lift mr-3" data-dismiss="modal" style="font-weight: 700; border-radius: 12px;">
                        <i class="fas fa-times-circle mr-2"></i> CANCELAR
                    </button>
                    <button type="submit" class="btn btn-info-custom px-5 py-2 shadow hover-lift" style="border-radius: 12px; font-weight: 700;">
                        <i class="fas fa-save mr-2"></i> GUARDAR REGISTRO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* --- ESTILOS COMPACTOS PREMIUM --- */
.small-label {
    font-size: 0.75rem;
    font-weight: 800;
    color: #4e5e7a;
    margin-bottom: 4px;
    margin-left: 2px;
    display: block;
    text-transform: uppercase;
}

.input-group-premium-sm { position: relative; display: flex; align-items: center; }
.input-group-premium-sm .icon { position: absolute; left: 12px; color: #b7b9cc; font-size: 0.8rem; z-index: 10; }
.input-group-premium-sm .form-control-sm { 
    padding-left: 35px; 
    height: 38px; 
    border-radius: 10px; 
    border: 1.5px solid #eaecf4; 
    font-weight: 600; 
    color: #5a5c69;
}
.input-group-premium-sm .form-control-sm:focus { 
    border-color: #17a2b8; 
    box-shadow: 0 0 8px rgba(23, 162, 184, 0.1); 
    background: #fff;
}

.modal-content { border-radius: 20px !important; }
.modal-header { border-bottom: none; }
.modal-footer { border-top: none; }

.bg-gradient-info { background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); }

.btn-info-custom { background: #17a2b8; border: none; color: white; }
.hover-lift { transition: all 0.2s ease; }
.hover-lift:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>
