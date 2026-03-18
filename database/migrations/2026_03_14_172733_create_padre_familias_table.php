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
        Schema::create('padre_familias', function (Blueprint $table) {
            $table->id('idPadreFamilia');
            $table->string('nombrePadreFamilia', 150);
            $table->string('apellidoPadreFamilia', 150);
            $table->integer('dniPadreFamilia');
            $table->date('fechaNacimientoPadreFamilia');
            $table->string('generoPadreFamilia', 1);
            $table->integer('celularPadreFamilia');
            $table->string('correoPadreFamilia', 150);
            $table->string('direccionPadreFamilia', 255);
            $table->enum('estadoPadreFamilia', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('padre_familias');
    }
};
