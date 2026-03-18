<!-- Modal Create Formación Académica -->
<div class="modal fade" id="modalCreateFormacion" tabindex="-1" aria-labelledby="modalCreateFormacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-gradient-blue text-white" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold d-flex align-items-center" id="modalCreateFormacionLabel">
                    <i class="fas fa-graduation-cap mr-2" style="font-size: 1.5rem;"></i> 
                    Agregar Nueva Formación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('admin.formacionAcademica.store', $personal->idPersonal) }}" method="POST" enctype="multipart/form-data" id="formCreateFormacion">
                @csrf
                <div class="modal-body p-4 bg-light">
                    <p class="text-muted mb-4 small">
                        Ingrese los detalles del grado, título, diplomado o curso obtenido por <strong>{{ $personal->nombrePersonal }} {{ $personal->apellidoPersonal }}</strong>.
                    </p>

                    <div class="row">
                        <!-- Nivel de Formación -->
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark" for="nivelFormacionAcademica" style="font-size: 0.9rem;">
                                Nivel de Formación <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-layer-group text-primary"></i>
                                    </span>
                                </div>
                                <select name="nivelFormacionAcademica" id="nivelFormacionAcademica" class="form-control border-left-0 shadow-sm custom-select" style="border-radius: 0 10px 10px 0;" required>
                                    <option value="" disabled selected>Seleccione el nivel...</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="Técnico Básico">Técnico Básico</option>
                                    <option value="Técnico Auxiliar">Técnico Auxiliar</option>
                                    <option value="Técnico Medio">Técnico Medio</option>
                                    <option value="Técnico Superior">Técnico Superior</option>
                                    <option value="Bachiller">Bachiller / Egresado</option>
                                    <option value="Licenciatura">Licenciatura / Título</option>
                                    <option value="Diplomado">Diplomado</option>
                                    <option value="Especialización">Especialización</option>
                                    <option value="Maestría">Maestría / Magíster</option>
                                    <option value="Doctorado">Doctorado</option>
                                    <option value="Curso/Seminario">Curso / Seminario</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <!-- Año de Obtención -->
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark" for="anioFormacionAcademica" style="font-size: 0.9rem;">
                                Año de Finalización <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </span>
                                </div>
                                <input type="number" name="anioFormacionAcademica" id="anioFormacionAcademica" class="form-control border-left-0 shadow-sm" placeholder="Ej: {{ date('Y') }}" min="1950" max="{{ date('Y') + 1 }}" style="border-radius: 0 10px 10px 0;" required>
                            </div>
                        </div>

                        <!-- Título Obtenido -->
                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold text-dark" for="tituloFormacionAcademica" style="font-size: 0.9rem;">
                                Título o Nombre del Estudio <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-certificate text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" name="tituloFormacionAcademica" id="tituloFormacionAcademica" class="form-control border-left-0 shadow-sm" placeholder="Ej: Licenciatura en Ciencias de la Educación" style="border-radius: 0 10px 10px 0;" required>
                            </div>
                        </div>

                        <!-- Institución -->
                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold text-dark" for="institucionFormacionAcademica" style="font-size: 0.9rem;">
                                Institución Educativa <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-university text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" name="institucionFormacionAcademica" id="institucionFormacionAcademica" class="form-control border-left-0 shadow-sm" placeholder="Ej: Universidad Mayor de San Andrés" style="border-radius: 0 10px 10px 0;" required>
                            </div>
                        </div>

                        <!-- Archivo Adjunto -->
                        <div class="col-md-12 mt-2">
                            <label class="font-weight-bold text-dark" for="archivoFormacionAcademica" style="font-size: 0.9rem;">
                                Documento Adjunto (Certificado, Título) <span class="text-muted font-weight-normal small">(Opcional)</span>
                            </label>
                            <div class="custom-file shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <input type="file" class="custom-file-input" id="archivoFormacionAcademica" name="archivoFormacionAcademica" accept=".pdf,image/*">
                                <label class="custom-file-label" for="archivoFormacionAcademica" data-browse="Elegir Archivo">Seleccionar archivo en PDF o Imagen...</label>
                            </div>
                            <small class="form-text text-muted mt-2">Formatos permitidos: PDF, JPG, PNG. Tamaño máximo: 5MB.</small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-white" style="border-top: 1px solid #f1f3f9; border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm hover-lift" data-dismiss="modal" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-custom px-4 shadow-sm hover-lift" style="border-radius: 10px;">
                        <i class="fas fa-save mr-2"></i> Guardar Formación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar nombre del archivo seleccionado
        const fileInput = document.getElementById('archivoFormacionAcademica');
        if(fileInput) {
            fileInput.addEventListener('change', function(e) {
                var fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo en PDF o Imagen...';
                var label = e.target.nextElementSibling;
                label.innerText = fileName;
                label.style.color = '#4e73df';
                label.style.fontWeight = '600';
            });
        }
    });
</script>

<style>
/* Add the necessary gradient blue back for the modal header if not globally available */
.bg-gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important; }
.custom-file-label::after { background-color: #f8f9fc !important; color: #4e73df !important; font-weight: bold !important; content: "Explorar" !important; }
.custom-file-input:focus ~ .custom-file-label { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25); }
</style>
