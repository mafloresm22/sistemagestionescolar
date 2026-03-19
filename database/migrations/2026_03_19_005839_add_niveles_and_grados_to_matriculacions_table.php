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
        Schema::table('matriculacions', function (Blueprint $table) {
            $table->foreignId('nivelesID')->after('seccionID')->constrained('niveles')->cascadeOnDelete();
            $table->foreignId('gradosID')->after('nivelesID')->constrained('grados')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculacions', function (Blueprint $table) {
            $table->dropForeign(['nivelesID']);
            $table->dropForeign(['gradosID']);
            $table->dropColumn(['nivelesID', 'gradosID']);
        });
    }
};
