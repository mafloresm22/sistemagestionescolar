<!-- Modal para crear nuevo curso -->
<div class="modal fade" id="modalCrearCurso" tabindex="-1" role="dialog" aria-labelledby="modalCrearCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content custom-modal-curso-animation" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white p-4" style="border-bottom: none;">
                <h5 class="modal-title font-weight-bold" id="modalCrearCursoLabel">
                    <i class="fas fa-bookmark mr-2"></i>Crear Nuevo Curso
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.cursos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Nivel Educativo (Padre) -->
                        <div class="col-md-6 mb-3">
                            <label for="nivelID_select" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-layer-group mr-1"></i> Nivel Educativo <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-primary">
                                        <i class="fas fa-university"></i>
                                    </span>
                                </div>
                                @php $niveles = \App\Models\Niveles::all(); @endphp
                                <select name="nivelID" id="nivelID" class="form-control border-0" required style="font-size: 1.1rem; font-weight: 500;">
                                    <option value="" disabled selected>Seleccione un nivel...</option>
                                    @foreach($niveles as $nivel)
                                        <option value="{{ $nivel->id }}">{{ $nivel->nombreNivel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Grado (Filtrado por Nivel) -->
                        <div class="col-md-6 mb-3">
                            <label for="gradoID" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-graduation-cap mr-1"></i> Grado Relacionado <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-primary">
                                        <i class="fas fa-list-ol"></i>
                                    </span>
                                </div>
                                <select name="gradoID" id="gradoID" class="form-control border-0 @error('gradoID') is-invalid @enderror" required disabled style="font-size: 1.1rem; font-weight: 500;">
                                    <option value="" disabled selected>Primero elija un nivel...</option>
                                </select>
                            </div>
                            <small class="text-info font-weight-bold" id="info-bulk-create" style="display:none;">
                                <i class="fas fa-info-circle mr-1"></i> Se creará el curso para TODOS los grados del nivel.
                            </small>
                        </div>

                        <!-- Código del Curso -->
                        <div class="col-md-6 mb-3">
                            <label for="codigoCurso" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-barcode mr-1"></i> Código Referencial
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-primary">
                                        <i class="fas fa-magic"></i>
                                    </span>
                                </div>
                                <input type="text" name="codigoCurso" id="codigoCurso" class="form-control border-0" 
                                    placeholder="Auto-generado" readonly style="font-size: 1.1rem; font-weight: 500; background-color: #f8f9fa;">
                            </div>
                        </div>

                        <!-- Nombre del Curso -->
                        <div class="col-md-6 mb-3">
                            <label for="nombreCurso" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-font mr-1"></i> Nombre del Curso <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-primary">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                </div>
                                <input type="text" name="nombreCurso" id="nombreCurso" class="form-control border-0 @error('nombreCurso') is-invalid @enderror" 
                                    placeholder="Ej: Matemáticas" required value="{{ old('nombreCurso') }}" style="font-size: 1.1rem; font-weight: 500;">
                            </div>
                        </div>

                        <!-- Descripción del Curso -->
                        <div class="col-md-12 mb-3">
                            <label for="descripcionCurso" class="text-secondary font-weight-bold mb-2">
                                <i class="fas fa-align-left mr-1"></i> Descripción del Curso
                            </label>
                            <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #e9ecef;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-primary align-items-start pt-3">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </div>
                                <textarea name="descripcionCurso" id="descripcionCurso" class="form-control border-0 @error('descripcionCurso') is-invalid @enderror" 
                                    placeholder="Breve descripción del curso..." rows="2" style="font-size: 1.1rem; font-weight: 500; resize: none;">{{ old('descripcionCurso') }}</textarea>
                            </div>
                        </div>

                        <!-- Estado -->
                        <input type="hidden" name="estado" value="Activo">
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3" style="border-radius: 12px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light p-4" style="border-top: none;">
                    <button type="button" class="btn btn-danger px-4 shadow-sm" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm btn-save-curso" style="border-radius: 10px; font-weight: 600; transition: all 0.3s; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;">
                        <i class="fas fa-save mr-1"></i> Guardar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nivelSelect = document.getElementById('nivelID');
    const gradoSelect = document.getElementById('gradoID');
    const infoBulk = document.getElementById('info-bulk-create');

    // Todos los grados disponibles (desde PHP)
    const allGrados = @json(\App\Models\Grados::all());

    if (nivelSelect && gradoSelect) {
        nivelSelect.addEventListener('change', function() {
            const nivelId = this.value;
            gradoSelect.innerHTML = '<option value="" disabled selected>Seleccione un grado...</option>';
            
            // Agregar opción especial "TODOS"
            gradoSelect.innerHTML += `<option value="all" style="color: #2a51be; font-weight: bold; background: #e9ecef;">⭐️ TODOS LOS GRADOS DE ESTE NIVEL</option>`;
            
            // Filtrar grados del nivel
            const filtrados = allGrados.filter(g => g.nivelID == nivelId);
            filtrados.forEach(g => {
                gradoSelect.innerHTML += `<option value="${g.id}">${g.nombreGrado}</option>`;
            });

            gradoSelect.disabled = false;
        });

        gradoSelect.addEventListener('change', function() {
            if (this.value === 'all') {
                if (infoBulk) infoBulk.style.display = 'block';
                document.getElementById('codigoCurso').placeholder = 'Varios códigos';
            } else {
                if (infoBulk) infoBulk.style.display = 'none';
                document.getElementById('codigoCurso').placeholder = 'Auto-generado';
            }
        });
    }
});
</script>

<style>
    .custom-modal-curso-animation {
        animation: modalEntranceCurso 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalEntranceCurso {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .input-group:focus-within {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15) !important;
    }

    .btn-save-curso:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3) !important;
    }

    .form-control::placeholder {
        color: #adb5bd;
        opacity: 0.7;
    }
</style>
