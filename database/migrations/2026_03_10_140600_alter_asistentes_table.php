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
        Schema::table('asistentes', function (Blueprint $table) {
            //
             $table->string('apellido_paterno',255)->nullable()->change();
            $table->string('apellido_materno',255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistentes', function (Blueprint $table) {
            //
        });
    }
};
