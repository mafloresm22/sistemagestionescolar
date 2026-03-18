<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::all();
        return view('admin.gestiones.index', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreGestion' => 'required|max:255',
        ]);

        $nombreGestion = $request->nombreGestion;
        $existe = Gestion::where('nombreGestion', $nombreGestion)->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'La gestión ' . $nombreGestion . ' ya existe en el sistema')
                ->with('icono', 'error');
        }

        $gestion = new Gestion();
        $gestion->nombreGestion = $nombreGestion;
        $gestion->save();

        return redirect()->route('admin.gestiones.index')
            ->with('mensaje', 'Gestion creada exitosamente')
            ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreGestion' => 'required|max:255',
        ]);

        $nombreGestion = $request->nombreGestion;
        $existe = Gestion::where('nombreGestion', $nombreGestion)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'La gestión ' . $nombreGestion . ' ya existe en el sistema')
                ->with('icono', 'error');
        }

        $gestion = Gestion::find($id);
        $gestion->nombreGestion = $nombreGestion;
        $gestion->save();

        return redirect()->route('admin.gestiones.index')
            ->with('mensaje', 'Gestión actualizada correctamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $gestion = Gestion::find($id);
        $gestion->delete();
        return redirect()->route('admin.gestiones.index')
        ->with('mensaje', 'Gestión eliminada correctamente')
        ->with('icono', 'success');
    }
}
