<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignarCursosDocentes;
use App\Models\Matriculacion;

class AsistenciasController extends Controller
{
    public function index()
    {
        $asignaciones = AsignarCursosDocentes::with(['docente', 'curso', 'gestion', 'nivel', 'grado', 'seccion', 'turno'])->get();
        return view('admin.asignaciones_curso_docente.asistencias_curso_docentes.index', compact('asignaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idAsignarCursoDocente)
    {
        $asignacion = AsignarCursosDocentes::with(['curso', 'docente', 'nivel', 'grado', 'seccion', 'turno', 'gestion'])
            ->findOrFail($idAsignarCursoDocente);

        // Alumnos matriculados en esta sección, turno y gestión
        $estudiantes = Matriculacion::where([
            'nivelesID' => $asignacion->nivelID,
            'gradosID' => $asignacion->gradoID,
            'seccionID' => $asignacion->seccionID,
            'turnoID' => $asignacion->turnoID,
            'gestionID' => $asignacion->gestionID,
            'estadoMatriculacion' => 'Activo'
        ])->with('estudiante')->get();

        // Historial de asistencias tomadas para esta asignación
        $historial = Asistencias::where('asignarCursoDocenteID', $idAsignarCursoDocente)
            ->orderBy('fechaAsistencias', 'desc')
            ->get();

        return view('admin.asignaciones_curso_docente.asistencias_curso_docentes.create', compact('asignacion', 'estudiantes', 'historial'));
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
    public function show(Asistencias $asistencias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencias $asistencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencias $asistencias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencias $asistencias)
    {
        //
    }
}
