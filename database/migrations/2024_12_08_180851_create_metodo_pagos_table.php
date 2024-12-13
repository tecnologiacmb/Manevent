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
        Schema::create('metodo_pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId("tipo_pago_id")->constrained()->onDelete("cascade");
            $table->foreignId("banco_id")->constrained()->onDelete("cascade");
            $table->string("n°_cuenta")->nullable();
            $table->string("cedula")->nullable();
            $table->string("telefono")->nullable();
            $table->string("propietario")->nullable();
            $table->string("ABA")->nullable();
            $table->string("SWIT")->nullable();
            $table->string("correo")->nullable();
            $table->boolean("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodo_pagos');
    }
};
