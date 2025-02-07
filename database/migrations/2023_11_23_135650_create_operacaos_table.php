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
            $table->integer('qtd')->nullable();
            $table->decimal('valor_unitario', 15,2)->nullable();
            $table->decimal('valor_total',15,2)->storedAs('qtd * valor_unitario')->nullable();
            $table->string('tipo');
            $table->string('obs')->nullable();
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps()->default(DB::raw('current_timestamp'));
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
