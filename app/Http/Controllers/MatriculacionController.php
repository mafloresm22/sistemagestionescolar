<?php

namespace App\Http\Controllers;

use App\Models\Matriculacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Estudiante;
use App\Models\Niveles;
use App\Models\Grados;
use App\Models\Secciones;
use App\Models\Turnos;
use App\Models\Gestion;

class MatriculacionController extends Controller
{
    public function index()
    {
        $matriculacions = Matriculacion::with(['estudiante', 'nivel', 'grado', 'seccion', 'turno', 'gestion'])->get();
        $estudiantes = Estudiante::with('padreFamilia')->where('estadoEstudiante', 'Activo')->get();
        $niveles = Niveles::all();
        $grados = Grados::with('nivel')->get();
        $secciones = Secciones::with('grados')->get();
        $turnos = Turnos::all();
        $gestiones = Gestion::all();

        return view('admin.estudiantes.matriculacion.index', compact(
            'matriculacions', 'estudiantes', 'niveles', 'grados', 'secciones', 'turnos', 'gestiones'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Matriculacion $matriculacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matriculacion $matriculacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matriculacion $matriculacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matriculacion $matriculacion)
    {
        //
    }
}
