<div class="modal fade animate__animated animate__fadeInDown" id="modalEditPadre" tabindex="-1" role="dialog" aria-labelledby="modalLabelEdit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 bg-gradient-orange">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalLabelEdit" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-user-edit mr-2"></i> ACTUALIZAR DATOS DEL APODERADO
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formEditPadre" method="POST" class="form-premium">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3" style="background-color: #fdfcfb;">
                    <div class="row align-items-center mb-0">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="edit-label">Nombres <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-user icon"></i>
                                        <input type="text" name="nombrePadreFamilia" id="edit_nombre" class="form-control form-control-sm" placeholder="Ej: Juan Antonio" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="edit-label">Apellidos <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-user-tag icon"></i>
                                        <input type="text" name="apellidoPadreFamilia" id="edit_apellido" class="form-control form-control-sm" placeholder="Ej: Perez Garcia" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="edit-label">DNI <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-id-card icon"></i>
                                        <input type="text" name="dniPadreFamilia" id="edit_dni" maxlength="8" class="form-control form-control-sm" placeholder="8 dígitos" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="edit-label">Género <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-venus-mars icon"></i>
                                        <select name="generoPadreFamilia" id="edit_genero" class="form-control form-control-sm" required>
                                            <option value="" disabled selected>Seleccione...</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="edit-label">F. Nacimiento <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-calendar-alt icon"></i>
                                        <input type="date" name="fechaNacimientoPadreFamilia" id="edit_fecha_nacimiento" class="form-control form-control-sm" required>
                                    </div>
                                </div>

                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="edit-label">Celular <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-phone icon"></i>
                                        <input type="text" name="celularPadreFamilia" id="edit_celular" maxlength="9" class="form-control form-control-sm" placeholder="987654321" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2 mt-1">
                                    <label class="edit-label">Correo Electrónico</label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-envelope icon"></i>
                                        <input type="text" name="correoPadreFamilia" id="edit_correo" class="form-control form-control-sm" placeholder="Email o 'Ninguno'">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2 mt-1">
                                    <label class="edit-label">Dirección <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-map-marker-alt icon"></i>
                                        <input type="text" name="direccionPadreFamilia" id="edit_direccion" class="form-control form-control-sm" placeholder="Av. Siempre Viva 123..." required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light py-3 justify-content-center border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-danger px-4 py-2 shadow hover-lift mr-3" data-dismiss="modal" style="font-weight: 700; border-radius: 12px;">
                        <i class="fas fa-times-circle mr-2"></i> CANCELAR
                    </button>
                    <button type="submit" class="btn btn-orange-custom px-5 py-2 shadow hover-lift" style="border-radius: 12px; font-weight: 700;">
                        <i class="fas fa-sync-alt mr-2"></i> ACTUALIZAR REGISTRO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* --- ESTILOS COMPACTOS PREMIUM (MODAL EDICIÓN NARANJA) --- */
.edit-label {
    font-size: 0.75rem;
    font-weight: 800;
    color: #8a5a00; /* Tono marrón/naranja oscuro */
    margin-bottom: 4px;
    margin-left: 2px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.input-group-edit-sm { position: relative; display: flex; align-items: center; }
.input-group-edit-sm .icon { 
    position: absolute; 
    left: 12px; 
    color: #ff9800; 
    font-size: 0.85rem; 
    z-index: 10; 
    opacity: 0.7;
}

.input-group-edit-sm .form-control-sm { 
    padding-left: 38px; 
    height: 42px; 
    border-radius: 12px; 
    border: 1.5px solid #ffe0b2; 
    font-weight: 600; 
    color: #5d4037;
    background-color: #fff;
    transition: all 0.3s ease;
}

.input-group-edit-sm .form-control-sm:focus { 
    border-color: #ff9800; 
    box-shadow: 0 0 10px rgba(255, 152, 0, 0.15); 
    background-color: #fff;
    outline: none;
}

.bg-gradient-orange { 
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); 
}

.btn-orange-custom { 
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    border: none; 
    color: white; 
    box-shadow: 0 4px 10px rgba(255, 152, 0, 0.2);
}

.btn-orange-custom:hover {
    background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 152, 0, 0.3);
}

.hover-lift { transition: all 0.2s ease; }
.hover-lift:hover { transform: translateY(-2px); }

/* Animación suave para el modal */
.modal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: transform 0.3s ease-out;
}
.modal.show .modal-dialog {
    transform: none;
}
</style>
