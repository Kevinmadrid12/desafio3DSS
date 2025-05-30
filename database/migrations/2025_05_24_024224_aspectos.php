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
        Schema::create('aspectos', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->enum('tipo', ['P', 'L', 'G', 'MG']); // P: positivo, L: Leve, G: Grave, MG: Muy grave
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspectos');
    }
};
