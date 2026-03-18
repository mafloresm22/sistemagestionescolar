<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $nombreRol = $request->name;
        $existe = Role::where('name', $nombreRol)->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El rol ' . $nombreRol . ' ya existe en el Sistema')
                ->with('icono', 'info');
        }

        Role::create(['name' => $nombreRol]);

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Rol creado exitosamente')
            ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $nombreRol = $request->name;
        $existe = Role::where('name', $nombreRol)->where('id', '!=', $id)->exists();

        if ($existe) {
            return redirect()->back()
                ->with('mensaje', 'El rol ' . $nombreRol . ' ya existe en el Sistema')
                ->with('icono', 'info');
        }

        $role = Role::findById($id);
        $role->name = $nombreRol;
        $role->save();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Rol actualizado exitosamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Rol eliminado exitosamente')
            ->with('icono', 'success');
    }
}
