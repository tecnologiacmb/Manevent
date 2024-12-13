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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("ciudad_id")->constrained()->OnDelete("cascade");
            $table->string("cedula");
            $table->string("nombre");
            $table->string("apellido");
            $table->string("telefono");
            $table->string("correo");
            $table->string("direccion");
            $table->date("fecha_nacimiento");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
