<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Corre la migraciones.
     */
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 50);
            $table->string('descripcion', 200);
            $table->timestamps();
        });
    }

    /**
     * Reversa las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
