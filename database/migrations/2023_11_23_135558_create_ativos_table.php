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
        Schema::create('ativos', function (Blueprint $table) {
            $table->id();
            $table->string('Ticket')->unique();
            $table->string('Razao_Social');
            $table->string('CNPJ')->unique();
            $table->decimal('Valor_mercado', 15,2);
            $table->decimal('Valor_patrimonio', 15,2);
            $table->decimal('qtd_cotas',15,0);
            $table->decimal('qtd_meta',15,0);
            $table->decimal('Valor_PCota', 15,2);
            $table->unsignedBigInteger('id_tipo');
            $table->unsignedBigInteger('id_segmento');
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_tipo')->references('id')->on('tipo_ativos');
            $table->foreign('id_segmento')->references('id')->on('segmento_ativos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativos');
    }
};
