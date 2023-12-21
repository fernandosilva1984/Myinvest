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
        Schema::create('cotacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ativo');
            $table->datetime('data_hora');
            $table->decimal('valor', 15,2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_ativo')->references('id')->on('ativos');
            $table->boolean('status')->default(TRUE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotacaos');
    }
};
