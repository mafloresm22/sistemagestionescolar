<?php

namespace App\Http\Controllers;

use App\Models\Secciones;
use App\Models\Grados;
use App\Models\Periodos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    public function index()
    {
        $grados = Grados::with('secciones', 'nivel')->get();
        $secciones = Secciones::with('grados')->get();
        
        $cant_periodos = Periodos::count();
        $cant_grados = Grados::count();
        $cant_paralelos = $secciones->count();

        // Envia todos los datos a la vista general index
        return view('admin.academica.index', compact('grados', 'secciones', 'cant_periodos', 'cant_grados', 'cant_paralelos'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombreSeccion' => 'required|max:255',
            'gradoID' => 'required|exists:grados,id', 
        ]);

        $nombreSeccion = $request->nombreSeccion;
        $gradoID = $request->gradoID;

        $existe = Secciones::where('nombreSeccion', $nombreSeccion)
                          ->where('gradoID', $gradoID)
                          ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'La sección "' . $nombreSeccion . '" ya se encuentra registrada para este grado.')
                ->with('icono', 'info') 
                ->withInput(); 
        }

        $seccion = new Secciones();
        $seccion->nombreSeccion = $nombreSeccion;
        $seccion->gradoID = $gradoID;
        $seccion->save();

        return redirect()->route('admin.secciones.index')
        ->with('mensaje', 'Sección creada exitosamente')
        ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreSeccion' => 'required|max:255',
            'gradoID' => 'required|exists:grados,id',
        ]);

        $nombreSeccion = $request->nombreSeccion;
        $gradoID = $request->gradoID;

        $existe = Secciones::where('nombreSeccion', $nombreSeccion)
                          ->where('gradoID', $gradoID)
                          ->where('idSeccion', '!=', $id)
                          ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'La sección "' . $nombreSeccion . '" ya se encuentra registrada para este grado.')
                ->with('icono', 'info')
                ->withInput();
        }

        $seccion = Secciones::findOrFail($id);
        $seccion->nombreSeccion = $nombreSeccion;
        $seccion->gradoID = $gradoID;
        $seccion->save();

        return redirect()->route('admin.secciones.index')
            ->with('mensaje', 'Sección actualizada correctamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $seccion = Secciones::findOrFail($id);
        $seccion->delete();
        
        return redirect()->route('admin.secciones.index')
            ->with('mensaje', 'Sección eliminada correctamente')
            ->with('icono', 'success');
    }
}
