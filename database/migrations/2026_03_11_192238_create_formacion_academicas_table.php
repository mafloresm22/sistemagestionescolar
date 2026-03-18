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
        Schema::create('formacion_academicas', function (Blueprint $table) {
            $table->id('idFormacionAcademica');
            $table->string('tituloFormacionAcademica');
            $table->string('nivelFormacionAcademica');
            $table->date('anioFormacionAcademica');
            $table->string('institucionFormacionAcademica');
            $table->string('archivoFormacionAcademica');
            $table->integer('personalID')->references('idPersonal')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacion_academicas');
    }
};
