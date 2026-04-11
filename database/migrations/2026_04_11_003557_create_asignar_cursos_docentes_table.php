<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignar_cursos_docentes', function (Blueprint $table) {
            $table->id('idAsignarCursoDocente');
            $table->unsignedBigInteger('docenteId');
            $table->unsignedBigInteger('cursoID');
            $table->unsignedBigInteger('nivelID');
            $table->unsignedBigInteger('gestionID');
            $table->unsignedBigInteger('gradoID');
            $table->unsignedBigInteger('turnoID');
            $table->unsignedBigInteger('seccionID');

            $table->foreign('docenteId')->references('idPersonal')->on('personals')->cascadeOnDelete();
            $table->foreign('cursoID')->references('idCurso')->on('cursos')->cascadeOnDelete();
            $table->foreign('nivelID')->references('id')->on('niveles')->cascadeOnDelete();
            $table->foreign('gestionID')->references('id')->on('gestions')->cascadeOnDelete();
            $table->foreign('gradoID')->references('id')->on('grados')->cascadeOnDelete();
            $table->foreign('turnoID')->references('id')->on('turnos')->cascadeOnDelete();
            $table->foreign('seccionID')->references('idSeccion')->on('secciones')->cascadeOnDelete();
            $table->date('fechaAsignarCursoDocente');
            $table->enum('estadoAsignarCursoDocente', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignar_cursos_docentes');
    }
};
