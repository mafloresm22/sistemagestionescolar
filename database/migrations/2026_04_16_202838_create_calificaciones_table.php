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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id('idCalificacion');
            $table->unsignedBigInteger('asignarCursoDocenteID');
            $table->unsignedBigInteger('matriculacionID');
            $table->unsignedBigInteger('periodoID');
            $table->decimal('calificacionCalificaciones', 5, 2);
            $table->string('calificacionLiteralCalificaciones')->nullable();
            $table->date('fechaRegistroCalificaciones');
            $table->string('estadoCalificaciones')->default('Activo');
            $table->timestamps();

            $table->foreign('asignarCursoDocenteID')->references('idAsignarCursoDocente')->on('asignar_cursos_docentes')->cascadeOnDelete();
            $table->foreign('matriculacionID')->references('idMatriculacion')->on('matriculacions')->cascadeOnDelete();
            $table->foreign('periodoID')->references('id')->on('periodos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
