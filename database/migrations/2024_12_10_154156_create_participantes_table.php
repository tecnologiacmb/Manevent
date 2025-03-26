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
            $table->foreignId("ciudad_id")->constrained();
            $table->string("cedula", 25);
            $table->string("nombre", 25);
            $table->string("apellido", 25);
            $table->string("telefono", 25);
            $table->string("correo", 30);
            $table->string("direccion", 50);
            $table->date("fecha_nacimiento");
            $table->foreignId("genero_id")->constrained();
            $table->timestamps();
            $table->softDeletes();
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
