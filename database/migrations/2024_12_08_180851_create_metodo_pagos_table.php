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
            $table->string("cedula", 20)->nullable();
            $table->string("telefono", 20)->nullable();
            $table->string("propietario", 30)->nullable();
            $table->string("ABA", 30)->nullable();
            $table->string("SWIT", 30)->nullable();
            $table->string("correo", 30)->nullable();
            $table->boolean("estado");
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
