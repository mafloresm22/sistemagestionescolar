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
    public function store(Request $request)
    {
        $request->validate([
            'estudianteID' => 'required|exists:estudiantes,idEstudiante',
            'nivelesID' => 'required|exists:niveles,id',
            'gradosID' => 'required|exists:grados,id',
            'seccionID' => 'required|exists:secciones,idSeccion',
            'turnoID' => 'required|exists:turnos,id',
            'gestionID' => 'required|exists:gestions,id',
            'fechaMatriculacion' => 'required|date',
        ]);

        // Verificar si el estudiante ya está matriculado en la misma gestión (año)
        $existeMatricula = Matriculacion::where('estudianteID', $request->estudianteID)
            ->where('gestionID', $request->gestionID)
            ->first();

        if ($existeMatricula) {
            return redirect()->back()->with([
                'mensaje' => 'El estudiante ya se encuentra matriculado en esta gestión (año escolar).',
                'icono' => 'error'
            ]);
        }

        Matriculacion::create([
            'fechaMatriculacion' => $request->fechaMatriculacion,
            'estudianteID' => $request->estudianteID,
            'turnoID' => $request->turnoID,
            'gestionID' => $request->gestionID,
            'seccionID' => $request->seccionID,
            'nivelesID' => $request->nivelesID,
            'gradosID' => $request->gradosID,
            'observacionesMatriculacion' => $request->observacionesMatriculacion ?? 'Ninguno',
            'estadoMatriculacion' => 'Activo',
        ]);

        return redirect()->route('admin.matriculacion.index')->with([
            'mensaje' => 'Estudiante matriculado con éxito',
            'icono' => 'success'
        ]);
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
