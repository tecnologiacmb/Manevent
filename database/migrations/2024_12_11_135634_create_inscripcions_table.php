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
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("evento_id")->constrained()->nullable();
            $table->foreignId("participante_id")->constrained()->nullable();
            $table->foreignId("metodo_pago_id")->constrained()->nullable();
            $table->foreignId("grupo_id")->constrained()->nullable();
            $table->foreignId("dolar_id")->constrained()->nullable();
            $table->foreignId("numero_id")->constrained()->nullable();
            $table->json("datos")->nullable();
            $table->double("monto_pagado_bs")->nullable();
            $table->string("ip")->nullable();
            $table->string("nomenclatura")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};
