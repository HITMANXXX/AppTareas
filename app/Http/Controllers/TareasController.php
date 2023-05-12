<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Tareas;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    //Listamos todas las tareas
    public function index()
    {
        $tareas = Tareas::all();
        return Inertia::render('Tareas/Index', ['tareas' => $tareas]);
    }

    //Crearemos las tareas por vistas separadas
    public function create()
    {
        return Inertia::render('Tareas/Create');
    }

    //Guardamos las tareas y validamos que sus campos sean requeridos
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:30',
            'descripcion' => 'required|max:200',
        ]);
        $tarea = new Tareas($request->input());
        $tarea->save();
        return redirect('tareas');
    }


    //Editar las tareas por vistas separadas
    public function edit(Tareas $tarea)
    {
        return Inertia::render('Tareas/Edit', ['tarea' => $tarea]);
    }

    //Actualizar las tareas ya registradas en base de datos
    public function update(Request $request, Tareas $tarea)
    {
        $request->validate([
            'titulo' => 'required|max:30',
            'descripcion' => 'required|max:200',
        ]);
        $tarea->update($request->all());
        return redirect('tareas');
    }

    //Eliminar las tareas ya registradas en base de datos
    public function destroy(Tareas $tarea)
    {
       $tarea->delete();
       return redirect('tareas');
    }
}
