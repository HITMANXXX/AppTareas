<?php

namespace Database\Seeders;
use App\Models\Tareas;
use App\Models\Usuarios;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * inicializa la base de datos de la aplicacion con unos datos por defecto.
     */
    public function run(): void
    {

        Tareas::factory(10)->create();
        Usuarios::factory(25)->create();

    }
}
