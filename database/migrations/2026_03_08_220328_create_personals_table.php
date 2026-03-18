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
        Schema::create('personals', function (Blueprint $table) {
            $table->id('idPersonal');
            $table->string('nombrePersonal', 100);
            $table->string('apellidoPersonal', 100);
            $table->string('dniPersonal', 8)->unique();
            $table->date('fechaNacimientoPersonal');
            $table->enum('generoPersonal', ['Masculino', 'Femenino', 'Prefiero no decirlo', 'Otro']);
            $table->string('celularPersonal', 9);
            $table->string('profesionPersonal', 100);
            $table->enum('tipoPersonal', ['Docente', 'Administrativo']);
            $table->enum('estadoPersonal', ['Activo', 'Inactivo'])->default('Activo');
            $table->string('fotoPersonal')->nullable();
            $table->foreignId('userID')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
