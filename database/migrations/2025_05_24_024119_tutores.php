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
        Schema::create('tutores', function (Blueprint $table) {
            $table->string('codigo', 10)->primary(); // Inicial de apellidos + correlativo
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dui', 10)->unique();
            $table->string('email')->unique();
            $table->string('telefono', 15);
            $table->date('fecha_nacimiento');
            $table->date('fecha_contratacion');
            $table->enum('estado', ['contratado', 'despedido', 'renuncia'])->default('contratado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutores');
    }
};
