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
        Schema::create('asistentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_evento');
            $table->string('nombre',255);
            $table->string('apellido_paterno',255);
            $table->string('apellido_materno',255);
            $table->string('correo',255);
            $table->string('status',10);
            $table->timestamps();
            $table->foreign('id_evento')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistentes');
    }
};
