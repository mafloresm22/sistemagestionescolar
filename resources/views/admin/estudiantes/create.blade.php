<div class="modal fade" id="modalCreateEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalCreateEstudianteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            {{-- Header --}}
            <div class="modal-header bg-gradient-primary text-white py-4 px-5">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-white-50 mr-3">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h4 class="modal-title font-weight-bold mb-0" id="modalCreateEstudianteLabel">Registro de Nuevo Estudiante</h4>
                        <p class="mb-0 opacity-8 small">Complete los pasos para dar de alta a un estudiante en el sistema.</p>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-0">
                <div class="row no-gutters">
                    {{-- Stepper Sidebar (Opcional, pero da un toque profesional) --}}
                    <div class="col-md-3 bg-light border-right p-4 d-none d-md-block" style="min-height: 450px;">
                        <div class="stepper-vertical">
                            <div class="step-item active" id="step-1-indicator">
                                <div class="step-icon">1</div>
                                <div class="step-content">
                                    <div class="step-title">Apoderado</div>
                                    <div class="step-desc">Vincular padre/tutor</div>
                                </div>
                            </div>
                            <div class="step-item" id="step-2-indicator">
                                <div class="step-icon">2</div>
                                <div class="step-content">
                                    <div class="step-title">Estudiante</div>
                                    <div class="step-desc">Datos personales</div>
                                </div>
                            </div>
                            <div class="step-item" id="step-3-indicator">
                                <div class="step-icon">3</div>
                                <div class="step-content">
                                    <div class="step-title">Finalizar</div>
                                    <div class="step-desc">Revisión y guardado</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Content --}}
                    <div class="col-md-9 p-4 d-flex flex-column justify-content-between" style="min-height: 450px;">
                        <form id="formCreateEstudiante" action="{{ route('admin.estudiantes.store') }}" method="POST" enctype="multipart/form-data" class="flex-grow-1 d-flex flex-column">
                            @csrf
                            {{-- PASO 1: SELECCIONAR APODERADO --}}
                            <div class="step-content-box animate__animated animate__fadeIn active" id="step-1-content">
                                <div class="section-title mb-3">
                                    <span class="badge badge-primary-soft text-primary px-3 py-1 mb-2">Paso 1</span>
                                    <h5 class="font-weight-bold mb-1">Asignación de Apoderado</h5>
                                    <p class="text-muted small mb-0">Seleccione un padre de familia existente o registre uno nuevo.</p>
                                </div>
 
                                <div class="row align-items-end">
                                    <div class="col-md-9">
                                        <div class="form-group mb-3">
                                            <label class="form-label font-weight-bold small"><i class="fas fa-search mr-1 text-primary"></i> Seleccionar Apoderado <span class="text-danger">*</span></label>
                                            <select name="padreFamiliaID" id="selectPadre" class="form-control form-control-sm" required style="width: 100%;">
                                                <option value="" disabled selected>-- Buscar por nombre o DNI --</option>
                                                @foreach($padres as $p)
                                                    <option value="{{ $p->idPadreFamilia }}" 
                                                        data-dni="{{ $p->dniPadreFamilia }}"
                                                        data-nombre="{{ $p->nombrePadreFamilia }} {{ $p->apellidoPadreFamilia }}"
                                                        data-celular="{{ $p->celularPadreFamilia ?? 'No registrado' }}"
                                                        data-correo="{{ $p->correoPadreFamilia ?? 'No registrado' }}"
                                                        data-direccion="{{ $p->direccionPadreFamilia ?? 'No especificada' }}">
                                                        {{ $p->dniPadreFamilia }} | {{ $p->nombrePadreFamilia }} {{ $p->apellidoPadreFamilia }}
                                                    </option>
                                                @endforeach
                                             </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <a href="{{ route('admin.padres.index') }}" class="btn btn-outline-primary btn-block btn-sm py-2 shadow-sm" style="border-radius: 8px;">
                                                <i class="fas fa-plus-circle mr-1"></i> Nuevo Padre
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Detalles del Apoderado Seleccionado --}}
                                <div id="padre-details-box" class="mt-2" style="display: none;">
                                    <div class="card border-0 bg-light p-3 mb-0" style="border-radius: 12px; border-left: 4px solid #4e73df !important;">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="bg-white rounded-circle p-2 shadow-sm">
                                                    <i class="fas fa-id-card text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h6 class="font-weight-bold mb-1" id="detail-padre-nombre">-</h6>
                                                <div class="row x-small text-muted">
                                                    <div class="col-md-4"><strong>DNI:</strong> <span id="detail-padre-dni">-</span></div>
                                                    <div class="col-md-4"><strong>Celular:</strong> <span id="detail-padre-celular">-</span></div>
                                                    <div class="col-md-4"><strong>Correo:</strong> <span id="detail-padre-correo">-</span></div>
                                                    <div class="col-12 mt-1"><strong>Dirección:</strong> <span id="detail-padre-direccion">-</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
 
                                <div class="mt-auto d-flex justify-content-end pt-3">
                                    <button type="button" class="btn btn-primary px-4 py-2 shadow-sm btn-sm" onclick="nextStep(2)">
                                        Siguiente Paso <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- PASO 2: DATOS DEL ESTUDIANTE --}}
                            <div class="step-content-box animate__animated animate__fadeIn" id="step-2-content" style="display: none;">
                                <div class="section-title mb-3">
                                    <span class="badge badge-primary-soft text-primary px-3 py-1 mb-2">Paso 2</span>
                                    <h5 class="font-weight-bold mb-1">Información del Estudiante</h5>
                                    <p class="text-muted small mb-0">Ingrese los datos personales y de contacto del alumno.</p>
                                </div>

                                <div class="row align-items-start">
                                    {{-- Foto --}}
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="image-upload-wrapper mx-auto" style="width: 130px; height: 130px;">
                                            <div id="imagePreview" style="background-image: url('{{ asset('vendor/adminlte/dist/img/user_icon-icons.com_66546.png') }}');"></div>
                                            <label for="fotoEstudiante" class="btn-upload shadow-sm"><i class="fas fa-camera"></i></label>
                                            <input type="file" name="fotoEstudiante" id="fotoEstudiante" class="d-none" accept="image/*">
                                        </div>
                                        <p class="text-muted mt-2 x-small mb-0">Foto del Estudiante</p>
                                    </div>

                                    {{-- Campos Principales --}}
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label font-weight-bold small">Nombres <span class="text-danger">*</span></label>
                                                <input type="text" name="nombreEstudiante" class="form-control form-control-sm" required placeholder="Nombres">
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label font-weight-bold small">Apellidos <span class="text-danger">*</span></label>
                                                <input type="text" name="apellidoEstudiante" class="form-control form-control-sm" required placeholder="Apellidos">
                                            </div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label class="form-label font-weight-bold small">DNI <span class="text-danger">*</span></label>
                                                <input type="text" name="dniEstudiante" class="form-control form-control-sm" required placeholder="DNI" 
                                                    maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8)">
                                            </div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label class="form-label font-weight-bold small">F. Nacimiento <span class="text-danger">*</span></label>
                                                <input type="date" name="fechaNacimientoEstudiante" class="form-control form-control-sm" required max="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label class="form-label font-weight-bold small">Género</label>
                                                <select name="generoEstudiante" class="form-control form-control-sm" required>
                                                    <option value="" disabled selected>Seleccionar...</option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Contacto y Dirección --}}
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="form-label font-weight-bold small">Celular <span class="text-muted">(Opcional o 'Ninguno')</span></label>
                                        <input type="text" name="celularEstudiante" class="form-control form-control-sm" placeholder="Ej: 987654321" 
                                            maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9)">
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="form-label font-weight-bold small">Correo <span class="text-muted">(Opcional o 'Ninguno')</span></label>
                                        <input type="text" name="correoEstudiante" class="form-control form-control-sm" placeholder="estudiante@ejemplo.com">
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label class="form-label font-weight-bold small">Dirección de Domicilio</label>
                                        <textarea name="direccionEstudiante" class="form-control form-control-sm" rows="1" placeholder="Dirección completa..."></textarea>
                                    </div>
                                </div>

                                <div class="mt-auto d-flex justify-content-between pt-3">
                                    <button type="button" class="btn btn-light px-3 py-2 text-muted btn-sm" onclick="nextStep(1)">
                                        <i class="fas fa-arrow-left mr-2"></i> Anterior
                                    </button>
                                    <button type="button" class="btn btn-primary px-4 py-2 shadow-sm btn-sm" onclick="nextStep(3)">
                                        Continuar <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- PASO 3: CONFIRMACIÓN --}}
                            <div class="step-content-box animate__animated animate__fadeIn" id="step-3-content" style="display: none;">
                                <div class="text-center py-2">
                                    <div class="check-animation mb-2 mx-auto">
                                        <i class="fas fa-check-circle text-success fa-3x shadow-pulse"></i>
                                    </div>
                                    <h5 class="font-weight-bold mb-1">¡Todo listo para registrar!</h5>
                                    <p class="text-muted small mb-0">Verifique que los datos sean correctos antes de guardar.</p>
                                    
                                    <div class="card bg-light border-0 mt-3 text-left p-3" style="border-radius: 12px;">
                                        <h6 class="font-weight-bold border-bottom pb-1 mb-2 small">Resumen del Estudiante</h6>
                                        <div class="row x-small">
                                            <div class="col-6 mb-1"><strong>DNI:</strong> <span id="review-dni">-</span></div>
                                            <div class="col-6 mb-1"><strong>Nombre:</strong> <span id="review-nombre">-</span></div>
                                            <div class="col-6 mb-1"><strong>Apoderado:</strong> <span id="review-apoderado">-</span></div>
                                            <div class="col-6 mb-1"><strong>Estado:</strong> <span class="badge badge-success" style="font-size: 0.7rem;">ACTIVO</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto d-flex justify-content-between pt-3">
                                    <button type="button" class="btn btn-light px-3 py-2 text-muted btn-sm" onclick="nextStep(2)">
                                        <i class="fas fa-arrow-left mr-1"></i> Corregir
                                    </button>
                                    <button type="submit" class="btn btn-success px-4 py-2 shadow-lg btn-sm">
                                        <i class="fas fa-save mr-1"></i> Guardar Registro Final
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Diseño del Header */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
    }

    /* Stepper Lateral */
    .stepper-vertical {
        list-style: none;
        padding: 0;
    }

    .step-item {
        position: relative;
        display: flex;
        align-items: flex-start;
        margin-bottom: 30px;
        opacity: 0.5;
        transition: all 0.3s;
    }

    .step-item.active {
        opacity: 1;
        transform: scale(1.05);
    }

    .step-item.active .step-icon {
        background: #4e73df;
        color: white;
        box-shadow: 0 0 10px rgba(78, 115, 223, 0.5);
    }

    .step-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #eaecf4;
        color: #858796;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
        z-index: 2;
    }

    .step-title {
        font-weight: 700;
        font-size: 0.9rem;
        color: #2e3b4e;
    }

    .step-desc {
        font-size: 0.75rem;
        color: #858796;
    }

    .step-item:not(:last-child):after {
        content: '';
        position: absolute;
        left: 17px;
        top: 35px;
        width: 2px;
        height: calc(100% - 5px);
        background: #eaecf4;
    }

    /* Estabilidad de Steps */
    .step-content-box {
        display: none;
        flex-direction: column;
        height: 100%;
        flex-grow: 1;
    }
    .step-content-box.active {
        display: flex !important;
    }

    /* Subida de Imagen */
    .image-upload-wrapper {
        width: 150px;
        height: 150px;
        position: relative;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    #imagePreview {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
    }

    .btn-upload {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 35px;
        height: 35px;
        background: #4e73df;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-upload:hover { background: #224abe; }

    /* Miscelanea */
    .badge-primary-soft { background: #eef2ff; color: #4e73df; }
    .shadow-pulse { animation: shadow-pulse-anim 2s infinite; border-radius: 50%; }
    
    @keyframes shadow-pulse-anim {
        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }

    .modal-xxl { max-width: 90% !important; }
    .x-small { font-size: 0.75rem; }

    /* Estilos de respaldo para Select2 */
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.5 em + 0.75 rem + 2 px) !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25 rem !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding: 5px 10px !important;
        line-height: normal !important;
    }
