{{-- MODAL CREATE --}}
<div class="modal fade" id="modalCreateAula" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Nueva Aula</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.aulas.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('vendor/adminlte/dist/img/aulaImagen.webp') }}" class="rounded-circle shadow-sm border mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                        <p class="text-muted small">Registra un nuevo espacio físico</p>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold"><i class="fas fa-door-open mr-1 text-primary"></i> Nombre del Aula</label>
                        <input type="text" name="nombreAula" class="form-control form-control-lg border-0 bg-light rounded-pill" placeholder="Ej: Aula 101" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold"><i class="fas fa-users mr-1 text-primary"></i> Capacidad</label>
                        <input type="number" name="capacidadAula" class="form-control form-control-lg border-0 bg-light rounded-pill" placeholder="0" required min="1">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Guardar Aula</button>
                </div>
            </form>
        </div>
    </div>
</div>
