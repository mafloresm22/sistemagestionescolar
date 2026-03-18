<?php

namespace App\Http\Controllers;

use App\Models\Niveles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NivelesController extends Controller
{
    public function index()
    {
        $niveles = Niveles::all();
        return view('admin.niveles.index', compact('niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreNivel' => 'required|max:255',
        ]);

        $nombreNivel = $request->nombreNivel;
        $existe = Niveles::where('nombreNivel', $nombreNivel)->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El nivel ' . $nombreNivel . ' ya existe en el Sistema')
                ->with('icono', 'info');
        }

        $nivel = new Niveles();
        $nivel->nombreNivel = $nombreNivel;
        $nivel->save();

        return redirect()->route('admin.niveles.index')
            ->with('mensaje', 'Nivel creado exitosamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $nivel = Niveles::find($id);
        $nivel->delete();
        return redirect()->route('admin.niveles.index')
            ->with('mensaje', 'Nivel eliminado correctamente')
            ->with('icono', 'success');
    }
}
