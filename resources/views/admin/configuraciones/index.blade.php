@extends('adminlte::page')

@section('title', 'Configuraciones')

@section('content_header')
    <div class="container-fluid animation-fade-in">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    <i class="fas fa-cogs mr-2 text-primary"></i>Configuraciones del Sistema
                </h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ url('/admin/configuraciones/create') }}" method="POST" enctype="multipart/form-data" class="animation-slide-up">
            @csrf
            <div class="row">
                <!-- Section: System Sidebar / Summary -->
                <div class="col-md-3">
                    <div class="card card-primary card-outline shadow-lg border-0 card-config-sidebar" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body box-profile p-4">
                            <div class="text-center position-relative mb-4">
                                <div class="logo-container mx-auto">
                                    <img class="profile-user-img img-fluid img-circle logo-preview shadow-sm"
                                        src="{{ (isset($configuraciones) && $configuraciones->logoConfiguraciones) ? asset($configuraciones->logoConfiguraciones) : asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}"
                                        alt="Logo Institución">
                                    <div class="logo-overlay" onclick="document.getElementById('fileLogo').click();">
                                        <i class="fas fa-camera text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <h3 class="profile-username text-center font-weight-bold mb-1">{{ $configuraciones->nombreConfiguraciones ?? 'Nombre de la Institución' }}</h3>
                            <p class="text-muted text-center small mb-4">Sistema de Gestión Escolar</p>
                            
                            <ul class="list-group list-group-unbordered mb-4 custom-list-info">
                                <li class="list-group-item border-0 px-0 py-2">
                                    <span class="text-muted"><i class="fas fa-user-shield mr-2"></i> Usuarios</span> 
                                    <a class="float-right badge badge-primary py-1 px-3" style="border-radius: 10px;">Admin</a>
                                </li>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <span class="text-muted"><i class="fas fa-toggle-on mr-2 text-success"></i> Estado</span> 
                                    <a class="float-right badge badge-success py-1 px-3" style="border-radius: 10px;">Activo</a>
                                </li>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <span class="text-muted"><i class="fas fa-code-branch mr-2"></i> Versión</span> 
                                    <a class="float-right text-dark font-weight-bold">1.0.0</a>
                                </li>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <span class="text-muted"><i class="fas fa-globe-americas mr-2 text-info"></i> Zona Horaria</span> 
                                    <a class="float-right text-dark font-weight-bold italic">UTC-5</a>
                                </li>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <span class="text-muted"><i class="fas fa-calendar-alt mr-2 text-warning"></i> Ciclo Escolar</span> 
                                    <a class="float-right badge badge-info py-1 px-3" style="border-radius: 10px;">{{ date('Y') }} - {{ date('Y') + 1 }}</a>
                                </li>
                            </ul>

                            <input type="file" id="fileLogo" name="logoConfiguraciones" accept="image/jpg, image/jpeg, image/png" style="display:none">
                            <button type="button" class="btn btn-primary btn-block shadow-sm btn-change-logo" onclick="document.getElementById('fileLogo').click();" style="border-radius: 12px; font-weight: 600;">
                                <i class="fas fa-image mr-1"></i> Cambiar Logo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section: Configuration Forms -->
                <div class="col-md-9">
                    <div class="card shadow-lg border-0 card-config-main" style="border-radius: 20px;">
                        <div class="card-header p-2 bg-transparent border-0">
                            <ul class="nav nav-pills custom-nav-pills p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#general" data-toggle="tab">
                                        <i class="fas fa-cog mr-2"></i>Datos Generales
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#social" data-toggle="tab">
                                        <i class="fas fa-share-alt mr-2"></i>Redes Sociales
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="active tab-pane animation-tab-entrance" id="general">
                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label text-secondary">
                                            <i class="fas fa-school mr-1"></i> Institución
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="input-group custom-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-university text-primary"></i></span>
                                                </div>
                                                <input type="text" class="form-control border-left-0" value="{{ old('nombreConfiguraciones', $configuraciones->nombreConfiguraciones ?? '')  }}" 
                                                   name="nombreConfiguraciones" placeholder="Nombre de la Institución" required>
                                            </div>
                                            @error('nombreConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label text-secondary">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Ubicación
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="input-group custom-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-map-marked-alt text-danger"></i></span>
                                                </div>
                                                <input type="text" class="form-control border-left-0" value="{{ old('direccionConfiguraciones', $configuraciones->direccionConfiguraciones ?? '')  }}" 
                                                   name="direccionConfiguraciones" placeholder="Dirección completa" required>
                                            </div>
                                            @error('direccionConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label text-secondary">
                                            <i class="fas fa-phone mr-1"></i> Contacto y Divisa
                                        </label>
                                        <div class="col-sm-4">
                                            <div class="input-group custom-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-phone-alt text-success"></i></span>
                                                </div>
                                                <input type="number" class="form-control border-left-0" value="{{ old('telefonoConfiguraciones', $configuraciones->telefonoConfiguraciones ?? '')  }}" 
                                                   name="telefonoConfiguraciones" placeholder="Teléfono" required>
                                            </div>
                                            @error('telefonoConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="input-group custom-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-coins text-warning"></i></span>
                                                </div>
                                                <select name="divisaConfiguraciones" class="form-control border-left-0">
                                                    <option value="">Seleccione una moneda</option>
                                                    @foreach ($divisas as $divisa)
                                                        <option value="{{ $divisa['symbol'] }}" {{ (old('divisaConfiguraciones', $configuraciones->divisaConfiguraciones ?? '') == $divisa['symbol']) ? 'selected' : '' }}>
                                                            {{ $divisa['symbol'] }} - {{ $divisa['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('divisaConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label text-secondary">
                                            <i class="fas fa-at mr-1"></i> Correo e Internet
                                        </label>
                                        <div class="col-sm-4">
                                            <div class="input-group custom-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-envelope text-info"></i></span>
                                                </div>
                                                <input type="email" class="form-control border-left-0" value="{{ old('correoInstitucionalConfiguraciones', $configuraciones->correoInstitucionalConfiguraciones ?? '')  }}" 
                                                   name="correoInstitucionalConfiguraciones" placeholder="Correo institucional" required>
                                            </div>
                                            @error('correoInstitucionalConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="input-group custom-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-desktop text-purple"></i></span>
                                                </div>
                                                <input type="text" class="form-control border-left-0" value="{{ old('webConfiguraciones', $configuraciones->webConfiguraciones ?? '')  }}" 
                                                   name="webConfiguraciones" placeholder="Sitio Web">
                                            </div>
                                            @error('webConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label text-secondary">
                                            <i class="fas fa-info-circle mr-1"></i> Acerca de
                                        </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control custom-textarea" 
                                                name="descripcionConfiguraciones" rows="4" placeholder="Breve descripción de la institución..." required style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px;">{{ old('descripcionConfiguraciones', $configuraciones->descripcionConfiguraciones ?? '') }}</textarea>
                                            @error('descripcionConfiguraciones')
                                                <small class="text-danger font-italic ml-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-5">
                                        <div class="offset-sm-3 col-sm-9 text-right">
                                            <button type="submit" class="btn btn-success btn-lg shadow btn-save-config px-5" style="border-radius: 15px; font-weight: 700;">
                                                <i class="fas fa-save mr-2"></i> Guardar Configuración
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        /* Animaciones */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes tabEntrance { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: translateX(0); } }

        .animation-fade-in { animation: fadeIn 0.8s ease-out; }
        .animation-slide-up { animation: slideUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .animation-tab-entrance { animation: tabEntrance 0.4s ease-out; }

        /* Sidebar Styling */
        .card-config-sidebar {
            transition: all 0.3s ease;
        }
        
        .logo-container {
            width: 120px;
            height: 120px;
            position: relative;
            cursor: pointer;
            border-radius: 50%;
            padding: 5px;
            background: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .profile-user-img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border: 3px solid #eee;
            transition: all 0.3s ease;
        }

        .logo-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.5);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .logo-container:hover .logo-overlay { opacity: 1; }
        .logo-container:hover .profile-user-img { filter: blur(2px); }

        .custom-list-info .list-group-item {
            transition: all 0.2s ease;
            background: transparent;
        }
        
        .custom-list-info .list-group-item:hover {
            padding-left: 10px !important;
        }

        /* Nav Pills Styling */
        .custom-nav-pills {
            background: #f8fafc;
            border-radius: 15px;
            gap: 5px;
        }

        .custom-nav-pills .nav-link {
            border-radius: 12px !important;
            padding: 10px 20px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .custom-nav-pills .nav-link.active {
            background: #fff !important;
            color: #007bff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Inputs Styling */
        .custom-input-group {
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .custom-input-group:focus-within {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .custom-input-group input, .custom-input-group select {
            border: none;
            box-shadow: none !important;
            height: 48px;
            font-weight: 500;
        }

        .custom-textarea:focus {
            border-color: #007bff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1) !important;
        }

        .btn-save-config:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3) !important;
        }
    </style>
@stop

@section('js')
    <script>
        // Preview de imagen
        $('#fileLogo').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('.logo-preview').attr('src', e.target.result);
                Swal.fire({
                    icon: 'info',
                    title: 'Vista previa cargada',
                    text: 'Recuerda guardar los cambios para actualizar el logo oficialmente.',
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        // Notificaciones de sesión
        @if(session('mensaje') && session('icono'))
            Swal.fire({
                icon: "{{ session('icono') }}", 
                title: "{{ session('mensaje') }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif
    </script>
@stop
