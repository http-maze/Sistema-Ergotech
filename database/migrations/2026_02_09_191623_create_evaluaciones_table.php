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
        Schema::create('evaluaciones', function (Blueprint $table) {
    $table->id();

    $table->foreignId('empresa_id')->constrained();
    $table->foreignId('sucursal_id')->constrained();
    $table->foreignId('puesto_id')->constrained();

    $table->foreignId('evaluador_id')
          ->constrained('users');

    $table->foreignId('metodo_id')
          ->constrained('metodos');

    $table->date('fecha');
    $table->string('estado')->default('borrador');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
