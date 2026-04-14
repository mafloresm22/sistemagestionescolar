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
        Schema::create('asistencias_detalles', function (Blueprint $table) {
            $table->id('idAsistenciasDetalle');
            $table->unsignedBigInteger('asistenciaID');
            $table->unsignedBigInteger('estudianteID');
            $table->string('estadoAsistenciasDetalle');
            $table->timestamps();

            $table->foreign('asistenciaID')->references('idAsistencia')->on('asistencias')->cascadeOnDelete();
            $table->foreign('estudianteID')->references('idEstudiante')->on('estudiantes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias_detalles');
    }
};
