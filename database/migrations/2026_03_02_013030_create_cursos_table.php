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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id('idCurso');
            $table->string('codigoCurso', 10)->unique();
            $table->string('nombreCurso', 100);
            $table->string('descripcionCurso', 255);
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->foreignId('nivelID')->constrained('niveles')->cascadeOnDelete();
            $table->foreignId('gradoID')->constrained('grados')->cascadeOnDelete();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
