<?php

namespace App\Http\Controllers;

use App\Models\Turnos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TurnosController extends Controller
{
    public function index()
    {
        $turnos = Turnos::all();
        return view('admin.turnos.index', compact('turnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreTurno' => 'required|string|max:255|unique:turnos,nombreTurno',
        ]);

        Turnos::create($request->all());

        return redirect()->route('admin.turnos.index')
            ->with('mensaje', 'Turno creado exitosamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $turno = Turnos::findOrFail($id);
        $turno->delete();

        return redirect()->route('admin.turnos.index')
            ->with('mensaje', 'Turno eliminado exitosamente')
            ->with('icono', 'success');
    }
}
