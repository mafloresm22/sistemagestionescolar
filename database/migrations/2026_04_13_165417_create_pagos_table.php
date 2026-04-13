<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('idPago');
            $table->decimal('montoPago', 10, 2);
            $table->string('metodoPago');
            $table->date('fechaPago');
            $table->text('observacionesPago')->nullable();
            $table->enum('estadoPago', ['Pagado', 'Pendiente', 'Anulado'])->default('Pendiente');
            $table->foreignId('matriculacionID')->constrained('matriculacions', 'idMatriculacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
