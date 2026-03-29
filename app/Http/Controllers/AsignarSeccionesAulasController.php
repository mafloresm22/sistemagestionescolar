<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\AsignarSeccionesAulas;
 use App\Models\Aulas;
 use App\Models\Secciones;
 use App\Models\Gestion;
 use App\Models\Turnos;
 use App\Models\Personal;
 use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;
 
 class AsignarSeccionesAulasController extends Controller
 {
     public function index()
     {
         $aulas = Aulas::where('estadoAula', 'Disponible')->get();
         $secciones = Secciones::with('grados.nivel')->get();
         $gestions = Gestion::all();
         $turnos = Turnos::all();
         $personals = Personal::where('tipoPersonal', 'Docente')->get();
         
         $asignaciones = AsignarSeccionesAulas::with(['aula', 'seccion.grados.nivel', 'gestion', 'turno', 'personal'])->get();
 
         return view('admin.aulas.asignacion.index', compact('aulas', 'secciones', 'gestions', 'turnos', 'personals', 'asignaciones'));
     }
 
     public function store(Request $request)
    {
        // 1. Validación estricta
        $request->validate([
            'aulaID'     => 'required|integer|exists:aulas,idAulas',
            'seccionID'  => 'required|integer|exists:secciones,idSeccion',
            'gestionID'  => 'required|integer|exists:gestions,id',
            'turnoID'    => 'required|integer|exists:turnos,id',
            'personalID' => 'required|integer|exists:personals,idPersonal',
        ]);

        // 2. Comprobar cruces/conflictos lógicos
    
        // El Aula ya está ocupada en ese turno/gestión?
        $existeAulaOcupada = AsignarSeccionesAulas::where('aulaID', $request->aulaID)
            ->where('gestionID', $request->gestionID)
            ->where('turnoID', $request->turnoID)
            ->exists();

        if ($existeAulaOcupada) {
            return redirect()->back()->withInput()->with([
                'mensaje' => 'El aula ya está asignada a otra sección en este turno y gestión.',
                'icono'   => 'error'
            ]);
        }

        // El Docente ya tiene clase en ese turno/gestión?
        $existeDocenteOcupado = AsignarSeccionesAulas::where('personalID', $request->personalID)
            ->where('gestionID', $request->gestionID)
            ->where('turnoID', $request->turnoID)
            ->exists();

        if ($existeDocenteOcupado) {
            return redirect()->back()->withInput()->with([
                'mensaje' => 'El docente ya tiene una asignación en este turno y gestión.',
                'icono'   => 'error'
            ]);
        }

        // La Sección ya tiene aula asignada en ese turno/gestión?
        $existeSeccionOcupada = AsignarSeccionesAulas::where('seccionID', $request->seccionID)
            ->where('gestionID', $request->gestionID)
            ->where('turnoID', $request->turnoID)
            ->exists();

        if ($existeSeccionOcupada) {
            return redirect()->back()->withInput()->with([
                'mensaje' => 'Esta sección ya tiene un aula asignada para este turno y gestión.',
                'icono'   => 'error'
            ]);
        }

        // 3. Creación simplificada
        AsignarSeccionesAulas::create([
            'aulaID'     => $request->aulaID,
            'seccionID'  => $request->seccionID,
            'gestionID'  => $request->gestionID,
            'turnoID'    => $request->turnoID,
            'personalID' => $request->personalID,
            'observacionesAsignarSeccionAula' => $request->observacionesAsignarSeccionAula,
            'estadoAsignarSeccionAula'        => 'Activo',
        ]);

        return redirect()->route('admin.asignar-secciones-aulas.index')
        ->with('mensaje', 'Se realizó la asignación correctamente')
        ->with('icono', 'success');
    }

 
     public function update(Request $request, $idAsignarSeccionAula)
    {
        // 1. Validación estricta
        $request->validate([
            'aulaID'     => 'required|integer|exists:aulas,idAulas',
            'seccionID'  => 'required|integer|exists:secciones,idSeccion',
            'gestionID'  => 'required|integer|exists:gestions,id',
            'turnoID'    => 'required|integer|exists:turnos,id',
            'personalID' => 'required|integer|exists:personals,idPersonal',
        ]);

        // 2. Comprobar cruces/conflictos (excluyendo el registro actual)

        // El Aula ya está ocupada por OTRA asignación en ese turno/gestión?
        $existeAulaOcupada = AsignarSeccionesAulas::where('aulaID', $request->aulaID)
            ->where('gestionID', $request->gestionID)
            ->where('turnoID', $request->turnoID)
            ->where('idAsignarSeccionAula', '!=', $idAsignarSeccionAula)
            ->exists();

        if ($existeAulaOcupada) {
            return redirect()->back()->withInput()->with([
                'mensaje' => 'El aula ya está asignada a otra sección en este turno y gestión.',
                'icono'   => 'error'
            ]);
        }

        // El Docente ya tiene clase en OTRA aula en ese turno/gestión?
        $existeDocenteOcupado = AsignarSeccionesAulas::where('personalID', $request->personalID)
            ->where('gestionID', $request->gestionID)
            ->where('turnoID', $request->turnoID)
            ->where('idAsignarSeccionAula', '!=', $idAsignarSeccionAula)
            ->exists();

        if ($existeDocenteOcupado) {
            return redirect()->back()->withInput()->with([
                'mensaje' => 'El docente ya tiene una asignación en este turno y gestión.',
                'icono'   => 'error'
            ]);
        }

        // La Sección ya tiene OTRA aula asignada en ese turno/gestión?
        $existeSeccionOcupada = AsignarSeccionesAulas::where('seccionID', $request->seccionID)
            ->where('gestionID', $request->gestionID)
            ->where('turnoID', $request->turnoID)
            ->where('idAsignarSeccionAula', '!=', $idAsignarSeccionAula)
            ->exists();

        if ($existeSeccionOcupada) {
            return redirect()->back()->withInput()->with([
                'mensaje' => 'Esta sección ya tiene un aula asignada para este turno y gestión.',
                'icono'   => 'error'
            ]);
        }

        // 3. Actualización simplificada
        $asignacion = AsignarSeccionesAulas::findOrFail($idAsignarSeccionAula);
        $asignacion->update([
            'aulaID'     => $request->aulaID,
            'seccionID'  => $request->seccionID,
            'gestionID'  => $request->gestionID,
            'turnoID'    => $request->turnoID,
            'personalID' => $request->personalID,
            'observacionesAsignarSeccionAula' => $request->observacionesAsignarSeccionAula,
        ]);

        return redirect()->route('admin.asignar-secciones-aulas.index')
            ->with('mensaje', 'Se actualizó la asignación correctamente')
            ->with('icono', 'success');
    }

    public function destroy($idAsignarSeccionAula)
    {
        AsignarSeccionesAulas::destroy($idAsignarSeccionAula);
        return redirect()->route('admin.asignar-secciones-aulas.index')
            ->with('mensaje', 'Se eliminó la asignación correctamente')
             ->with('icono', 'success');
     }
 }
