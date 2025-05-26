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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('codigo_estudiante');
            $table->string('codigo_tutor');
            $table->enum('tipo', ['A', 'I', 'J']); // A: asistencia, I: inasistencia, J: justificado
            $table->foreign('codigo_estudiante')->references('codigo')->on('estudiantes');
            $table->foreign('codigo_tutor')->references('codigo')->on('tutores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