</style>

@push('js')
<script>
    function nextStep(step) {
        // Validación Paso 1 -> Paso 2
        if (step === 2) {
            const padreId = $('#selectPadre').val();
            if (!padreId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe seleccionar un apoderado antes de continuar.',
                    confirmButtonColor: '#4e73df'
                });
                return;
            }
        }

        // Validación Paso 2 -> Paso 3
        if (step === 3) {
            const form = document.getElementById('formCreateEstudiante');
            if (form.nombreEstudiante.value == "" || form.apellidoEstudiante.value == "" || form.dniEstudiante.value == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete los campos obligatorios (*).',
                    confirmButtonColor: '#4e73df'
                });
                return;
            }
        }

        // Ocultar todos
        $('.step-content-box').removeClass('active');
        $('.step-item').removeClass('active');
        
        // Mostrar actual
        $(`#step-${step}-content`).addClass('active');
        $(`#step-${step}-indicator`).addClass('active');

        // Llenar resumen en el último paso
        if (step === 3) {
            $('#review-dni').text($('input[name="dniEstudiante"]').val() || '-');
            $('#review-nombre').text($('input[name="nombreEstudiante"]').val() + ' ' + $('input[name="apellidoEstudiante"]').val());
            
            let padreText = $("#selectPadre option:selected").text();
            $('#review-apoderado').text(padreText);
        }
    }

    $(document).ready(function() {
        // Preview de imagen
        $("#fotoEstudiante").change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview').css('background-image', 'url(' + event.target.result + ')');
                }
                reader.readAsDataURL(file);
            }
        });

        // Evento cambio de apoderado
        $("#selectPadre").change(function() {
            const selected = $(this).find('option:selected');
            if (selected.val()) {
                $('#detail-padre-nombre').text(selected.data('nombre'));
                $('#detail-padre-dni').text(selected.data('dni'));
                $('#detail-padre-celular').text(selected.data('celular'));
                $('#detail-padre-correo').text(selected.data('correo'));
                $('#detail-padre-direccion').text(selected.data('direccion'));
                $('#padre-details-box').fadeIn();
            } else {
                $('#padre-details-box').hide();
            }
        });
    });
</script>
@endpush
