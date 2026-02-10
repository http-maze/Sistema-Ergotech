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
        Schema::create('metodos', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('nombre'); // ej. 'RULA'
    $table->text('descripcion')->nullable();
    $table->string('norma')->nullable(); // ej. 'NOM-036-1-STPS-2018'
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodos');
    }
};
