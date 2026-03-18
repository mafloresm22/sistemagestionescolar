<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\PadreFamilia;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::with('padreFamilia')->get();
        $padres = PadreFamilia::where('estadoPadreFamilia', 'Activo')->get();
        return view('admin.estudiantes.index', compact('estudiantes', 'padres'));
    }

    public function buscar()
    {
        $estudiantes = Estudiante::with('padreFamilia')->get();
        return view('admin.estudiantes.buscar', compact('estudiantes'));
    }

    public function store(Request $request)
    {
        // Validar primero si el DNI del alumno ya está asociado a este apoderado
        $existeEnApoderado = Estudiante::where('dniEstudiante', $request->dniEstudiante)
                                        ->where('padreFamiliaID', $request->padreFamiliaID)
                                        ->first();

        if ($existeEnApoderado) {
            return redirect()->back()->with([
                'mensaje' => 'Error: El alumno con DNI ' . $request->dniEstudiante . ' ya está registrado con este apoderado.',
                'icono' => 'warning'
            ])->withInput();
        }

        // También validamos si el alumno ya existe en el sistema (otro apoderado)
        $existeEnSistema = Estudiante::where('dniEstudiante', $request->dniEstudiante)->first();
        if ($existeEnSistema) {
            return redirect()->back()->with([
                'mensaje' => 'Error: El alumno con DNI ' . $request->dniEstudiante . ' ya se encuentra registrado en el sistema.',
                'icono' => 'error'
            ])->withInput();
        }

        $request->validate([
            'padreFamiliaID' => 'required',
            'nombreEstudiante' => 'required|string|max:150',
            'apellidoEstudiante' => 'required|string|max:150',
            'dniEstudiante' => 'required|string|size:8',
            'fechaNacimientoEstudiante' => 'required|date',
            'generoEstudiante' => 'required',
            'celularEstudiante' => 'nullable|string|max:20', 
            'correoEstudiante' => 'nullable|string|max:150',
            'direccionEstudiante' => 'nullable|string|max:255',
            'fotoEstudiante' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Normalizar Correo y Celular
        $correoInput = trim($request->correoEstudiante);
        $correoReq = strtolower($correoInput);
        $esNinguno = empty($correoInput) || $correoReq === 'ninguno' || $correoReq === 'ninguna' || $correoReq === 'sin correo';

        $emailFinal = !$esNinguno ? $correoInput : ($request->dniEstudiante . '@sistema.com');

        // Validar si el correo real ya está en uso
        if (!$esNinguno) {
            $usuarioExistente = User::where('email', $emailFinal)->first();
            if ($usuarioExistente) {
                return redirect()->back()->with([
                    'mensaje' => 'Error: El correo ' . $emailFinal . ' ya está en uso.',
                    'icono' => 'warning'
                ])->withInput();
            }
        }

        try {
            // 1. Crear el Usuario para el estudiante
            $user = User::create([
                'name' => $request->nombreEstudiante . ' ' . $request->apellidoEstudiante,
                'email' => $emailFinal,
                'password' => Hash::make($request->dniEstudiante), // DNI como contraseña
            ]);

            // Asignar rol de estudiante (asegurarse de que exista el rol ESTUDIANTE)
            $user->assignRole('ESTUDIANTE');

            $data = $request->all();
            $data['userID'] = $user->id; // Vincular con el usuario creado

            // Manejo de la foto (similar a PersonalController)
            if ($request->hasFile('fotoEstudiante')) {
                $file = $request->file('fotoEstudiante');
                if ($file->isValid()) {
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/estudiantes');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    
                    $file->move($destinationPath, $filename);
                    $data['fotoEstudiante'] = 'uploads/estudiantes/' . $filename;
                }
            }

            // Aseguramos valores por defecto si vienen vacíos o son 'Ninguno'
            $data['correoEstudiante'] = $esNinguno ? 'Sin correo' : $correoInput;
            $data['direccionEstudiante'] = $request->direccionEstudiante ?? 'Sin dirección';
            
            $celularInput = trim($request->celularEstudiante);
            $celularReq = strtolower($celularInput);
            if (empty($celularInput) || $celularReq === 'ninguno' || $celularReq === '0') {
                $data['celularEstudiante'] = '0';
            } else {
                $data['celularEstudiante'] = $celularInput;
            }

            $data['estadoEstudiante'] = 'Activo';

            Estudiante::create($data);

            return redirect()->back()->with([
                'mensaje' => 'Alumno registrado correctamente',
                'icono' => 'success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'mensaje' => 'Ocurrió un error al registrar: ' . $e->getMessage(),
                'icono' => 'error'
            ])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        // Validar si el DNI ya existe en otro estudiante
        $existeDni = Estudiante::where('dniEstudiante', $request->dniEstudiante)
            ->where('idEstudiante', '!=', $id)
            ->first();

        if ($existeDni) {
            return redirect()->back()->with([
                'mensaje' => 'Error: El DNI ' . $request->dniEstudiante . ' ya pertenece a otro estudiante.',
                'icono' => 'warning'
            ])->withInput();
        }

        $request->validate([
            'padreFamiliaID' => 'required',
            'nombreEstudiante' => 'required|string|max:150',
            'apellidoEstudiante' => 'required|string|max:150',
            'dniEstudiante' => 'required|string|size:8',
            'fechaNacimientoEstudiante' => 'required|date',
            'generoEstudiante' => 'required',
            'celularEstudiante' => 'nullable|string|max:20',
            'correoEstudiante' => 'nullable|string|max:150',
            'direccionEstudiante' => 'nullable|string|max:255',
            'fotoEstudiante' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            // Actualizar Usuario vinculado
            if ($estudiante->userID) {
                $user = User::find($estudiante->userID);
                if ($user) {
                    $correoInput = trim($request->correoEstudiante);
                    $correoReq = strtolower($correoInput);
                    $esNinguno = empty($correoInput) || $correoReq === 'ninguno' || $correoReq === 'ninguna' || $correoReq === 'sin correo';

                    $emailFinal = !$esNinguno ? $correoInput : ($request->dniEstudiante . '@sistema.com');
                    
                    // Validar si el nuevo correo real ya está en uso por otro usuario
                    if (!$esNinguno) {
                        $otroUsuario = User::where('email', $emailFinal)->where('id', '!=', $user->id)->first();
                        if ($otroUsuario) {
                            return redirect()->back()->with([
                                'mensaje' => 'Error: El correo ' . $emailFinal . ' ya está en uso.',
                                'icono' => 'warning'
                            ])->withInput();
                        }
                    }

                    $user->update([
                        'name' => $request->nombreEstudiante . ' ' . $request->apellidoEstudiante,
                        'email' => $emailFinal,
                    ]);
                }
            }

            $data = $request->all();

            // Manejo de la foto
            if ($request->hasFile('fotoEstudiante')) {
                // Eliminar foto anterior si existe
                if ($estudiante->fotoEstudiante && file_exists(public_path($estudiante->fotoEstudiante))) {
                    unlink(public_path($estudiante->fotoEstudiante));
                }

                $file = $request->file('fotoEstudiante');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/estudiantes');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                $file->move($destinationPath, $filename);
                $data['fotoEstudiante'] = 'uploads/estudiantes/' . $filename;
            }

            // Aseguramos valores por defecto si vienen vacíos o son 'Ninguno'
            $data['correoEstudiante'] = $esNinguno ? 'Sin correo' : $correoInput;
            $data['direccionEstudiante'] = $request->direccionEstudiante ?? 'Sin dirección';
            
            $celularInput = trim($request->celularEstudiante);
            $celularReq = strtolower($celularInput);
            if (empty($celularInput) || $celularReq === 'ninguno' || $celularReq === '0') {
                $data['celularEstudiante'] = '0';
            } else {
                $data['celularEstudiante'] = $celularInput;
            }

            $estudiante->update($data);

            return redirect()->back()->with([
                'mensaje' => 'Estudiante actualizado correctamente',
                'icono' => 'success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'mensaje' => 'Ocurrió un error al actualizar: ' . $e->getMessage(),
                'icono' => 'error'
            ])->withInput();
        }
    }

    public function show($idEstudiante)
    {
        $estudiante = Estudiante::with('padreFamilia')->findOrFail($idEstudiante);
        return response()->json($estudiante);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);
            
            // Recibimos el estado enviado por JS, por defecto si no hay, asume 'Inactivo'
            $nuevoEstado = $request->input('nuevoEstado', 'Inactivo');
            
            $estudiante->estadoEstudiante = $nuevoEstado;
            $estudiante->save();

            $mensajeStr = $nuevoEstado === 'Activo' 
                ? '¡Estudiante reactivado correctamente!' 
                : '¡Estudiante inhabilitado correctamente!';

            return redirect()->back()->with([
                'mensaje' => $mensajeStr,
                'icono' => 'success'
            ]);
                
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'mensaje' => 'Error al cambiar de estado: ' . $e->getMessage(),
                'icono' => 'error'
            ]);
        }
    }
}
