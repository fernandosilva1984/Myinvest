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
            $table->datetime('data_hora')->default(DB::raw('current_timestamp'));
            $table->decimal('valor', 20,10);
            $table->softDeletes();
            $table->timestamps();
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
