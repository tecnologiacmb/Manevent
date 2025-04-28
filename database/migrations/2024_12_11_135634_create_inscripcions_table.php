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
            $table->foreignId("metodo_pago_id")->references('id')->on('metodo_pagos');
            $table->foreignId("grupo_id")->constrained();
            $table->foreignId("dolar_id")->constrained();
            $table->foreignId("numero_id")->nullable()->constrained();
            $table->foreignId("categoria_habilitada_id")->nullable()->constrained();
            $table->foreignId("mesa_id")->nullable()->constrained();
            $table->json("datos")->nullable();
            $table->double("monto_a_pagar_bs")->nullable();
            $table->string("ip", 30)->nullable();
            $table->string("nomenclatura", 20)->nullable();
            $table->foreignId("recorrido_id")->nullable()->constrained();
            $table->foreignId("recorrido_id_grupos")->nullable()->references('id')->on('recorridos');
            $table->foreignId("prenda_id")->nullable()->constrained();
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
