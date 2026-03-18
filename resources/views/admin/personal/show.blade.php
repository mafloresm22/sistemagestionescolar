<div class="modal fade" id="modalShowPersonal" tabindex="-1" role="dialog" aria-labelledby="modalShowPersonalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 position-absolute w-100" style="z-index: 10;">
                <button type="button" class="close text-white mt-1 mr-2" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-0 text-center">
                {{-- Foto y Header del Perfil --}}
                <div class="position-relative mb-3">
                    {{-- Fondo dinámico y estético --}}
                    <div class="bg-gradient-premium" style="height: 80px;"></div>
                    
                    {{-- Avatar Flotante --}}
                    <img id="show-foto" src="" alt="Foto de perfil" class="rounded-circle shadow-md border border-white" 
                         style="width: 90px; height: 90px; object-fit: cover; margin-top: -45px; border-width: 4px !important; background: white; position: relative; z-index: 5;">
                    
                    <h5 class="mt-3 mb-1 font-weight-bold text-dark px-3" id="show-nombres-apellidos" style="font-size: 1.1rem;">---</h5>
                    
                    <div class="d-flex justify-content-center align-items-center mb-2 mt-2 gap-2">
                        <span class="badge badge-pill badge-light px-3 py-2 shadow-sm border text-muted">
                            <i class="fas fa-briefcase text-primary mr-1"></i> <span id="show-profesion" style="font-size: 0.85rem;">---</span>
                        </span>
                        <span class="badge badge-pill badge-light px-3 py-2 shadow-sm border text-muted ml-2">
                            <i class="fas fa-user-tag text-warning mr-1"></i> <span id="show-tipo" style="font-size: 0.85rem;">---</span>
                        </span>
                    </div>
                </div>

                {{-- Grid de Información --}}
                <div class="px-4 pb-2">
                    <div class="row text-left bg-light rounded-lg p-3 mx-1 shadow-sm border">
                        <div class="col-6 mb-3">
                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">DNI</small>
                            <span class="text-dark font-weight-bold" id="show-dni-top" style="font-size: 0.95rem;">---</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">Género</small>
                            <span class="text-dark font-weight-bold" id="show-genero" style="font-size: 0.95rem;">---</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">Fecha de Nac.</small>
                            <span class="text-dark font-weight-bold" id="show-fecha-nac" style="font-size: 0.95rem;">---</span>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">Celular</small>
                            <span class="text-dark font-weight-bold" id="show-celular" style="font-size: 0.95rem;">---</span>
                        </div>
                        <div class="col-12 text-center mt-2 border-top pt-3">
                            <small class="text-secondary d-block font-weight-bold text-uppercase mb-1" style="font-size: 0.70rem; letter-spacing: 0.5px;">Correo Electrónico</small>
                            <span class="text-primary font-weight-bold" id="show-email" style="font-size: 1rem;">---</span>
                        </div>
                    </div>
                </div>

                <div class="mt-2 mb-4">
                    <button type="button" class="btn btn-light rounded-pill px-5 py-2 shadow-sm hover-lift border font-weight-bold text-secondary" data-dismiss="modal">
                        <i class="fas fa-times-circle mr-2 text-danger"></i> Cerrar Perfil
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-premium { 
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); 
    position: relative;
    overflow: hidden;
}

/* Patrón sutil para el fondo */
.bg-gradient-premium::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    opacity: 0.1;
    background-image: radial-gradient(#ffffff 1px, transparent 1px);
    background-size: 15px 15px;
}

.hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; color: #333 !important; }
</style>
