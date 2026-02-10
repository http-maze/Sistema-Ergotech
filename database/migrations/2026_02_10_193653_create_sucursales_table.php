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
        Schema::create('sucursales', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
    $table->string('nombre');
    $table->string('direccion')->nullable();
    $table->string('ciudad')->nullable();
    $table->string('estado')->nullable();
    $table->string('codigo_postal')->nullable();
    $table->string('telefono')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
