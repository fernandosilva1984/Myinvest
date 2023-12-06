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
        Schema::create('movimentacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_carteira');
            $table->date('data')->nullable();
            $table->decimal('valor_total',15,2)->nullable();
            $table->string('tipo');
            $table->string('obs')->nullable();
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_carteira')->references('id')->on('carteiras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacaos');
    }
};
