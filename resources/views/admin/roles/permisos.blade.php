@extends('adminlte::page')

@section('title', 'Asignar Permisos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="m-0 text-dark font-weight-bold">
            <i class="fas fa-user-shield text-warning mr-2"></i>Permisos para: <span class="text-primary">{{ strtoupper($role->name) }}</span>
        </h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary rounded-pill shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <form action="{{ route('admin.roles.assign-permisos', $role->id) }}" method="POST">
                @csrf
                <div class="card-header bg-gradient-dark text-white p-4">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-list-check mr-2"></i> Listado de Rutas Disponibles</h5>
                    <p class="mb-0 text-light mt-1" style="font-size: 0.9rem;">Marque las sub-rutas a las cuales este rol tendrá permiso de acceder o ejecutar.</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-right" style="width: 250px; border-bottom: 2px solid #dee2e6;">
                                        <i class="fas fa-layer-group text-primary mr-2"></i>Módulos
                                    </th>
                                    <th style="border-bottom: 2px solid #dee2e6;">
                                        <i class="fas fa-key text-warning mr-2"></i>Acciones Disponibles
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permisosAgrupados as $grupo => $rutas)
                                    <tr class="border-bottom hover-row">
                                        <td class="align-middle border-right bg-light" style="width: 250px;">
                                            <div class="d-flex flex-column pl-2">
                                                <h6 class="font-weight-bold text-uppercase mb-2 text-dark">
                                                    <i class="fas fa-folder text-warning mr-2"></i>{{ $grupo }}
                                                </h6>
                                                <div class="custom-control custom-switch mt-1">
                                                    <input type="checkbox" class="custom-control-input switch-grupo" id="switch_{{ $grupo }}" data-grupo="{{ $grupo }}">
                                                    <label class="custom-control-label small font-weight-bold text-muted" style="cursor:pointer;" for="switch_{{ $grupo }}">Seleccionar Todo</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle p-4 group-{{ $grupo }}">
                                            <div class="row">
                                                @foreach($rutas as $ruta)
                                                    <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" 
                                                                   class="custom-control-input checkbox-permiso" 
                                                                   id="permiso_{{ str_replace('.', '_', $ruta) }}" 
                                                                   name="permisos[]" 
                                                                   value="{{ $ruta }}"
                                                                   {{ $role->hasPermissionTo($ruta) ? 'checked' : '' }}>
                                                            <label class="custom-control-label pt-1" for="permiso_{{ str_replace('.', '_', $ruta) }}" style="cursor: pointer;">
                                                                @php
                                                                    $badgeClass = 'badge-secondary';
                                                                    if (str_contains($ruta, 'destroy') || str_contains($ruta, 'delete')) $badgeClass = 'badge-danger';
                                                                    elseif (str_contains($ruta, 'index') || str_contains($ruta, 'show')) $badgeClass = 'badge-info';
                                                                    elseif (str_contains($ruta, 'create') || str_contains($ruta, 'store')) $badgeClass = 'badge-success';
                                                                    elseif (str_contains($ruta, 'edit') || str_contains($ruta, 'update') || str_contains($ruta, 'toggle')) $badgeClass = 'badge-warning text-dark';
                                                                @endphp
                                                                <span class="badge {{ $badgeClass }} px-2 py-1 shadow-sm font-weight-normal" style="font-size: 0.85rem; letter-spacing: 0.3px;">
                                                                    {{ str_replace('admin.', '', $ruta) }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top p-4 d-flex justify-content-between align-items-center">
                    <button type="button" id="btnSelectAll" class="btn btn-outline-dark rounded-pill px-4">
                        <i class="fas fa-check-double mr-2"></i> Seleccionar Todo
                    </button>
                    <div>
                        <a href="{{ route('admin.roles.all-permisos', $role->id) }}" 
                           class="btn btn-success rounded-pill px-4 mr-2 shadow-sm"
                           onclick="return confirm('\u00bfAsignar TODOS los permisos del sistema a este rol?')">
                            <i class="fas fa-unlock-alt mr-2"></i> Dar Todos los Permisos
                        </a>
                        <button type="submit" class="btn btn-warning shadow rounded-pill px-5 text-dark font-weight-bold">
                            <i class="fas fa-save mr-2"></i> Guardar Permisos
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .bg-gradient-dark { background: linear-gradient(135deg, #343a40 0%, #212529 100%); }
    .hover-row { transition: background-color 0.2s ease; }
    .hover-row:hover { background-color: #f8f9fa; }
    .custom-control-label::before, 
    .custom-control-label::after {
        top: 0.15rem; 
        width: 1.25rem;
        height: 1.25rem;
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Logica para chequear todos los permisos de un grupo específico
        $('.switch-grupo').on('change', function() {
            let isChecked = $(this).is(':checked');
            let grupo = $(this).data('grupo');
            
            $('.group-' + grupo + ' .checkbox-permiso').prop('checked', isChecked);
        });

        // Logica inversa: si se deselecciona manualmente uno del grupo, el master de ese grupo se apaga.
        $('.checkbox-permiso').on('change', function() {
            let tr = $(this).closest('tr');
            let sw = tr.find('.switch-grupo');
            
            let allChecked = tr.find('.checkbox-permiso:not(:checked)').length === 0;
            sw.prop('checked', allChecked);
        });
        
        // Botón seleccionar/deseleccionar todo global
        let allSelected = false;
        $('#btnSelectAll').on('click', function() {
            allSelected = !allSelected;
            $('.checkbox-permiso').prop('checked', allSelected);
            $('.switch-grupo').prop('checked', allSelected);
            $(this).html(allSelected 
                ? '<i class="fas fa-times-circle mr-2"></i> Deseleccionar Todo'
                : '<i class="fas fa-check-double mr-2"></i> Seleccionar Todo'
            );
        });
        $('.switch-grupo').each(function() {
            let tr = $(this).closest('tr');
            let allChecked = tr.find('.checkbox-permiso:not(:checked)').length === 0;
            let noneChecked = tr.find('.checkbox-permiso:checked').length === 0;
            if(!noneChecked) {
                $(this).prop('checked', allChecked);
            }
        });
    });
</script>
@stop
