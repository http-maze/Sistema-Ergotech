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
        Schema::create('resultados', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->foreignId('evaluacion_id')->constrained('evaluaciones')->onDelete('cascade');
    $table->decimal('puntuacion', 5, 2);
    $table->string('nivel_riesgo'); // bajo, medio, alto
    $table->text('recomendaciones')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
