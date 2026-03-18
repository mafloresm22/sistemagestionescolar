{{-- Modal de Creación Premium - Diseño Compacto con Foto --}}
<div class="modal fade animate__animated animate__fadeInDown" id="modalCreatePersonal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 {{ strtolower($tipoPersonal) == 'docente' ? 'bg-gradient-blue' : 'bg-premium-orange' }}">
                <h5 class="modal-title font-weight-bold text-white w-100 text-center" id="modalLabel" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                    <i class="fas fa-id-card-alt mr-2"></i> REGISTRO DE {{ strtoupper($tipoPersonal) }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('admin.personal.store', $tipoPersonal) }}" method="POST" class="form-premium" enctype="multipart/form-data">
                @csrf
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
                                    <input type='file' name="fotoPersonal" id="imageUpload" accept=".png, .jpg, .jpeg" onchange="previewImage(this);" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview shadow-sm" style="border: 3px solid {{ strtolower($tipoPersonal) == 'docente' ? '#4e73df' : '#fd7e14' }};">
                                    <div id="imagePreview" style="background-image: url('{{ asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}');">
                                    </div>
                                </div>
                                <span class="small font-weight-bold text-muted mt-2 d-block">Subir Foto</span>
                            </div>
                        </div>

                        {{-- Sección: Datos Personales Principales --}}
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="small-label">Nombres <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-user icon"></i>
                                        <input type="text" name="nombrePersonal" class="form-control form-control-sm" placeholder="Ej: Alberto" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="small-label">Apellidos <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-user-tag icon"></i>
                                        <input type="text" name="apellidoPersonal" class="form-control form-control-sm" placeholder="Ej: García Salas" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-2 mt-1">
                                    <label class="small-label">DNI <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-id-card icon"></i>
                                        <input type="text" name="dniPersonal" maxlength="8" class="form-control form-control-sm" placeholder="8 dígitos" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-2 mt-1">
                                    <label class="small-label">Especialidad / Cargo</label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-graduation-cap icon"></i>
                                        <input type="text" name="profesionPersonal" class="form-control form-control-sm" placeholder="Ej: {{ $tipoPersonal == 'docente' ? 'Profesor' : 'Administrativo' }}">
                                    </div>
                                </div>
                                <div class="col-md-5 form-group mb-2 mt-1">
                                    <label class="small-label">Email Personal <span class="text-danger">*</span></label>
                                    <div class="input-group-premium-sm">
                                        <i class="fas fa-envelope icon"></i>
                                        <input type="email" name="emailPersonal" class="form-control form-control-sm" placeholder="usuario@correo.com" required>
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
                                <select name="generoPersonal" class="form-control form-control-sm" required>
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
                                <input type="date" name="fechaNacimientoPersonal" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-3 form-group mb-2 mt-1">
                            <label class="small-label">Celular</label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-phone icon"></i>
                                <input type="text" name="celularPersonal" maxlength="9" class="form-control form-control-sm" placeholder="987654321">
                            </div>
                        </div>

                        <div class="col-md-3 form-group mb-2 mt-1">
                            <label class="small-label">Rol del Sistema <span class="text-danger">*</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-user-shield icon"></i>
                                <select name="role" class="form-control form-control-sm" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ strtoupper($role->name) == strtoupper($tipoPersonal) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group mb-2 mt-1">
                            <label class="small-label">Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-lock icon"></i>
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Mínimo 8 caracteres" required>
                            </div>
                        </div>

                        <div class="col-md-6 form-group mb-2 mt-1">
                            <label class="small-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group-premium-sm">
                                <i class="fas fa-shield-alt icon"></i>
                                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Repita la contraseña" required>
                            </div>
                        </div>

                        <input type="hidden" name="tipoPersonal" value="{{ $tipoPersonal }}">
                        <input type="hidden" name="estadoPersonal" value="activo">
                    </div>
                </div>
                
                <div class="modal-footer bg-light py-3 justify-content-center border-0">
                    <button type="button" class="btn btn-danger px-4 py-2 shadow hover-lift mr-3" data-dismiss="modal" style="font-weight: 700; border-radius: 12px;">
                        <i class="fas fa-times-circle mr-2"></i> CANCELAR
                    </button>
                    <button type="submit" class="btn btn-primary-custom px-5 py-2 shadow hover-lift" style="border-radius: 12px; font-weight: 700;">
                        <i class="fas fa-save mr-2"></i> GUARDAR REGISTRO
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

.bg-gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
.bg-premium-orange { background: linear-gradient(135deg, #fd7e14 0%, #fb8c00 100%); }

.btn-primary-custom { background: var(--primary-blue); border: none; color: white; }
.hover-lift { transition: all 0.2s ease; }
.hover-lift:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
