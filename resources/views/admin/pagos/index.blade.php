@extends('adminlte::page')

@section('title', 'Control de Pagos')

@section('content_header')
<div class="container-fluid py-4">
    <div class="header-glass-card animate__animated animate__fadeInDown">
        <div class="header-overlay"></div>
        <div class="header-content d-flex flex-column flex-md-row align-items-md-center justify-content-between p-4 px-md-5">
            <div>
                <h1 class="header-title mb-1 text-white" style="font-size: 1.6rem;">
                    <i class="fas fa-coins mr-3 text-warning-gradient animate__animated animate__bounceIn"></i>Gestión de Pagos
                </h1>
                <p class="text-white-50 mb-0 font-italic" style="font-size: 0.85rem;">
                    Supervisa y administra el flujo financiero de manera intuitiva y profesional.
                </p>
            </div>
            <div class="header-actions mt-3 mt-md-0 d-flex gap-3">
                <div class="premium-search-dark">
                    <i class="fas fa-search"></i>
                    <input type="text" id="customSearch" placeholder="Buscar alumno...">
                </div>
                <a href="{{ route('admin.matriculacion.index') }}" class="btn-create-vibrant">
                    <i class="fas fa-plus"></i> <span>Nueva Matrícula</span>
                </a>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    


    <div class="row" id="pago-container">
        @php
            $colors = ['blue', 'purple', 'emerald', 'orange', 'rose', 'indigo'];
            $i = 0;
        @endphp
        @foreach($matriculaciones as $estudianteID => $enrollments)
            @php
                $first = $enrollments->first();
                $estudiante = $first->estudiante;
                $count = $enrollments->count();
                $c = $colors[$i % count($colors)];
                $i++;
            @endphp
            <div class="col-12 col-md-6 col-lg-4 mb-4 pago-item animate__animated animate__fadeInUp">
                <div class="pago-premium-card card-{{ $c }}" 
                     data-name="{{ strtolower($estudiante->nombreEstudiante . ' ' . $estudiante->apellidoEstudiante) }}" 
                     data-dni="{{ $estudiante->dniEstudiante }}">
                    
                    <div class="card-glow"></div>
                    
                    <div class="card-inner p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="avatar-vibrant avatar-{{ $c }} shadow">
                                {{ substr($estudiante->nombreEstudiante, 0, 1) }}{{ substr($estudiante->apellidoEstudiante, 0, 1) }}
                            </div>
                            <span class="count-badge count-{{ $c }}">
                                <i class="fas fa-copy mr-1"></i> {{ $count }}
                            </span>
                        </div>

                        <h5 class="font-weight-bold text-dark mb-1 name-accent">{{ $estudiante->nombreEstudiante }} {{ $estudiante->apellidoEstudiante }}</h5>
                        <p class="text-muted small mb-4">
                            <span class="dni-label"><i class="fas fa-fingerprint mr-1"></i> DNI:</span> 
                            <span class="dni-value">{{ $estudiante->dniEstudiante }}</span>
                        </p>

                        <div class="card-footer-custom pt-3 mt-2 border-top">
                            <a href="{{ route('admin.pagos.show', ['idEstudiante' => $estudianteID]) }}" class="btn-action-{{ $c }} btn-block text-center py-2 shadow-sm">
                                <b>Ver Historial de Pagos</b> <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- EMPTY STATE --}}
    <div id="emptyState" class="text-center py-5 d-none">
        <div class="pulse-animation">
            <i class="fas fa-search text-muted display-1"></i>
        </div>
        <h4 class="mt-4 text-muted">No encontramos coincidencias</h4>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');

:root {
    --blue: #4e73df; --blue-soft: #eaeffd;
    --purple: #6f42c1; --purple-soft: #f1ecf9;
    --emerald: #1cc88a; --emerald-soft: #e8f9f3;
    --orange: #f6c23e; --orange-soft: #fef9ec;
    --rose: #e74a3b; --rose-soft: #fdf1f0;
    --indigo: #4640de; --indigo-soft: #ececfc;
    --dark: #0a192f;
}

