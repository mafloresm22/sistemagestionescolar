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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('idEstudiante');
            $table->string('nombreEstudiante', 150);
            $table->string('apellidoEstudiante', 150);
            $table->integer('dniEstudiante');
            $table->date('fechaNacimientoEstudiante');
            $table->string('generoEstudiante', 1);
            $table->integer('celularEstudiante');
            $table->string('correoEstudiante', 150);
            $table->string('direccionEstudiante', 255);
            $table->string('fotoEstudiante')->nullable();
            $table->enum('estadoEstudiante', ['Activo', 'Inactivo'])->default('Activo');
            $table->foreignId('padreFamiliaID')->constrained('padre_familias', 'idPadreFamilia');
            $table->foreignId('userID')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
