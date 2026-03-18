<div class="modal fade animate__animated animate__fadeInDown" id="modalEditEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalLabelEdit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 bg-gradient-orange">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalLabelEdit" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-user-edit mr-2"></i> ACTUALIZAR DATOS DEL ESTUDIANTE
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formEditEstudiante" method="POST" class="form-premium" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3" style="background-color: #fdfcfb;">
                    <div class="row align-items-center mb-0">
                        <div class="col-md-3 text-center mb-3">
                            <div class="image-upload-wrapper-edit mx-auto">
                                <div id="editImagePreview"></div>
                                <label for="edit_foto" class="btn-upload-edit shadow-sm"><i class="fas fa-camera"></i></label>
                                <input type="file" name="fotoEstudiante" id="edit_foto" class="d-none" accept="image/*">
                            </div>
                            <p class="edit-label mt-2 text-center" style="font-size: 0.65rem;">Foto del Estudiante</p>
                        </div>
                        <div class="col-md-9 border-left">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="edit-label">Nombres <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-user icon"></i>
                                        <input type="text" name="nombreEstudiante" id="edit_nombre" class="form-control form-control-sm" placeholder="Ej: Juan Antonio" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="edit-label">Apellidos <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-user-tag icon"></i>
                                        <input type="text" name="apellidoEstudiante" id="edit_apellido" class="form-control form-control-sm" placeholder="Ej: Perez Garcia" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-2 mt-1">
                                    <label class="edit-label">DNI <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-id-card icon"></i>
                                        <input type="text" name="dniEstudiante" id="edit_dni" maxlength="8" class="form-control form-control-sm" placeholder="8 dígitos" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-2 mt-1">
                                    <label class="edit-label">Género <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-venus-mars icon"></i>
                                        <select name="generoEstudiante" id="edit_genero" class="form-control form-control-sm" required>
                                            <option value="" disabled selected>Seleccione...</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-2 mt-1">
                                    <label class="edit-label">F. Nacimiento <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-calendar-alt icon"></i>
                                        <input type="date" name="fechaNacimientoEstudiante" id="edit_fecha_nacimiento" class="form-control form-control-sm" required max="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-2 mt-1">
                                    <label class="edit-label">Celular <span class="text-muted">(Opcional o 'Ninguno')</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-phone icon"></i>
                                        <input type="text" name="celularEstudiante" id="edit_celular" class="form-control form-control-sm" placeholder="Ej: 987654321"
                                            maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9)">
                                    </div>
                                </div>
                                <div class="col-md-8 form-group mb-2 mt-1">
                                    <label class="edit-label">Correo <span class="text-muted">(Opcional o 'Ninguno')</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-envelope icon"></i>
                                        <input type="text" name="correoEstudiante" id="edit_correo" class="form-control form-control-sm" placeholder="Email o 'Ninguno'">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group mb-2 mt-1">
                                    <label class="edit-label">Dirección <span class="text-danger">*</span></label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-map-marker-alt icon"></i>
                                        <input type="text" name="direccionEstudiante" id="edit_direccion" class="form-control form-control-sm" placeholder="Av. Siempre Viva 123..." required>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group mb-2 mt-1">
                                    <label class="edit-label">Apoderado</label>
                                    <div class="input-group-edit-sm">
                                        <i class="fas fa-user-shield icon"></i>
                                        <select name="padreFamiliaID" id="edit_apoderado" class="form-control form-control-sm" style="width: 100%;">
                                            <option value="">-- Seleccione un apoderado --</option>
                                            @foreach($padres as $p)
                                                <option value="{{ $p->idPadreFamilia }}">
                                                    {{ $p->dniPadreFamilia }} | {{ $p->nombrePadreFamilia }} {{ $p->apellidoPadreFamilia }}
                                                </option>
                                            @endforeach
                                        </select>
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
@push('js')
<script>
    $(document).ready(function() {
        // Preview de imagen en edición
        $('#edit_foto').on('change', function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#editImagePreview').css({
                        'background-image': 'url(' + event.target.result + ')',
                        'background-size': 'cover',
                        'background-position': 'center'
                    });
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush

<style>
.image-upload-wrapper-edit {
    width: 120px;
    height: 120px;
    position: relative;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    background-color: #f8f9fc;
}

#editImagePreview {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-image: url('{{ asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}');
}

.btn-upload-edit {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.3s;
    border: 2px solid #fff;
}

.btn-upload-edit:hover { 
    transform: scale(1.1);
    color: white;
}

.border-left {
    border-left: 1px solid #e3e6f0 !important;
}

.edit-label {
    font-size: 0.75rem;
    font-weight: 800;
    color: #c18109;
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
    color: #ffd000; 
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

.modal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: transform 0.3s ease-out;
}
.modal.show .modal-dialog {
    transform: none;
}
</style>
