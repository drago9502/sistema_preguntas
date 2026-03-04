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
        Schema::create('asistente_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_evento');
            $table->unsignedBigInteger('id_pregunta');
            $table->unsignedBigInteger('id_respuesta');
            $table->unsignedBigInteger('id_asistente');
            $table->timestamps();

            $table->foreign('id_evento')->references('id')->on('eventos');
            $table->foreign('id_pregunta')->references('id')->on('preguntas');
            $table->foreign('id_respuesta')->references('id')->on('pregunta_respuestas');
            $table->foreign('id_asistente')->references('id')->on('asistentes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistente_respuestas');
    }
};
