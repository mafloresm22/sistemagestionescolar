@extends('adminlte::master')

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');
    $registerUrl = View::getSection('register_url') ?? config('adminlte.register_url', 'register');
    $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');

    if (config('adminlte.use_route_url', false)) {
        $loginUrl = $loginUrl ? route($loginUrl) : '';
        $registerUrl = $registerUrl ? route($registerUrl) : '';
        $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
    } else {
        $loginUrl = $loginUrl ? url($loginUrl) : '';
        $registerUrl = $registerUrl ? url($registerUrl) : '';
        $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
    }

    $config = App\Models\Configuraciones::first();
@endphp

@section('title', 'Login - ' . ($config->nombreConfiguraciones ?? 'Sistema'))

@section('adminlte_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        #auth {
            height: 100vh;
            overflow-x: hidden;
        }
        #auth-left {
            padding: 5rem 8rem;
        }
        .auth-logo {
            margin-bottom: 3rem;
        }
        .auth-logo img {
            height: 3rem;
        }
        .auth-title {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .auth-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
        }
        #auth-right {
            background: linear-gradient(45deg, #1d4ed8, #a855f7);
            height: 100%;
        }
        .form-control-xl {
            padding: 0.85rem 1.2rem;
            font-size: 1.1rem;
            border-radius: 0.5rem;
        }
        .form-group.position-relative .form-control-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 1rem;
            color: #adb5bd;
        }
        .form-group.position-relative.has-icon-left .form-control {
            padding-left: 3rem;
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        @media (max-width: 991.98px) {
            #auth-left {
                padding: 3rem 2rem;
            }
        }
    </style>
@stop

@section('body')
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo text-center d-lg-block">
                    <a href="{{ url('/') }}">
                        <img src="{{ ($config && $config->logoConfiguraciones) ? asset($config->logoConfiguraciones) : asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" 
                             alt="Logo" style="height: 100px; width: auto; object-fit: contain;">
                    </a>
                </div>
                <h1 class="auth-title text-center text-lg-center">{{ __('adminlte::adminlte.sign_in') }}</h1>
                <p class="auth-subtitle mb-5 text-center">Inicie sesión con sus datos para acceder al sistema escolar.</p>

                <form action="{{ $loginUrl }}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" 
                               placeholder="{{ __('adminlte::adminlte.email') }}" value="{{ old('email') }}" required autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" 
                               placeholder="{{ __('adminlte::adminlte.password') }}" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                        {{ __('adminlte::adminlte.sign_in') }}
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right" class="d-flex align-items-center justify-content-center">
                <div class="text-center text-white p-5">
                    <h1 class="display-3 font-weight-bold">{{ $config->nombreConfiguraciones ?? 'Bienvenido' }}</h1>
                    <p class="lead">{{ $config->descripcionConfiguraciones ?? 'Sistema de Gestión Escolar integral.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('adminlte_js')
<script>
    // Smooth transition
    document.querySelector('body').classList.remove('login-page');
    document.querySelector('body').style.backgroundColor = '#fff';
</script>
@stop

