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
        Schema::create('prendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("evento_id")->constrained()->onDelete("cascade");
            $table->foreignId("prenda_category_id")->constrained()->onDelete("cascade");
            $table->foreignId("prenda_talla_id")->constrained()->onDelete("cascade");
            $table->integer("cantidad",);
            $table->string("sexo", 25);
            $table->boolean("estado");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prendas');
    }
};
