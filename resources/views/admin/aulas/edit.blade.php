{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEditAula" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-info text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-pencil-alt mr-2"></i>Editar Aula</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditAula" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold"><i class="fas fa-door-open mr-1 text-info"></i> Nombre del Aula</label>
                        <input type="text" name="nombreAula" id="editNombre" class="form-control form-control-lg border-0 bg-light rounded-pill" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold"><i class="fas fa-users mr-1 text-info"></i> Capacidad</label>
                        <input type="number" name="capacidadAula" id="editCapacidad" class="form-control form-control-lg border-0 bg-light rounded-pill" required min="1">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fas fa-toggle-on mr-1 text-info"></i> Estado</label>
                        <select name="estadoAula" id="editEstado" class="form-control form-control-lg border-0 bg-light rounded-pill" required>
                            <option value="Disponible">Disponible</option>
                            <option value="Ocupado">Ocupado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white rounded-pill px-4 shadow-sm">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
