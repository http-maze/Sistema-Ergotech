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
        Schema::create('reportes', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->foreignId('evaluacion_id')->constrained('evaluaciones')->onDelete('cascade');
    $table->date('fecha_generacion');
    $table->string('path_pdf');
    $table->string('folio')->unique();
    $table->text('firma_digital')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
