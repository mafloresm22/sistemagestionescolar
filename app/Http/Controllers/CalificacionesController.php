<?php

namespace App\Http\Controllers;

use App\Models\Calificaciones;
use App\Models\AsignarCursosDocentes;
use App\Models\AsignarSeccionesAulas;
use App\Models\Matriculacion;
use App\Models\Periodos;
use App\Models\Personal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionesController extends Controller
{
    public function index()
    {
        $personal = Personal::where('userID', Auth::id())
            ->where('tipoPersonal', 'Docente')
            ->first();

        $query = AsignarCursosDocentes::with(['docente', 'curso', 'gestion', 'nivel', 'grado', 'seccion', 'turno']);

        // Si el usuario autenticado es un docente, filtrar solo sus cursos
        if ($personal) {
            $query->where('docenteId', $personal->idPersonal);
        }

        $asignaciones = $query->get();
        return view('admin.calificaciones.index', compact('asignaciones'));
    }

    public function create($idAsignarCursoDocente)
    {
        $asignacion = AsignarCursosDocentes::with(['curso', 'docente', 'nivel', 'grado', 'seccion', 'turno', 'gestion'])
            ->findOrFail($idAsignarCursoDocente);

        // Estudiantes matriculados en esta sección, turno y gestión
        $matriculados = Matriculacion::where([
            'nivelesID'           => $asignacion->nivelID,
            'gradosID'            => $asignacion->gradoID,
            'seccionID'           => $asignacion->seccionID,
            'turnoID'             => $asignacion->turnoID,
            'gestionID'           => $asignacion->gestionID,
            'estadoMatriculacion' => 'Activo',
        ])->with('estudiante')->get();

        // Periodos de la gestión del curso
        $periodos = Periodos::where('gestionID', $asignacion->gestionID)->get();

        // Aula asignada
        $aulaAsignada = AsignarSeccionesAulas::with('aula')
            ->where('seccionID', $asignacion->seccionID)
            ->where('turnoID', $asignacion->turnoID)
            ->first();

        // Calificaciones ya registradas para este curso (para mostrar historial)
        $calificaciones = Calificaciones::where('asignarCursoDocenteID', $idAsignarCursoDocente)
            ->with(['matriculacion.estudiante', 'periodo'])
            ->get()
            ->groupBy('periodoID');

        return view('admin.calificaciones.lista_estudiantes', compact(
            'asignacion', 'matriculados', 'periodos', 'aulaAsignada', 'calificaciones'
        ));
    }

    public function store(Request $request, $idAsignarCursoDocente)
    {
        $request->validate([
            'periodoID'     => 'required|integer',
            'fechaRegistro' => 'required|date',
            'notas'         => 'required|array',
        ]);

        $periodoID     = $request->periodoID;
        $fechaRegistro = $request->fechaRegistro;
        $estado        = $request->estadoGeneral ?? 'Activo';

        $guardadas = 0;
        $omitidas  = 0;

        foreach ($request->notas as $idMatriculacion => $data) {
            $nota = $data['calificacion'] ?? null;

            if ($nota === null || $nota === '') {
                $omitidas++;
                continue;
            }

            $nota    = floatval($nota);
            $literal = $this->calcularLiteral($nota);

            // Evitar duplicados: mismo curso + mismo matriculado + mismo periodo
            $existe = Calificaciones::where('asignarCursoDocenteID', $idAsignarCursoDocente)
                ->where('matriculacionID', $idMatriculacion)
                ->where('periodoID', $periodoID)
                ->exists();

            if ($existe) {
                $omitidas++;
                continue;
            }

            Calificaciones::create([
                'asignarCursoDocenteID'           => $idAsignarCursoDocente,
                'matriculacionID'                  => $idMatriculacion,
                'periodoID'                        => $periodoID,
                'calificacionCalificaciones'        => $nota,
                'calificacionLiteralCalificaciones' => $literal,
                'fechaRegistroCalificaciones'       => $fechaRegistro,
                'estadoCalificaciones'              => $estado,
            ]);

            $guardadas++;
        }

        $mensaje = "Se guardaron {$guardadas} calificaciones.";
        if ($omitidas > 0) {
            $mensaje .= " ({$omitidas} omitidas por vacías o ya existentes)";
        }

        return redirect()
            ->route('admin.calificaciones.create', $idAsignarCursoDocente)
            ->with('success', $mensaje);
    }

    public function edit($idAsignarCursoDocente, $periodoID)
    {
        $asignacion = AsignarCursosDocentes::with(['curso', 'docente', 'nivel', 'grado', 'seccion', 'turno', 'gestion'])
            ->findOrFail($idAsignarCursoDocente);

        $periodo = Periodos::findOrFail($periodoID);

        $calificaciones = Calificaciones::where('asignarCursoDocenteID', $idAsignarCursoDocente)
            ->where('periodoID', $periodoID)
            ->with('matriculacion.estudiante')
            ->get();

        $aulaAsignada = AsignarSeccionesAulas::with('aula')
            ->where('seccionID', $asignacion->seccionID)
            ->where('turnoID', $asignacion->turnoID)
            ->first();

        return view('admin.calificaciones.edit', compact('asignacion', 'periodo', 'calificaciones', 'aulaAsignada'));
    }

    public function update(Request $request, $idAsignarCursoDocente, $periodoID)
    {
        $request->validate([
            'notas' => 'required|array',
        ]);

        foreach ($request->notas as $idCalificacion => $data) {
            $notaValue = $data['calificacion'] ?? null;
            
            if ($notaValue !== null && $notaValue !== '') {
                $nota = floatval($notaValue);
                $literal = $this->calcularLiteral($nota);

                Calificaciones::where('idCalificacion', $idCalificacion)->update([
                    'calificacionCalificaciones' => $nota,
                    'calificacionLiteralCalificaciones' => $literal,
                ]);
            }
        }

        return redirect()
            ->route('admin.calificaciones.create', $idAsignarCursoDocente)
            ->with('success', 'Calificaciones actualizadas correctamente.');
    }

    /**
     * Calcula el literal según escala vigesimal.
     * C  = 0–10   (En inicio)
     * B  = 11–13  (En proceso)
     * A  = 14–17  (Logro esperado)
     * AD = 18–20  (Logro destacado)
     */
    private function calcularLiteral(float $nota): string
    {
        if ($nota >= 18) return 'AD';
        if ($nota >= 14) return 'A';
        if ($nota >= 11) return 'B';
        return 'C';
    }
}
