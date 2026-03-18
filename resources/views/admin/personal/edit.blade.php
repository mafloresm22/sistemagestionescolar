{{-- Modal de Creación Premium - Diseño Compacto con Foto --}}
<div class="modal fade animate__animated animate__fadeInDown" id="modalEditPersonal" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 {{ strtolower($tipoPersonal) == 'docente' ? 'bg-gradient-teal-premium' : 'bg-gradient-purple-premium' }}">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalEditLabel" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-edit mr-2"></i> EDITAR REGISTRO DE {{ strtoupper($tipoPersonal) }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formEditPersonal" action="" method="POST" class="form-premium" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 shadow-sm" style="border-radius: 10px;">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row align-items-center mb-4">
                        {{-- Avatar / Foto Preview --}}
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="fotoPersonal" id="imageUploadEdit" accept=".png, .jpg, .jpeg" onchange="previewImageEdit(this);" />
                                    <label for="imageUploadEdit"></label>
                                </div>
                                <div class="avatar-preview shadow-sm" style="border: 3px solid {{ strtolower($tipoPersonal) == 'docente' ? '#20c997' : '#6f42c1' }};">
                                    <div id="imagePreviewEdit" style="background-image: url('{{ asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}');">
                                    </div>
                                </div>
                                <span class="small font-weight-bold text-muted mt-2 d-block">Cambiar Foto</span>
                            </div>
                        </div>

                        {{-- Sección: Datos Personales Principales --}}
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="small-label">Nombres <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-user icon"></i>
                                        <input type="text" name="nombrePersonal" id="edit_nombrePersonal" class="form-control form-control-sm" placeholder="Ej: Alberto" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="small-label">Apellidos <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-user-tag icon"></i>
                                        <input type="text" name="apellidoPersonal" id="edit_apellidoPersonal" class="form-control form-control-sm" placeholder="Ej: García Salas" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="small-label">DNI <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-id-card icon"></i>
                                        <input type="text" name="dniPersonal" id="edit_dniPersonal" maxlength="8" class="form-control form-control-sm" placeholder="8 dígitos" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-2 mt-1">
                                    <label class="small-label">Especialidad / Cargo</label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-graduation-cap icon"></i>
                                        <input type="text" name="profesionPersonal" id="edit_profesionPersonal" class="form-control form-control-sm" placeholder="Ej: {{ $tipoPersonal == 'docente' ? 'Profesor' : 'Administrativo' }}">
                                    </div>
                                </div>
                                <div class="col-md-5 form-group mb-2 mt-1">
                                    <label class="small-label">Email Personal <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-envelope icon"></i>
                                        <input type="email" name="emailPersonal" id="edit_emailPersonal" class="form-control form-control-sm" placeholder="usuario@correo.com" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group mb-2 mt-1">
                            <label class="small-label">Género <span class="text-danger">*</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-venus-mars icon"></i>
                                <select name="generoPersonal" id="edit_generoPersonal" class="form-control form-control-sm" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 form-group mb-2 mt-1">
                            <label class="small-label">F. Nacimiento <span class="text-danger">*</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-calendar-alt icon"></i>
                                <input type="date" name="fechaNacimientoPersonal" id="edit_fechaNacimientoPersonal" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-3 form-group mb-2 mt-1">
                            <label class="small-label">Celular</label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-phone icon"></i>
                                <input type="text" name="celularPersonal" id="edit_celularPersonal" maxlength="9" class="form-control form-control-sm" placeholder="987654321">
                            </div>
                        </div>

                        <div class="col-md-3 form-group mb-2 mt-1">
                            <label class="small-label">Rol del Sistema <span class="text-danger">*</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-user-shield icon"></i>
                                <select name="role" id="edit_role" class="form-control form-control-sm" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 form-group mb-2 mt-1">
                            <label class="small-label">Nueva Contraseña <span class="text-muted">(Dejar en blanco para no cambiar)</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-key icon"></i>
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Mínimo 8 caracteres">
                            </div>
                        </div>

                        <input type="hidden" name="idPersonal" id="edit_idPersonal">
                        <input type="hidden" name="tipoPersonal" value="{{ $tipoPersonal }}">
                        <input type="hidden" name="estadoPersonal" value="activo">
                    </div>
                </div>
                
                <div class="modal-footer bg-light py-3 justify-content-center border-0">
                    <button type="button" class="btn btn-danger px-4 py-2 shadow hover-lift mr-3" data-dismiss="modal" style="font-weight: 700; border-radius: 12px;">
                        <i class="fas fa-times-circle mr-2"></i> CANCELAR
                    </button>
                    <button type="submit" class="btn btn-update-custom px-5 py-2 shadow hover-lift" style="border-radius: 12px; font-weight: 700;">
                        <i class="fas fa-sync-alt mr-2"></i> ACTUALIZAR REGISTRO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* --- ESTILOS COMPACTOS PREMIUM CON FOTO --- */
.avatar-upload {
    position: relative;
    max-width: 120px;
    margin: 0 auto;
}
.avatar-upload .avatar-edit {
    position: absolute;
    right: 5px;
    z-index: 1;
    top: 5px;
}
.avatar-upload .avatar-edit input {
    display: none;
}
.avatar-upload .avatar-edit label {
    display: inline-block;
    width: 30px;
    height: 30px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid #d2d6de;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
}
.avatar-upload .avatar-edit label:after {
    content: "\f030";
    font-family: 'Font Awesome 5 Free';
    color: #757575;
    font-weight: 900;
}
.avatar-upload .avatar-edit label:hover {
    background: #f1f3f9;
    border-color: #d2d6de;
}
.avatar-upload .avatar-preview {
    width: 110px;
    height: 110px;
    position: relative;
    border-radius: 100%;
    overflow: hidden;
}
.avatar-upload .avatar-preview > div {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}

.badge-primary-soft { background: #eef2ff; padding: 6px; border-radius: 8px; }
.badge-success-soft { background: #e6fffa; padding: 6px; border-radius: 8px; }

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
    border-color: var(--primary-blue); 
    box-shadow: 0 0 8px rgba(78, 115, 223, 0.1); 
    background: #fff;
}

.modal-content { border-radius: 20px !important; }
.modal-header { border-bottom: none; }
.modal-footer { border-top: none; }

.bg-gradient-teal-premium { background: linear-gradient(135deg, #20c997 0%, #118f69 100%); }
.bg-gradient-purple-premium { background: linear-gradient(135deg, #6f42c1 0%, #462283 100%); }

.btn-update-custom { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border: none; color: white; }
.hover-lift { transition: all 0.2s ease; }
.hover-lift:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>

<script>
function previewImageEdit(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreviewEdit').css('background-image', 'url('+e.target.result +')');
            $('#imagePreviewEdit').hide();
            $('#imagePreviewEdit').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
