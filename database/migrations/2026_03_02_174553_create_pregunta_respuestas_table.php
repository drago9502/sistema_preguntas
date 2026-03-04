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
        Schema::create('pregunta_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pregunta');
            $table->integer('numero_respuesta');
            $table->string('respuesta',255);
            $table->timestamps();
            $table->foreign('id_pregunta')->references('id')->on('preguntas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta_respuestas');
    }
};
