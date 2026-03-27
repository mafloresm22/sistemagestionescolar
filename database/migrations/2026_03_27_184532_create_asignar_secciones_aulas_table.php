<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asignar_secciones_aulas', function (Blueprint $table) {
            $table->id('idAsignarSeccionAula');
            
            $table->unsignedBigInteger('seccionID');
            $table->unsignedBigInteger('aulaID');
            $table->unsignedBigInteger('gestionID');
            $table->unsignedBigInteger('turnoID');
            $table->unsignedBigInteger('personalID');
            
            $table->text('observacionesAsignarSeccionAula')->nullable();
            $table->string('estadoAsignarSeccionAula', 20)->default('Activo');

            $table->foreign('seccionID')->references('idSeccion')->on('secciones')->cascadeOnDelete();
            $table->foreign('aulaID')->references('idAulas')->on('aulas')->cascadeOnDelete();
            $table->foreign('gestionID')->references('idGestion')->on('gestiones')->cascadeOnDelete();
            $table->foreign('turnoID')->references('idTurno')->on('turnos')->cascadeOnDelete();
            $table->foreign('personalID')->references('idPersonal')->on('personal')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignar_secciones_aulas');
    }
};
