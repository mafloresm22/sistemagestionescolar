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
        Schema::create('matriculacions', function (Blueprint $table) {
            $table->id('idMatriculacion');
            $table->date('fechaMatriculacion');
            $table->foreignId('estudianteID')->constrained('estudiantes', 'idEstudiante')->cascadeOnDelete();
            $table->foreignId('turnoID')->constrained('turnos')->cascadeOnDelete();
            $table->foreignId('gestionID')->constrained('gestions')->cascadeOnDelete();
            $table->foreignId('seccionID')->constrained('secciones', 'idSeccion')->cascadeOnDelete();
            $table->text('observacionesMatriculacion');
            $table->enum('estadoMatriculacion', ['Activo', 'Inactivo', 'Retirado', 'Anulado'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculacions');
    }
};
