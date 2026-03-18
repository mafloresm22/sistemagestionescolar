<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PersonalController extends Controller
{
    public function index($tipoPersonal)
    {
        $personal = Personal::where('tipoPersonal', $tipoPersonal)->get();
        $roles = Role::all();
        return view('admin.personal.index', compact('personal', 'tipoPersonal', 'roles'));
    }

    public function store(Request $request, $tipoPersonal)
    {
        $request->validate([
            'nombrePersonal' => 'required|string|max:100',
            'apellidoPersonal' => 'required|string|max:100',
            'dniPersonal' => 'required|string|size:8',
            'fechaNacimientoPersonal' => 'required|date',
            'generoPersonal' => 'required',
            'celularPersonal' => 'nullable|string|max:9',
            'emailPersonal' => 'required|email|max:100',
            'profesionPersonal' => 'nullable|string|max:100',
            'role' => 'required',
            'fotoPersonal' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 1. Validar si ya existe el personal por DNI
        $existeDNI = Personal::where('dniPersonal', $request->dniPersonal)->first();
        if ($existeDNI) {
            return redirect()->back()
                ->with('mensaje', 'El DNI ' . $request->dniPersonal . ' ya se encuentra registrado.')
                ->with('icono', 'warning')
                ->withInput();
        }

        // 2. Validar si el correo ya está en uso en la tabla de usuarios
        $existeEmail = User::where('email', $request->emailPersonal)->first();
        if ($existeEmail) {
            return redirect()->back()
                ->with('mensaje', 'El correo ' . $request->emailPersonal . ' ya está siendo usado por otro usuario.')
                ->with('icono', 'warning')
                ->withInput();
        }

        try {
            // 3. Crear el Usuario
            $user = User::create([
                'name' => $request->nombrePersonal . ' ' . $request->apellidoPersonal,
                'email' => $request->emailPersonal,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);

            // 4. Manejar la Foto
            $fotoPath = null;
            if ($request->hasFile('fotoPersonal')) {
                $file = $request->file('fotoPersonal');
                if ($file->isValid()) {
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/personal');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $file->move($destinationPath, $filename);
                    $fotoPath = 'uploads/personal/' . $filename;
                }
            }

            // 5. Crear el Registro de Personal
            Personal::create([
                'nombrePersonal' => $request->nombrePersonal,
                'apellidoPersonal' => $request->apellidoPersonal,
                'dniPersonal' => $request->dniPersonal,
                'fechaNacimientoPersonal' => $request->fechaNacimientoPersonal,
                'generoPersonal' => $request->generoPersonal,
                'celularPersonal' => $request->celularPersonal,
                'emailPersonal' => $request->emailPersonal,
                'profesionPersonal' => $request->profesionPersonal,
                'tipoPersonal' => ucfirst($tipoPersonal),
                'estadoPersonal' => 'Activo',
                'fotoPersonal' => $fotoPath,
                'userID' => $user->id,
            ]);


            return redirect()->back()
                ->with('mensaje', '¡Registro exitoso! ' . ucfirst($tipoPersonal) . ' guardado correctamente.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al registrar: ' . $e->getMessage())
                ->with('icono', 'error')
                ->withInput();
        }
    }

    public function show($id)
    {
        $personal = Personal::findOrFail($id);
        
        // Buscar el rol del usuario directamente para evitar problemas con la relación Eloquent
        $user = User::find($personal->userID);
        $roleName = '';
        if ($user && $user->roles->count() > 0) {
            $roleName = $user->roles->first()->name;
        }

        $datos = $personal->toArray();
        $datos['role_name'] = $roleName;

        return response()->json($datos);
    }

    public function update(Request $request, $id)
    {
        $personal = Personal::findOrFail($id);

        $request->validate([
            'nombrePersonal' => 'required',
            'apellidoPersonal' => 'required',
            'dniPersonal' => 'required|max:8',
            'emailPersonal' => 'required|email',
            'generoPersonal' => 'required',
            'fechaNacimientoPersonal' => 'required',
            'role' => 'required',
            'password' => 'nullable|min:8'
        ]);

        $tipoPersonal = strtolower($personal->tipoPersonal); // Mantenemos el tipo actual si es docente/admin

        try {
            // Verificar DNI duplicado (que no sea el de este personal)
            $dniExiste = Personal::where('dniPersonal', $request->dniPersonal)
                                 ->where('idPersonal', '!=', $id)
                                 ->exists();
            if ($dniExiste) {
                return redirect()->back()
                    ->with('mensaje', 'El DNI ya está registrado en otro personal')
                    ->with('icono', 'warning');
            }

            // Verificar Email duplicado en la tabla Users
            $usuario = User::find($personal->userID);
            $emailExiste = User::where('email', $request->emailPersonal)
                               ->where('id', '!=', $usuario->id)
                               ->exists();
            if ($emailExiste) {
                return redirect()->back()
                    ->with('mensaje', 'El correo electrónico ya está registrado en otro usuario')
                    ->with('icono', 'warning');
            }

            // Actualizar la Foto si mandó una nueva
            $foto = $personal->fotoPersonal;
            if ($request->hasFile('fotoPersonal')) {
                // Borrar foto anterior si existe
                if ($foto && file_exists(public_path($foto))) {
                    unlink(public_path($foto));
                }
                
                $archivo = $request->file('fotoPersonal');
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $rutaDestino = public_path('images/personal');
                
                if (!file_exists($rutaDestino)) {
                    mkdir($rutaDestino, 0777, true);
                }
                
                $archivo->move($rutaDestino, $nombreArchivo);
                $foto = 'images/personal/' . $nombreArchivo;
            }

            // Actualizar Personal
            $personal->nombrePersonal = $request->nombrePersonal;
            $personal->apellidoPersonal = $request->apellidoPersonal;
            $personal->dniPersonal = $request->dniPersonal;
            $personal->profesionPersonal = $request->profesionPersonal;
            $personal->emailPersonal = $request->emailPersonal;
            $personal->generoPersonal = $request->generoPersonal;
            $personal->fechaNacimientoPersonal = $request->fechaNacimientoPersonal;
            $personal->celularPersonal = $request->celularPersonal;
            $personal->fotoPersonal = $foto;
            $personal->save();

            // Actualizar el Usuario asociado y rol
            if ($usuario) {
                $usuario->name = $request->nombrePersonal . ' ' . $request->apellidoPersonal;
                $usuario->email = $request->emailPersonal;
                
                // Si mandó una nueva contraseña, la actualizamos
                if ($request->filled('password')) {
                    $usuario->password = Hash::make($request->password);
                }

                $usuario->save();
                
                $usuario->syncRoles([$request->role]);
            }

            return redirect()->back()
                ->with('mensaje', '¡Actualización exitosa! ' . ucfirst($tipoPersonal) . ' actualizado correctamente.')
                ->with('icono', 'success');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Ocurrió un error al actualizar los datos: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $personal = Personal::findOrFail($id);
            
            // Recibimos el estado enviado por JS, por defecto si no hay, asume 'Inactivo'
            $nuevoEstado = $request->input('nuevoEstado', 'Inactivo');
            
            $personal->estadoPersonal = $nuevoEstado;
            $personal->save();

            $tipoPersonal = strtolower($personal->tipoPersonal);
            
            $mensajeStr = $nuevoEstado === 'Activo' 
                ? '¡Registro reactivado! El estado del personal cambió a Activo.' 
                : '¡Registro inhabilitado! El estado del personal cambió a Inactivo.';

            return redirect()->route('admin.personal.index', ['tipoPersonal' => $tipoPersonal])
                ->with('mensaje', $mensajeStr)
                ->with('icono', 'success');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al cambiar de estado: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }
}
