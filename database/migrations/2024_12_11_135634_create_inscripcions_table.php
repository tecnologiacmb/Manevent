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
            $table->foreignId("evento_id")->nullable()->constrained();
            $table->foreignId("participante_id")->nullable()->constrained();
            $table->foreignId("metodo_pago_id")->nullable()->constrained();
            $table->foreignId("grupo_id")->constrained();
            $table->foreignId("dolar_id")->constrained();
            $table->foreignId("numero_id")->nullable()->constrained();
            $table->foreignId("categoria_habilitada_id")->nullable()->constrained();
            $table->foreignId("mesa_id")->nullable()->constrained();
            $table->json("datos")->nullable();
            $table->double("monto_pagado_bs")->nullable();
            $table->string("ip", 30)->nullable();
            $table->string("nomenclatura", 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
