<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cursos;
use App\Models\Personal;

class AdminController extends Controller
{
    public function index()
    {
        $cursosCount = Cursos::where('estado', 'Activo')->count();
        $administrativosCount = Personal::where('tipoPersonal', 'Administrativo')->count();
        return view('admin.index', compact('cursosCount', 'administrativosCount'));
    }
}
