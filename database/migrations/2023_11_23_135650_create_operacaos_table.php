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
        Schema::create('operacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_carteira');
            $table->unsignedBigInteger('id_ativo');
            $table->date('data');
            $table->decimal('qtd', 20,10)->nullable();
            $table->decimal('valor_unitario', 20,10)->nullable();
            $table->decimal('valor_total',21,10)->storedAs('qtd * valor_unitario')->nullable();
            $table->decimal('preco_medio', 15,10)->nullable();
            $table->decimal('resultado', 15,10)->nullable();
            $table->decimal('tarifa', 15,2)->nullable();
            $table->string('tipo');
            $table->string('obs')->nullable();
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_carteira')->references('id')->on('carteiras');
            $table->foreign('id_ativo')->references('id')->on('ativos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operacaos');
    }
};
