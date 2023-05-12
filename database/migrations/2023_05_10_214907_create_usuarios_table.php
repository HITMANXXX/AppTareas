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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('email', 80);
            $table->string('telefono', 20);
            $table->foreignId('tarea_id')
            ->constrained('tareas')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reversa las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
