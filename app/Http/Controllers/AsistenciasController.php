<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignarCursosDocentes;
use App\Models\Matriculacion;
use App\Models\AsignarSeccionesAulas;
use App\Models\AsistenciasDetalle;

class AsistenciasController extends Controller
{
    public function index()
    {
        $asignaciones = AsignarCursosDocentes::with(['docente', 'curso', 'gestion', 'nivel', 'grado', 'seccion', 'turno'])->get();
        return view('admin.asignaciones_curso_docente.asistencias_curso_docentes.index', compact('asignaciones'));
    }

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

        $historial = Asistencias::where('asignarCursoDocenteID', $idAsignarCursoDocente)
            ->orderBy('fechaAsistencias', 'desc')
            ->get();

        $aulaAsignada = AsignarSeccionesAulas::with('aula')
            ->where('seccionID', $asignacion->seccionID)
            ->where('turnoID', $asignacion->turnoID)
            ->first();

        return view('admin.asignaciones_curso_docente.asistencias_curso_docentes.create', compact('asignacion', 'estudiantes', 'historial', 'aulaAsignada'));
    }

    public function store(Request $request, $idAsignarCursoDocente)
    {
        // 1. Validar que vengan los alumnos
        $request->validate([
            'fechaAsistencias' => 'required|date',
            'asistencias' => 'required|array',
        ]);

        // 2. Comprobar si ya tomó asistencia HOY en este mismo curso para evitar duplicados
        $asistenciaExistente = Asistencias::where('asignarCursoDocenteID', $idAsignarCursoDocente)
            ->whereDate('fechaAsistencias', $request->fechaAsistencias)
            ->first();

        if ($asistenciaExistente) {
            return redirect()->back()->with('error', 'Ya existe un registro de asistencia para este curso en la fecha seleccionada. Si deseas modificarla, utiliza el botón de Editar.');
        }

        // 3. Crear el registro general de la clase
        $asistencia = Asistencias::create([
            'asignarCursoDocenteID' => $idAsignarCursoDocente,
            'fechaAsistencias' => $request->fechaAsistencias,
            'observacionAsistencias' => $request->observacionAsistencias ?? 'Sin observaciones',
        ]);

        foreach ($request->asistencias as $idEstudiante => $estado) {
            AsistenciasDetalle::create([
                'asistenciaID' => $asistencia->idAsistencia,
                'estudianteID' => $idEstudiante,
                'estadoAsistenciasDetalle' => $estado
            ]);
        }

        return redirect()->back()->with('success', 'La asistencia fue registrada exitosamente.');
    }

    public function edit($idAsistencia)
    {
        $asistencia = Asistencias::with(['asistenciasDetalles.estudiante', 'asignarCursoDocente.curso', 'asignarCursoDocente.docente', 'asignarCursoDocente.grado', 'asignarCursoDocente.seccion'])->findOrFail($idAsistencia);
        
        $asignacion = $asistencia->asignarCursoDocente;

        // Necesitamos el aula
        $aulaAsignada = AsignarSeccionesAulas::with('aula')
            ->where('seccionID', $asignacion->seccionID)
            ->where('turnoID', $asignacion->turnoID)
            ->first();

        return view('admin.asignaciones_curso_docente.asistencias_curso_docentes.edit', compact('asistencia', 'asignacion', 'aulaAsignada'));
    }

    public function update(Request $request, $idAsistencia)
    {
        $request->validate([
            'asistencias' => 'required|array',
            'observacionAsistencias' => 'nullable|string',
        ]);

        $asistencia = Asistencias::findOrFail($idAsistencia);
        $asistencia->update([
            'observacionAsistencias' => $request->observacionAsistencias ?? 'Sin observaciones',
        ]);

        foreach ($request->asistencias as $idDetalle => $estado) {
            AsistenciasDetalle::where('idAsistenciasDetalle', $idDetalle)->update([
                'estadoAsistenciasDetalle' => $estado
            ]);
        }

        return redirect()->route('admin.cursos-docentes-asistencias.create', $asistencia->asignarCursoDocenteID)->with('success', 'La asistencia fue actualizada correctamente.');
    }

    public function imprimir($idAsistencia)
    {
        $asistencia = Asistencias::with(['asistenciasDetalles.estudiante', 'asignarCursoDocente.curso', 'asignarCursoDocente.docente', 'asignarCursoDocente.grado', 'asignarCursoDocente.seccion', 'asignarCursoDocente.turno', 'asignarCursoDocente.gestion', 'asignarCursoDocente.nivel'])->findOrFail($idAsistencia);
        
        $aulaAsignada = AsignarSeccionesAulas::with('aula')
            ->where('seccionID', $asistencia->asignarCursoDocente->seccionID)
            ->where('turnoID', $asistencia->asignarCursoDocente->turnoID)
            ->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.asignaciones_curso_docente.asistencias_curso_docentes.pdf', compact('asistencia', 'aulaAsignada'));
        
        return $pdf->stream('Asistencia_' . $asistencia->fechaAsistencias . '.pdf');
    }
}
