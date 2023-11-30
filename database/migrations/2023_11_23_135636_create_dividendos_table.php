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
        Schema::create('dividendos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ativo');
            $table->date('data_ref');
            $table->decimal('valor_dividendo', 15,2)->nullable();
            $table->decimal('valor_jcp', 15,2)->nullable();
            $table->decimal('valor_total',15,2)->storedAs('valor_dividendo + valor_jcp')->nullable();
            $table->date('data_com');
            $table->date('data_pag');
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_ativo')->references('id')->on('ativos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
        Schema::dropIfExists('dividendos');
    }
};
