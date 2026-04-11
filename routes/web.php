<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home')->middleware('auth');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');


//CONFIGURACION DEL SISTEMA

Route::get('/admin/configuraciones', [App\Http\Controllers\ConfiguracionesController::class, 'index'])->name('admin.configuraciones.index')->middleware('auth');
Route::post('/admin/configuraciones/create', [App\Http\Controllers\ConfiguracionesController::class, 'store'])->name('admin.configuraciones.store')->middleware('auth');

//GESTIONES

Route::get('/admin/gestiones', [App\Http\Controllers\GestionController::class, 'index'])->name('admin.gestiones.index')->middleware('auth');
Route::post('/admin/gestiones/create', [App\Http\Controllers\GestionController::class, 'store'])->name('admin.gestiones.store')->middleware('auth');
Route::put('/admin/gestiones/update/{id}', [App\Http\Controllers\GestionController::class, 'update'])->name('admin.gestiones.update')->middleware('auth');
Route::delete('/admin/gestiones/delete/{id}', [App\Http\Controllers\GestionController::class, 'destroy'])->name('admin.gestiones.destroy')->middleware('auth');

//NIVELES

Route::get('/admin/niveles', [App\Http\Controllers\NivelesController::class, 'index'])->name('admin.niveles.index')->middleware('auth');
Route::post('/admin/niveles/create', [App\Http\Controllers\NivelesController::class, 'store'])->name('admin.niveles.store')->middleware('auth');
Route::delete('/admin/niveles/delete/{id}', [App\Http\Controllers\NivelesController::class, 'destroy'])->name('admin.niveles.destroy')->middleware('auth');

//TURNOS

Route::get('/admin/turnos', [App\Http\Controllers\TurnosController::class, 'index'])->name('admin.turnos.index')->middleware('auth');
Route::post('/admin/turnos/create', [App\Http\Controllers\TurnosController::class, 'store'])->name('admin.turnos.store')->middleware('auth');
Route::delete('/admin/turnos/delete/{id}', [App\Http\Controllers\TurnosController::class, 'destroy'])->name('admin.turnos.destroy')->middleware('auth');


// ACADÉMICA (Módulos agrupados por pestañas)
Route::middleware('auth')->prefix('admin')->group(function () {
    
    // Ruta principal de Académicas
    Route::get('/academicas', [App\Http\Controllers\PeriodosController::class, 'index'])->name('admin.academicas.index');

    // Módulo de Periodos
    Route::get('/periodos', [App\Http\Controllers\PeriodosController::class, 'index'])->name('admin.periodos.index');
    Route::post('/periodos/create', [App\Http\Controllers\PeriodosController::class, 'store'])->name('admin.periodos.store');
    Route::put('/periodos/update/{id}', [App\Http\Controllers\PeriodosController::class, 'update'])->name('admin.periodos.update');
    Route::delete('/periodos/delete/{id}', [App\Http\Controllers\PeriodosController::class, 'destroy'])->name('admin.periodos.destroy');

    // Módulo de Grados
    Route::get('/grados', [App\Http\Controllers\GradosController::class, 'index'])->name('admin.grados.index');
    Route::post('/grados/create', [App\Http\Controllers\GradosController::class, 'store'])->name('admin.grados.store');
    Route::put('/grados/update/{id}', [App\Http\Controllers\GradosController::class, 'update'])->name('admin.grados.update');
    Route::delete('/grados/delete/{id}', [App\Http\Controllers\GradosController::class, 'destroy'])->name('admin.grados.destroy');

    // Módulo de Secciones
    Route::get('/secciones', [App\Http\Controllers\SeccionesController::class, 'index'])->name('admin.secciones.index');
    Route::post('/secciones/create', [App\Http\Controllers\SeccionesController::class, 'store'])->name('admin.secciones.store');
    Route::put('/secciones/update/{id}', [App\Http\Controllers\SeccionesController::class, 'update'])->name('admin.secciones.update');
    Route::delete('/secciones/delete/{id}', [App\Http\Controllers\SeccionesController::class, 'destroy'])->name('admin.secciones.destroy');
});

//CURSOS

Route::get('/admin/cursos', [App\Http\Controllers\CursosController::class, 'index'])->name('admin.cursos.index')->middleware('auth');
Route::post('/admin/cursos/create', [App\Http\Controllers\CursosController::class, 'store'])->name('admin.cursos.store')->middleware('auth');
Route::put('/admin/cursos/update/{id}', [App\Http\Controllers\CursosController::class, 'update'])->name('admin.cursos.update')->middleware('auth');
Route::delete('/admin/cursos/delete/{id}', [App\Http\Controllers\CursosController::class, 'destroy'])->name('admin.cursos.destroy')->middleware('auth');


