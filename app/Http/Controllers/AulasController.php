<?php

namespace App\Http\Controllers;

use App\Models\Aulas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AulasController extends Controller
{
    public function index()
    {
        $aulas = Aulas::orderBy('idAulas', 'desc')->get();
        return view('admin.aulas.index', compact('aulas'));
    }

    public function store(Request $request)
    {
        $nombreAula = $request->nombreAula;
        $existe = Aulas::where('nombreAula', $nombreAula)->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'Ya existe un aula registrada con este nombre.')
                ->with('icono', 'warning');
        }

        $request->validate([
            'nombreAula' => 'required|string|max:255',
            'capacidadAula' => 'required|integer|min:1',
        ]);

        Aulas::create([
            'nombreAula' => $request->nombreAula,
            'capacidadAula' => $request->capacidadAula,
            'estadoAula' => 'Disponible'
        ]);

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Aula creada con éxito',
            'icono' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $nombreAula = $request->nombreAula;
        $existe = Aulas::where('nombreAula', $nombreAula)->where('idAulas', '!=', $id)->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'Este nombre de aula ya está siendo usado por otro salón.')
                ->with('icono', 'warning');
        }

        $request->validate([
            'nombreAula' => 'required|string|max:255',
            'capacidadAula' => 'required|integer|min:1',
        ]);

        $aula = Aulas::findOrFail($id);
        $aula->update($request->all());

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Aula actualizada con éxito',
            'icono' => 'success'
        ]);
    }

    public function toggleStatus($id)
    {
        $aula = Aulas::findOrFail($id);
        $aula->estadoAula = $aula->estadoAula == 'Disponible' ? 'Ocupado' : 'Disponible';
        $aula->save();

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Estado del aula actualizado correctamente',
            'icono' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $aula = Aulas::findOrFail($id);
        $aula->delete();

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Aula eliminada con éxito',
            'icono' => 'success'
        ]);
    }
}
