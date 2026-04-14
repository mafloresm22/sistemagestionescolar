<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('idAsistencia');
            $table->unsignedBigInteger('asignarCursoDocenteID');
            $table->foreign('asignarCursoDocenteID')
                  ->references('idAsignarCursoDocente') 
                  ->on('asignar_cursos_docentes')
                  ->cascadeOnDelete();

            $table->date('fechaAsistencias');
            $table->text('observacionAsistencias');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
