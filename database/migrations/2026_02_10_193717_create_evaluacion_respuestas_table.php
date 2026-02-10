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
        Schema::create('evaluacion_respuestas', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->foreignId('evaluacion_id')->constrained('evaluaciones')->onDelete('cascade');
    $table->string('variable'); // ej. 'angulo_brazo' para RULA
    $table->string('respuesta'); // valor numérico o texto
    $table->text('comentario')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_respuestas');
    }
};
