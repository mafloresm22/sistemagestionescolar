@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <div class="content-header-custom">
        <h1 class="m-0 text-dark font-weight-bold"><i class="fas fa-home mr-2"></i>Inicio</h1>
        <p class="text-muted">Bienvenido al Panel de Control Principal</p>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Fila 1 -->
        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-primary-custom animated-card" style="animation-delay: 0.1s;">
                <div class="inner">
                    <h3>{{ $cursosCount ?? 0 }}</h3>
                    <p>Cursos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="{{ route('admin.cursos.index') }}" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-success-custom animated-card" style="animation-delay: 0.2s;">
                <div class="inner">
                    <h3>{{ $administrativosCount ?? 0 }}</h3>
                    <p>Administrativos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-shield"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="{{ route('admin.personal.index', 'administrativo') }}" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-info-custom animated-card" style="animation-delay: 0.3s;">
                <div class="inner">
                    <h3>{{ $estudiantesCount ?? 0 }}</h3>
                    <p>Estudiantes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="{{ route('admin.estudiantes.index') }}" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-warning-custom animated-card" style="animation-delay: 0.4s;">
                <div class="inner">
                    <h3>0</h3>
                    <p>Niveles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="#" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Fila 2 -->
        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-danger-custom animated-card" style="animation-delay: 0.5s;">
                <div class="inner">
                    <h3>0</h3>
                    <p>Grados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="#" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-purple-custom animated-card" style="animation-delay: 0.6s;">
                <div class="inner">
                    <h3>0</h3>
                    <p>Materias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="#" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-teal-custom animated-card" style="animation-delay: 0.7s;">
                <div class="inner">
                    <h3>0</h3>
                    <p>Estudiantes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="#" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6 mb-4">
            <div class="small-box premium-small-box bg-gradient-orange-custom animated-card" style="animation-delay: 0.8s;">
                <div class="inner">
                    <h3>0</h3>
                    <p>Docentes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="shape-bg"></div>
                <a href="#" class="small-box-footer custom-footer">
                    Ver más <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos del Header */
        .content-header-custom {
            padding: 10px 0 20px 0;
            animation: fadeInDown 0.8s ease;
        }

        /* ----- Premium Small Box Original ----- */
        .premium-small-box {
            border-radius: 18px;
            border: none;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            z-index: 1;
            margin-bottom: 0;
        }

        .premium-small-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Contenido numérico y título */
        .premium-small-box .inner {
            padding: 25px 20px 20px;
            position: relative;
            z-index: 3;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .premium-small-box .inner h3 {
            font-size: 2.8rem;
            font-weight: 800;
            margin: 0 0 5px 0;
            letter-spacing: -1px;
        }

        .premium-small-box .inner p {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Icono de fondo grande */
        .premium-small-box .icon {
            position: absolute;
            top: -15px;
            right: -10px;
            z-index: 2;
            transition: all 0.5s ease;
        }

        .premium-small-box .icon i {
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.2);
            text-shadow: none;
        }

        .premium-small-box:hover .icon {
            transform: scale(1.1) rotate(6deg);
        }

        /* Formas abstractas en el fondo para dar el toque premium/original */
        .premium-small-box .shape-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
            opacity: 0.4;
        }

        .premium-small-box .shape-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, transparent 60%);
            transform: scale(0);
            transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .premium-small-box:hover .shape-bg::before {
            transform: scale(1);
        }

        /* Footer del enlace interactivo */
        .custom-footer {
            position: relative;
            z-index: 3;
            background: rgba(0, 0, 0, 0.15) !important;
            backdrop-filter: blur(5px);
            padding: 10px 0 !important;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }

        .custom-footer:hover {
            background: rgba(0, 0, 0, 0.25) !important;
            color: #ffffff !important;
            letter-spacing: 1.5px;
        }

        .custom-footer i {
            transition: transform 0.3s ease;
        }

        .custom-footer:hover i {
            transform: translateX(4px);
        }

        /* --- Gradientes Premium Únicos --- */
        .bg-gradient-primary-custom { background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%); }
        .bg-gradient-success-custom { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .bg-gradient-info-custom { background: linear-gradient(135deg, #00B4DB 0%, #0083B0 100%); }
        .bg-gradient-warning-custom { background: linear-gradient(135deg, #F2994A 0%, #F2C94C 100%); }
        
        .bg-gradient-danger-custom { background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); }
        .bg-gradient-purple-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-gradient-teal-custom { background: linear-gradient(135deg, #108dc7 0%, #ef8e38 100%); }
        .bg-gradient-orange-custom { background: linear-gradient(135deg, #f12711 0%, #f5af19 100%); }

        /* --- Animaciones de Carga --- */
        .animated-card {
            opacity: 0;
            animation: zoomInFade 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes zoomInFade {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(25px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Panel de control cargado exitosamente.");
    </script>
@stop