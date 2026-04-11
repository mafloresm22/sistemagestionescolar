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

    public function permisos($id)
    {
        $role = Role::findById($id);
        
        $rutas = \Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName();
        $permisosAgrupados = [];
        
        foreach ($rutas as $nombreRuta => $ruta) {
            if (is_string($nombreRuta) && str_starts_with($nombreRuta, 'admin.')) {
                \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $nombreRuta, 'guard_name' => 'web']);
                
                $partes = explode('.', $nombreRuta);
                $grupo = isset($partes[1]) ? $partes[1] : 'general';
                
                $permisosAgrupados[$grupo][] = $nombreRuta;
            }
        }

        return view('admin.roles.permisos', compact('role', 'permisosAgrupados'));
    }

    public function assignPermisos(Request $request, $id)
    {
        $role = Role::findById($id);
        
        // $request->permisos vendrá como un array de los checkboxes que se marcaron
        $permisosEnviados = $request->input('permisos', []);
        
        // Spatie hace el trabajo por nosotros: borrará los no marcados y guardará los nuevos
        $role->syncPermissions($permisosEnviados);

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Permisos asignados correctamente al rol ' . strtoupper($role->name))
            ->with('icono', 'success');
    }

    public function assignAllPermisos($id)
    {
        $role = Role::findById($id);
        
        $rutas = \Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName();
        foreach ($rutas as $nombreRuta => $ruta) {
            if (is_string($nombreRuta) && str_starts_with($nombreRuta, 'admin.')) {
                \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $nombreRuta, 'guard_name' => 'web']);
            }
        }
        
        $todosLosPermisos = \Spatie\Permission\Models\Permission::all();
        $role->syncPermissions($todosLosPermisos);

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Se asignaron TODOS los permisos al rol ' . strtoupper($role->name))
            ->with('icono', 'success');
    }
}
