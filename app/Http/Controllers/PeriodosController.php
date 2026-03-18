<?php

namespace App\Http\Controllers;

use App\Models\Periodos;
use App\Models\Gestion;
use App\Models\Grados;
use App\Models\Secciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeriodosController extends Controller
{
    public function index()
    {
        $periodos = Periodos::with('gestion')->get();
        $gestions = Gestion::with('periodos')->orderBy('nombreGestion', 'desc')->get();
        $cant_periodos = $periodos->count();
        $cant_grados = Grados::count();
        $cant_paralelos = Secciones::count();

        return view('admin.academica.index', compact('periodos', 'gestions', 'cant_periodos', 'cant_grados', 'cant_paralelos'));
    }

    public function store(Request $request)
    {
        // 1. Agregamos gestionID a la validación para mayor seguridad
        $request->validate([
            'nombrePeriodo' => 'required|max:255',
            'gestionID' => 'required|exists:gestions,id', // Verifica que la gestión exista
        ]);

        $nombrePeriodo = $request->nombrePeriodo;
        $gestionID = $request->gestionID;

        // 2. BUSQUEDA COMBINADA: Verificamos si existe el nombre DENTRO de esa gestión específica
        $existe = Periodos::where('nombrePeriodo', $nombrePeriodo)
                          ->where('gestionID', $gestionID)
                          ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El periodo "' . $nombrePeriodo . '" ya se encuentra registrado para esta gestión.')
                ->with('icono', 'info') 
                ->withInput(); // Mantiene los datos que el usuario escribió
        }

        $periodo = new Periodos();
        $periodo->nombrePeriodo = $nombrePeriodo;
        $periodo->gestionID = $gestionID;
        $periodo->save();

        return redirect()->route('admin.periodos.index')
        ->with('mensaje', 'Periodo creado exitosamente')
        ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombrePeriodo' => 'required|max:255',
            'gestionID' => 'required|exists:gestions,id',
        ]);

        $nombrePeriodo = $request->nombrePeriodo;
        $gestionID = $request->gestionID;

        // Verificar duplicados (excluyendo el actual)
        $existe = Periodos::where('nombrePeriodo', $nombrePeriodo)
                          ->where('gestionID', $gestionID)
                          ->where('id', '!=', $id)
                          ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El periodo "' . $nombrePeriodo . '" ya se encuentra registrado para esta gestión.')
                ->with('icono', 'info')
                ->withInput();
        }

        $periodo = Periodos::findOrFail($id);
        $periodo->nombrePeriodo = $nombrePeriodo;
        $periodo->gestionID = $gestionID;
        $periodo->save();

        return redirect()->route('admin.periodos.index')
            ->with('mensaje', 'Periodo actualizado correctamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $periodo = Periodos::findOrFail($id);
        $periodo->delete();

        return redirect()->route('admin.periodos.index')
            ->with('mensaje', 'Periodo eliminado correctamente')
            ->with('icono', 'success');
    }
}
