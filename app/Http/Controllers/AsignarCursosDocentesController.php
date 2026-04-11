<?php

namespace App\Http\Controllers;

use App\Models\AsignarCursosDocentes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Cursos;
use App\Models\Gestion;
use App\Models\Niveles;
use App\Models\Grados;
use App\Models\Secciones;
use App\Models\Turnos;

class AsignarCursosDocentesController extends Controller
{
    public function index()
    {
        $asignaciones = AsignarCursosDocentes::with([
            'docente', 'curso', 'gestion', 'nivel', 'grado', 'seccion', 'turno'
        ])->get();

        $docentes = Personal::where('tipoPersonal', 'Docente')->get();
        if ($docentes->isEmpty()) {
            $docentes = Personal::all();
        }
        $cursos = Cursos::all();
        $gestiones = Gestion::all();
        $niveles = Niveles::all();
        $grados = Grados::all();
        $secciones = Secciones::all();
        $turnos = Turnos::all();

        return view('admin.asignaciones_curso_docente.index', compact(
            'asignaciones', 'docentes', 'cursos', 'gestiones', 'niveles', 'grados', 'secciones', 'turnos'
        ));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'docenteId' => 'required',
            'cursoID'   => 'required',
            'nivelID'   => 'required',
            'gestionID' => 'required',
            'gradoID'   => 'required',
            'turnoID'   => 'required',
            'seccionID' => 'required',
        ]);

        // Verificar si la asignación exacta ya existe
        $existe = AsignarCursosDocentes::where('docenteId', $request->docenteId)
            ->where('cursoID', $request->cursoID)
            ->where('nivelID', $request->nivelID)
            ->where('gestionID', $request->gestionID)
            ->where('gradoID', $request->gradoID)
            ->where('turnoID', $request->turnoID)
            ->where('seccionID', $request->seccionID)
            ->exists();

        if ($existe) {
            return redirect()->back()->with([
                'mensaje' => 'Este curso ya ha sido asignado a este docente en el mismo nivel, grado y sección.',
                'icono' => 'error'
            ]);
        }

        AsignarCursosDocentes::create([
            'docenteId'                 => $request->docenteId,
            'cursoID'                   => $request->cursoID,
            'nivelID'                   => $request->nivelID,
            'gestionID'                 => $request->gestionID,
            'gradoID'                   => $request->gradoID,
            'turnoID'                   => $request->turnoID,
            'seccionID'                 => $request->seccionID,
            'fechaAsignarCursoDocente'  => now()->toDateString(),
            'estadoAsignarCursoDocente' => 1
        ]);

        return redirect()->route('admin.cursos-docentes.index')->with([
            'mensaje' => 'Asignación creada correctamente',
            'icono' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'docenteId' => 'required',
            'cursoID'   => 'required',
            'nivelID'   => 'required',
            'gestionID' => 'required',
            'gradoID'   => 'required',
            'turnoID'   => 'required',
            'seccionID' => 'required',
        ]);

        $asignacion = AsignarCursosDocentes::findOrFail($id);

        $asignacion->update([
            'docenteId'  => $request->docenteId,
            'cursoID'    => $request->cursoID,
            'nivelID'    => $request->nivelID,
            'gestionID'  => $request->gestionID,
            'gradoID'    => $request->gradoID,
            'turnoID'    => $request->turnoID,
            'seccionID'  => $request->seccionID,
        ]);

        return redirect()->route('admin.cursos-docentes.index')->with([
            'mensaje' => 'Asignación actualizada correctamente',
            'icono' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $asignacion = AsignarCursosDocentes::findOrFail($id);
        $asignacion->delete();

        return redirect()->route('admin.cursos-docentes.index')->with([
            'mensaje' => 'Asignación eliminada correctamente',
            'icono' => 'success'
        ]);
    }
}
