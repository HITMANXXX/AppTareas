<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Inertia\Inertia;
use App\Models\Tareas;
use Illuminate\Http\Request;
use DB;

class UsuariosController extends Controller
{
    //realizamos una consulta multitabla para traer los datos del usuario
    public function index()
    {
        $usuarios = Usuarios::select(
        'usuarios.id','usuarios.nombre','email',
        'telefono','tarea_id','tareas.titulo as tarea')
        ->join('tareas','tareas.id','=','usuarios.tarea_id')
        ->paginate(10);

        $tareas = Tareas::all();
        return Inertia::render('Usuarios/Index', ['usuarios' => $usuarios,
        'tareas' => $tareas]);
    }

    //Almacenamos los usuarios
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=> 'required|max:150',
            'email'=> 'required|max:80',
            'telefono'=> 'required|max:15',
            'tarea_id'=> 'required|numeric',
        ]);
        $usuario = new Usuarios($request->input());
        $usuario->save();
        return redirect()->route('usuarios.index');
    }


    //Actualizamos los usuarios
    public function update(Request $request, Usuarios $usuario)
    {
        $request->validate([
            'nombre'=> 'required|max:150',
            'email'=> 'required|max:80',
            'telefono'=> 'required|max:15',
            'tarea_id'=> 'required|numeric',
        ]);
        $usuario->update($request->input());
        return redirect()->route('usuarios.index');
    }

    //Eliminamos los usuarios
    public function destroy(Usuarios $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index');
    }

    //consulta las tareas por usuario lo utilizaremos para la grafica
    public function TareasPorUsuario()
    {
        $data = Usuarios::select(DB::raw('count(usuarios.id) as count, tareas.titulo'))
            ->join('tareas','tareas.id','=','usuarios.tarea_id')
            ->groupBy('tareas.titulo')->get();
            return Inertia::render('Usuarios/Graphic',['data' => $data]);
    }

    //consulta para los reportes de los usuarios y sus tareas
    public function reports()
    {
        $usuarios = Usuarios::select(
            'usuarios.id','usuarios.nombre','email',
            'telefono','tarea_id','tareas.titulo as tarea')
            ->join('tareas','tareas.id','=','usuarios.tarea_id')
            ->get();

            $tareas = Tareas::all();
            return Inertia::render('Usuarios/Reports', ['usuarios' => $usuarios,
            'tareas' => $tareas]);
    }

}