//ROLES

Route::get('/admin/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('admin.roles.index')->middleware('auth');
Route::post('/admin/roles/create', [App\Http\Controllers\RolesController::class, 'store'])->name('admin.roles.store')->middleware('auth');
Route::put('/admin/roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/roles/delete/{id}', [App\Http\Controllers\RolesController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth');

// PERMISOS DE ROLES
Route::get('/admin/roles/permisos/{id}', [App\Http\Controllers\RolesController::class, 'permisos'])->name('admin.roles.permisos')->middleware('auth');
Route::post('/admin/roles/permisos/{id}', [App\Http\Controllers\RolesController::class, 'assignPermisos'])->name('admin.roles.assign-permisos')->middleware('auth');
Route::get('/admin/roles/all-permisos/{id}', [App\Http\Controllers\RolesController::class, 'assignAllPermisos'])->name('admin.roles.all-permisos')->middleware('auth');

//PERSONAL

Route::get('/admin/personal/{tipoPersonal}', [App\Http\Controllers\PersonalController::class, 'index'])->name('admin.personal.index')->middleware('auth');
Route::post('/admin/personal/create/{tipoPersonal}', [App\Http\Controllers\PersonalController::class, 'store'])->name('admin.personal.store')->middleware('auth');
Route::put('/admin/personal/update/{id}', [App\Http\Controllers\PersonalController::class, 'update'])->name('admin.personal.update')->middleware('auth');
Route::get('/admin/personal/show/{id}', [App\Http\Controllers\PersonalController::class, 'show'])->name('admin.personal.show')->middleware('auth');
Route::delete('/admin/personal/delete/{id}', [App\Http\Controllers\PersonalController::class, 'destroy'])->name('admin.personal.destroy')->middleware('auth');

//FORMACION ACADEMICA

Route::get('/admin/formacionAcademica/{idFormacionAcademica}', [App\Http\Controllers\FormacionAcademicaController::class, 'index'])->name('admin.formacionAcademica.index')->middleware('auth');
Route::post('/admin/formacionAcademica/create/{idFormacionAcademica}', [App\Http\Controllers\FormacionAcademicaController::class, 'store'])->name('admin.formacionAcademica.store')->middleware('auth');
Route::put('/admin/formacionAcademica/update/{id}', [App\Http\Controllers\FormacionAcademicaController::class, 'update'])->name('admin.formacionAcademica.update')->middleware('auth');
Route::get('/admin/formacionAcademica/show/{id}', [App\Http\Controllers\FormacionAcademicaController::class, 'show'])->name('admin.formacionAcademica.show')->middleware('auth');
Route::delete('/admin/formacionAcademica/delete/{id}', [App\Http\Controllers\FormacionAcademicaController::class, 'destroy'])->name('admin.formacionAcademica.destroy')->middleware('auth');

//PADRES DE FAMILIA
Route::get('/admin/padres', [App\Http\Controllers\PadreFamiliaController::class, 'index'])->name('admin.padres.index')->middleware('auth');
Route::post('/admin/padres/create', [App\Http\Controllers\PadreFamiliaController::class, 'store'])->name('admin.padres.store')->middleware('auth');
Route::put('/admin/padres/update/{id}', [App\Http\Controllers\PadreFamiliaController::class, 'update'])->name('admin.padres.update')->middleware('auth');
Route::get('/admin/padres/show/{id}', [App\Http\Controllers\PadreFamiliaController::class, 'show'])->name('admin.padres.show')->middleware('auth');
Route::delete('/admin/padres/delete/{id}', [App\Http\Controllers\PadreFamiliaController::class, 'destroy'])->name('admin.padres.destroy')->middleware('auth');
Route::post('/admin/padres/restituir/{id}', [App\Http\Controllers\PadreFamiliaController::class, 'restituir'])->name('admin.padres.restituir')->middleware('auth');

//ESTUDIANTES
Route::middleware('auth')->prefix('admin/estudiantes')->group(function () {
    Route::get('/', [App\Http\Controllers\EstudianteController::class, 'index'])->name('admin.estudiantes.index');
    Route::get('/buscar', [App\Http\Controllers\EstudianteController::class, 'buscar'])->name('admin.estudiantes.buscar');
    Route::post('/create', [App\Http\Controllers\EstudianteController::class, 'store'])->name('admin.estudiantes.store');
    Route::get('/show/{id}', [App\Http\Controllers\EstudianteController::class, 'show'])->name('admin.estudiantes.show');
    Route::put('/update/{id}', [App\Http\Controllers\EstudianteController::class, 'update'])->name('admin.estudiantes.update');
    Route::delete('/delete/{id}', [App\Http\Controllers\EstudianteController::class, 'destroy'])->name('admin.estudiantes.destroy');

    // MATRICULACION
    Route::get('/matriculacion', [App\Http\Controllers\MatriculacionController::class, 'index'])->name('admin.matriculacion.index');
    Route::get('/matriculacion/buscar-historial', [App\Http\Controllers\MatriculacionController::class, 'buscarHistorial'])->name('admin.matriculacion.buscar-historial');
    Route::get('/matriculacion/create', [App\Http\Controllers\MatriculacionController::class, 'create'])->name('admin.matriculacion.create');
    Route::post('/matriculacion/store', [App\Http\Controllers\MatriculacionController::class, 'store'])->name('admin.matriculacion.store');

    Route::get('/matriculacion/edit/{id}', [App\Http\Controllers\MatriculacionController::class, 'edit'])->name('admin.matriculacion.edit');
    Route::get('/matriculacion/imprimir/{id}', [App\Http\Controllers\MatriculacionController::class, 'imprimir'])->name('admin.matriculacion.imprimir');
    Route::put('/matriculacion/update/{id}', [App\Http\Controllers\MatriculacionController::class, 'update'])->name('admin.matriculacion.update');
    Route::delete('/matriculacion/delete/{id}', [App\Http\Controllers\MatriculacionController::class, 'destroy'])->name('admin.matriculacion.destroy');
});

// AULAS
Route::middleware('auth')->prefix('admin/aulas')->group(function () {
    Route::get('/', [App\Http\Controllers\AulasController::class, 'index'])->name('admin.aulas.index');
    Route::post('/create', [App\Http\Controllers\AulasController::class, 'store'])->name('admin.aulas.store');
    Route::put('/update/{id}', [App\Http\Controllers\AulasController::class, 'update'])->name('admin.aulas.update');
    Route::put('/toggle-status/{id}', [App\Http\Controllers\AulasController::class, 'toggleStatus'])->name('admin.aulas.toggle-status');
    Route::delete('/delete/{id}', [App\Http\Controllers\AulasController::class, 'destroy'])->name('admin.aulas.destroy');
    Route::get('/asignar', [App\Http\Controllers\AsignarSeccionesAulasController::class, 'index'])->name('admin.aulas.asignar');

    // ASIGNAR SECCIONES AULAS
    Route::get('/asignar-secciones-aulas', [App\Http\Controllers\AsignarSeccionesAulasController::class, 'index'])->name('admin.asignar-secciones-aulas.index');
    Route::post('/asignar-secciones-aulas/create', [App\Http\Controllers\AsignarSeccionesAulasController::class, 'store'])->name('admin.asignar-secciones-aulas.store');
    Route::put('/asignar-secciones-aulas/update/{id}', [App\Http\Controllers\AsignarSeccionesAulasController::class, 'update'])->name('admin.asignar-secciones-aulas.update');
    Route::delete('/asignar-secciones-aulas/delete/{id}', [App\Http\Controllers\AsignarSeccionesAulasController::class, 'destroy'])->name('admin.asignar-secciones-aulas.destroy');
});

// CURSOS - DOCENTES
Route::middleware('auth')->prefix('admin/cursos-docentes')->group(function () {
    // ASIGNAR CURSOS DOCENTES
    Route::get('/', [App\Http\Controllers\AsignarCursosDocentesController::class, 'index'])->name('admin.cursos-docentes.index');
    Route::post('/asignar-cursos-docentes/create', [App\Http\Controllers\AsignarCursosDocentesController::class, 'store'])->name('admin.cursos-docentes.store');
    Route::put('/asignar-cursos-docentes/update/{idAsignarCursoDocente}', [App\Http\Controllers\AsignarCursosDocentesController::class, 'update'])->name('admin.cursos-docentes.update');
    Route::delete('/asignar-cursos-docentes/delete/{idAsignarCursoDocente}', [App\Http\Controllers\AsignarCursosDocentesController::class, 'destroy'])->name('admin.cursos-docentes.destroy');
});