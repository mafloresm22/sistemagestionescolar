<?php

namespace App\Http\Controllers;

use App\Models\Grados;
use App\Models\Niveles;
use App\Models\Periodos;
use App\Models\Secciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradosController extends Controller
{
    public function index()
    {
        $grados = Grados::with('nivel')->get();
        $niveles = Niveles::with('grados')->get();
        
        $cant_periodos = Periodos::count();
        $cant_grados = $grados->count();
        $cant_paralelos = Secciones::count();

        return view('admin.academica.index', compact('grados', 'niveles', 'cant_periodos', 'cant_grados', 'cant_paralelos'));
    }

    public function store(Request $request)
    {
         // 1. Agregamos nivelID a la validación para mayor seguridad
        $request->validate([
            'nombreGrado' => 'required|max:255',
            'nivelID' => 'required|exists:niveles,id', // Verifica que el nivel exista
        ]);

        $nombreGrado = $request->nombreGrado;
        $nivelID = $request->nivelID;

        // 2. BUSQUEDA COMBINADA: Verificamos si existe el nombre DENTRO de esa gestión específica
        $existe = Grados::where('nombreGrado', $nombreGrado)
                          ->where('nivelID', $nivelID)
                          ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El grado "' . $nombreGrado . '" ya se encuentra registrado para esta gestión.')
                ->with('icono', 'info') 
                ->withInput(); // Mantiene los datos que el usuario escribió
        }

        $grado = new Grados();
        $grado->nombreGrado = $nombreGrado;
        $grado->nivelID = $nivelID;
        $grado->save();

        return redirect()->route('admin.grados.index')
        ->with('mensaje', 'Grado creado exitosamente')
        ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreGrado' => 'required|max:255',
            'nivelID' => 'required|exists:niveles,id',
        ]);

        $nombreGrado = $request->nombreGrado;
        $nivelID = $request->nivelID;

        // Verificar duplicados (excluyendo el actual)
        $existe = Grados::where('nombreGrado', $nombreGrado)
                          ->where('nivelID', $nivelID)
                          ->where('id', '!=', $id)
                          ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El grado "' . $nombreGrado . '" ya se encuentra registrado para esta gestión.')
                ->with('icono', 'info')
                ->withInput();
        }

        $grado = Grados::findOrFail($id);
        $grado->nombreGrado = $nombreGrado;
        $grado->nivelID = $nivelID;
        $grado->save();

        return redirect()->route('admin.grados.index')
            ->with('mensaje', 'Grado actualizado correctamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $grados = Grados::findOrFail($id);
        $grados->delete();
        
        return redirect()->route('admin.grados.index')
            ->with('mensaje', 'Grado eliminado correctamente')
            ->with('icono', 'success');
    }
}
