<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombreConfiguraciones');
            $table->string('descripcionConfiguraciones');
            $table->text('direccionConfiguraciones');
            $table->string('telefonoConfiguraciones');
            $table->string('correoInstitucionalConfiguraciones');
            $table->string('webConfiguraciones')->nullable();
            $table->text('logoConfiguraciones');
            $table->string('divisaConfiguraciones');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};
