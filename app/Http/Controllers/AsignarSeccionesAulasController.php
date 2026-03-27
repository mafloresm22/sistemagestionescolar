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
         $gestiones = Gestion::all();
         $turnos = Turnos::all();
         $personals = Personal::where('tipoPersonal', 'Docente')->get();
         
         $asignaciones = AsignarSeccionesAulas::with(['aula', 'seccion.grados.nivel', 'gestion', 'turno', 'personal'])->get();
 
         return view('admin.aulas.asignacion.index', compact('aulas', 'secciones', 'gestiones', 'turnos', 'personals', 'asignaciones'));
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'aulaID' => 'required',
             'seccionID' => 'required',
             'gestionID' => 'required',
             'turnoID' => 'required',
             'personalID' => 'required',
         ]);
 
         $asignacion = new AsignarSeccionesAulas();
         $asignacion->aulaID = $request->aulaID;
         $asignacion->seccionID = $request->seccionID;
         $asignacion->gestionID = $request->gestionID;
         $asignacion->turnoID = $request->turnoID;
         $asignacion->personalID = $request->personalID;
         $asignacion->observacionesAsignarSeccionAula = $request->observacionesAsignarSeccionAula;
         $asignacion->estadoAsignarSeccionAula = 'Activo';
         $asignacion->save();
 
         return redirect()->route('admin.asignar-secciones-aulas.index')
             ->with('mensaje', 'Se asignó el aula correctamente')
             ->with('icono', 'success');
     }
 
     /**
      * Display the specified resource.
      */
     public function show(AsignarSeccionesAulas $asignarSeccionesAulas)
     {
         //
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit($id)
     {
         //
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, $id)
     {
         $request->validate([
            'aulaID' => 'required',
            'seccionID' => 'required',
            'gestionID' => 'required',
            'turnoID' => 'required',
            'personalID' => 'required',
        ]);

        $asignacion = AsignarSeccionesAulas::findOrFail($id);
        $asignacion->aulaID = $request->aulaID;
        $asignacion->seccionID = $request->seccionID;
        $asignacion->gestionID = $request->gestionID;
        $asignacion->turnoID = $request->turnoID;
        $asignacion->personalID = $request->personalID;
        $asignacion->observacionesAsignarSeccionAula = $request->observacionesAsignarSeccionAula;
        $asignacion->save();

        return redirect()->route('admin.asignar-secciones-aulas.index')
            ->with('mensaje', 'Se actualizó la asignación correctamente')
            ->with('icono', 'success');
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy($id)
     {
         AsignarSeccionesAulas::destroy($id);
         return redirect()->route('admin.asignar-secciones-aulas.index')
             ->with('mensaje', 'Se eliminó la asignación correctamente')
             ->with('icono', 'success');
     }
 }
