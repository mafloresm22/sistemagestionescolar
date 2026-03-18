<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuraciones;
class ConfiguracionesController extends Controller
{
    public function index()
    {
        $divisas = json_decode(file_get_contents(base_path('api/divisas.json')), true);
        $configuraciones = Configuraciones::first();
        return view('admin.configuraciones.index', compact('configuraciones', 'divisas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'logoConfiguraciones' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nombreConfiguraciones' => 'required',
            'direccionConfiguraciones' => 'required',
        ]);

        $configuraciones = Configuraciones::first();

        //ACTUALIZAR CONFIGURACIONES
        if($configuraciones){
           $configuraciones->nombreConfiguraciones = $request->nombreConfiguraciones;
           $configuraciones->direccionConfiguraciones = $request->direccionConfiguraciones;
           $configuraciones->telefonoConfiguraciones = $request->telefonoConfiguraciones;
           $configuraciones->correoInstitucionalConfiguraciones = $request->correoInstitucionalConfiguraciones;
           $configuraciones->descripcionConfiguraciones = $request->descripcionConfiguraciones;
           $configuraciones->webConfiguraciones = $request->webConfiguraciones;
           $configuraciones->divisaConfiguraciones = $request->divisaConfiguraciones;

           //PARA ELIMINAR EL LOGO ANTERIOR
           if($request->hasFile('logoConfiguraciones')){
               if($configuraciones->logoConfiguraciones){
                   unlink(public_path($configuraciones->logoConfiguraciones));
               }
               $logoPath = $request->file('logoConfiguraciones');
               $nombrelogo = time() . '_' . $logoPath->getClientOriginalName();
               $moverlogo = public_path('uploads/logos');
               $logoPath->move($moverlogo, $nombrelogo);
               $configuraciones->logoConfiguraciones = 'uploads/logos/' . $nombrelogo;
           }

           $configuraciones->save();
           return redirect()->route('admin.configuraciones.index')
           ->with('mensaje', 'Configuración actualizada correctamente')
           ->with('icono', 'success');
        }else{
            //CREAR NUEVAS O GUARGAR CONFIGURACIONES
            $configuraciones = new Configuraciones();
            $configuraciones->nombreConfiguraciones = $request->nombreConfiguraciones;
            $configuraciones->direccionConfiguraciones = $request->direccionConfiguraciones;
            $configuraciones->telefonoConfiguraciones = $request->telefonoConfiguraciones;
            $configuraciones->correoInstitucionalConfiguraciones = $request->correoInstitucionalConfiguraciones;
            $configuraciones->descripcionConfiguraciones = $request->descripcionConfiguraciones;
            $configuraciones->webConfiguraciones = $request->webConfiguraciones;
            $configuraciones->divisaConfiguraciones = $request->divisaConfiguraciones;

            //GUARDAR EL LOGO
            if($request->hasFile('logoConfiguraciones')){
                $logoPath = $request->file('logoConfiguraciones');
                $nombrelogo = time() . '_' . $logoPath->getClientOriginalName();
                $moverlogo = public_path('uploads/logos');
                $logoPath->move($moverlogo, $nombrelogo);
                $configuraciones->logoConfiguraciones = 'uploads/logos/' . $nombrelogo;
            }

            $configuraciones->save();
            return redirect()->route('admin.configuraciones.index')
            ->with('mensaje', 'Configuración creada correctamente')
            ->with('icono', 'success');
        }
    }
}