body, .content-wrapper { background-color: #f7f9fc !important; font-family: 'Outfit', sans-serif !important; }

/* HEADER GLASS CARD */
.header-glass-card {
    background: linear-gradient(135deg, #0d49a2 0%, #408fea 100%);
    border-radius: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(10,25,47,0.2);
}
.header-overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(circle at top right, rgba(78,115,223,0.2), transparent);
    z-index: 1;
}
.header-content { position: relative; z-index: 2; }
.text-warning-gradient { background: linear-gradient(to bottom, #f6c23e, #f4b619); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

/* SEARCH & BUTTONS */
.premium-search-dark {
    background: rgba(255,255,255,0.1);
    border-radius: 50px;
    padding: 8px 20px;
    display: flex; align-items: center;
    border: 1px solid rgba(255,255,255,0.1);
    width: 280px;
    transition: all 0.3s;
}
.premium-search-dark:focus-within { background: rgba(255,255,255,0.2); border-color: white; transform: scale(1.02); }
.premium-search-dark i { color: rgba(255,255,255,0.6); margin-right: 12px; }
.premium-search-dark input { background: transparent; border: none; outline: none; color: white; width: 100%; font-size: 0.9rem; }
.premium-search-dark input::placeholder { color: rgba(255,255,255,0.4); }

.btn-create-vibrant {
    background: white; color: var(--dark);
    padding: 10px 25px; border-radius: 50px;
    font-weight: 700; display: flex; align-items: center; gap: 10px;
    transition: all 0.3s;
}
.btn-create-vibrant:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); text-decoration: none; background: #f8f9fa; }

/* SHELF */
.summary-shelf { background: white; border-radius: 20px; }
.summary-item { display: flex; align-items: center; gap: 15px; }
.summary-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.bg-soft-blue { background: var(--blue-soft); color: var(--blue); }
.bg-soft-green { background: var(--emerald-soft); color: var(--emerald); }
.summary-label { font-size: 0.75rem; color: #858796; text-transform: uppercase; font-weight: 700; }
.summary-value { font-size: 1.3rem; font-weight: 800; line-height: 1; }
.summary-divider { width: 1px; height: 35px; background: #eee; }

/* PREMIUM CARDS COLORS */
.pago-premium-card {
    background: white; border-radius: 28px; position: relative; overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid #f1f3f9;
}
.pago-premium-card:hover { transform: translateY(-12px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
.card-glow { 
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; 
    background: radial-gradient(circle, rgba(0,0,0,0.01) 0%, transparent 70%); z-index: 0;
}
.card-inner { position: relative; z-index: 2; }

.avatar-vibrant {
    width: 50px; height: 50px; border-radius: 18px; display: flex; align-items: center; 
    justify-content: center; font-weight: 800; font-size: 1.1rem; border: 3px solid white;
}
.count-badge { padding: 3px 10px; border-radius: 50px; font-weight: 800; font-size: 0.65rem; }

/* VARIATIONS */
.avatar-blue { background: linear-gradient(45deg, #4e73df, #224abe); color: white; }
.btn-action-blue { background: var(--blue-soft); color: var(--blue); border-radius: 12px; }
.count-blue { background: var(--blue-soft); color: var(--blue); }

.avatar-purple { background: linear-gradient(45deg, #6f42c1, #5a32a3); color: white; }
.btn-action-purple { background: var(--purple-soft); color: var(--purple); border-radius: 12px; }
.count-purple { background: var(--purple-soft); color: var(--purple); }

.avatar-emerald { background: linear-gradient(45deg, #1cc88a, #13855c); color: white; }
.btn-action-emerald { background: var(--emerald-soft); color: var(--emerald); border-radius: 12px; }
.count-emerald { background: var(--emerald-soft); color: var(--emerald); }

.avatar-orange { background: linear-gradient(45deg, #f6c23e, #dda20a); color: white; }
.btn-action-orange { background: var(--orange-soft); color: var(--orange); border-radius: 12px; }
.count-orange { background: var(--orange-soft); color: var(--orange); }

.avatar-rose { background: linear-gradient(45deg, #e74a3b, #be2617); color: white; }
.btn-action-rose { background: var(--rose-soft); color: var(--rose); border-radius: 12px; }
.count-rose { background: var(--rose-soft); color: var(--rose); }

.avatar-indigo { background: linear-gradient(45deg, #4640de, #2d28a3); color: white; }
.btn-action-indigo { background: var(--indigo-soft); color: var(--indigo); border-radius: 12px; }
.count-indigo { background: var(--indigo-soft); color: var(--indigo); }

.dni-label { color: #b7b9cc; font-size: 0.8rem; }
.dni-value { color: #5a5c69; font-weight: 600; font-size: 0.8rem; }
.name-accent { letter-spacing: -0.5px; font-size: 1rem !important; }

.btn-action-blue:hover, .btn-action-purple:hover, .btn-action-emerald:hover, 
.btn-action-orange:hover, .btn-action-rose:hover, .btn-action-indigo:hover {
    filter: brightness(0.95); text-decoration: none; transform: scale(1.02);
}

.pulse-animation { animation: pulse 2s infinite; }
@keyframes pulse { 0% { opacity: 0.5; } 50% { opacity: 1; } 100% { opacity: 0.5; } }
</style>

<script>
document.getElementById('customSearch').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    let found = false;
    document.querySelectorAll('.pago-item').forEach(item => {
        const name = item.querySelector('.pago-premium-card').getAttribute('data-name');
        const dni = item.querySelector('.pago-premium-card').getAttribute('data-dni');
        if (name.includes(term) || dni.includes(term)) {
            item.classList.remove('d-none');
            found = true;
        } else {
            item.classList.add('d-none');
        }
    });
    document.getElementById('emptyState').classList.toggle('d-none', found);
});
</script>
@stop
