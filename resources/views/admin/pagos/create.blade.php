<div class="modal fade" id="modalCreatePago{{ $matriculacion->idMatriculacion }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-navy text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold" style="font-size: 1.1rem;"><i class="fas fa-cash-register mr-2"></i>Registrar Nuevo Pago</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.pagos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="font-size: 0.9rem;">
                    <input type="hidden" name="matriculacionID" value="{{ $matriculacion->idMatriculacion }}">
                    <input type="hidden" name="estadoPago" value="Pagado">
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold"><i class="fas fa-coins text-success mr-1"></i> Monto (S/.)</label>
                            <input type="number" step="0.01" name="montoPago" class="form-control border-primary form-control-sm" placeholder="0.00" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold"><i class="fas fa-calendar-alt text-info mr-1"></i> Fecha</label>
                            <input type="date" name="fechaPago" class="form-control border-primary form-control-sm" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold"><i class="fas fa-wallet text-warning mr-1"></i> Método</label>
                            <select name="metodoPago" id="metodoPago{{ $matriculacion->idMatriculacion }}" class="form-control border-primary form-control-sm" required>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                                <option value="Yape/Plin">Yape / Plin</option>
                            </select>
                        </div>
                        {{-- APARTADO DEL VOUCHER (REEMPLAZANDO AL ESTADO PAGO) --}}
                        <div class="form-group col-md-6" id="containerFoto{{ $matriculacion->idMatriculacion }}">
                            <label class="font-weight-bold text-danger"><i class="fas fa-camera mr-1"></i> Voucher (Obligatorio)</label>
                            <div class="custom-file custom-file-sm">
                                <input type="file" name="fotoPago" id="fotoPago{{ $matriculacion->idMatriculacion }}" class="custom-file-input" accept="image/*">
                                <label class="custom-file-label border-danger" for="fotoPago{{ $matriculacion->idMatriculacion }}" style="font-size: 0.8rem;">Voucher...</label>
                            </div>
                        </div>

                        {{-- MENSAJE PARA EFECTIVO --}}
                        <div class="form-group col-md-6" id="msgEfectivo{{ $matriculacion->idMatriculacion }}" style="display: none;">
                            <label class="font-weight-bold text-muted"><i class="fas fa-info-circle mr-1"></i> Voucher</label>
                            <div class="alert alert-light border p-1 mb-0" style="font-size: 0.75rem;">
                                <i class="fas fa-check-circle text-success mr-1"></i> El pago en efectivo no requiere comprobante.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fas fa-comment-dots text-muted mr-1"></i> Observaciones</label>
                        <textarea name="observacionesPago" class="form-control border-primary form-control-sm" rows="2" placeholder="Notas adicionales..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-danger rounded-pill px-4 btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow shadow-hover btn-sm">
                        <i class="fas fa-save mr-1"></i> GUARDAR PAGO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function toggleVoucher(id) {
        const metodo = $('#metodoPago' + id).val();
        const container = $('#containerFoto' + id);
        const input = $('#fotoPago' + id);
        const msg = $('#msgEfectivo' + id);

        const metodosConVoucher = ['Transferencia', 'Tarjeta', 'Yape/Plin'];

        if (metodosConVoucher.includes(metodo)) {
            container.show();
            input.prop('required', true);
            msg.hide();
        } else {
            container.hide();
            input.prop('required', false);
            input.val(''); 
            msg.show();
        }
    }

    // Inicializar para este modal específico
    toggleVoucher('{{ $matriculacion->idMatriculacion }}');

    // Escuchar cambios
    $('#metodoPago{{ $matriculacion->idMatriculacion }}').on('change', function() {
        toggleVoucher('{{ $matriculacion->idMatriculacion }}');
    });

    // Label dinámico
    $('#fotoPago{{ $matriculacion->idMatriculacion }}').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        if(fileName) $(this).next('.custom-file-label').html(fileName);
    });
});
</script>

<style>
    .bg-navy { background: #0a192f; }
    .border-primary { border-color: #4e73df !important; }
    .custom-file-label::after { content: "Abrir" !important; padding: 0.25rem 0.5rem; height: auto; }
</style>
