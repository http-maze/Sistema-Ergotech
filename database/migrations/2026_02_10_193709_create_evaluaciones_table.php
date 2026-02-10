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
    $table->bigIncrements('id');
    $table->foreignId('puesto_id')->constrained('puestos')->onDelete('cascade');
    $table->foreignId('metodo_id')->constrained('metodos')->onDelete('cascade');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Evaluador (asumiendo tabla users existe)
    $table->date('fecha');
    $table->string('status')->default('pendiente'); // pendiente, completada, etc.
    $table->text('notas')->nullable();
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
