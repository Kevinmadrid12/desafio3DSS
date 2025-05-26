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
         Schema::create('asignacion_aspectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aspecto_id');
            $table->date('fecha');
            $table->string('codigo_estudiante');
            $table->string('codigo_tutor');
            $table->foreign('aspecto_id')->references('id')->on('aspectos');
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
        Schema::dropIfExists('asignacion_aspectos');
    }
};
