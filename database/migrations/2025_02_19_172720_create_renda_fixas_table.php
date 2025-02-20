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
        Schema::create('renda_fixas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ativo');
            $table->unsignedBigInteger('id_banco_emissor');
            $table->unsignedBigInteger('id_banco_gestor');
            $table->string('descrição');
            $table->date('data_aplicacao');
            $table->int('prazo');
            $table->date('data_venc');
            $table->decimal('valor_aplic', 15,2)->nullable();
            $table->decimal('iof', 15,2);
            $table->decimal('ir', 15,2);
            $table->string('indice');
            $table->decimal('taxa', 15,2);
            $table->decimal('taxa_rent', 15,2);
            $table->string('conta');
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_ativo')->references('id')->on('ativos');
            $table->foreign('id_banco_emissor')->references('id')->on('bancos');
            $table->foreign('id_banco_gestor')->references('id')->on('bancos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renda_fixas');
    }
};
