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
        Schema::create('configuracaos', function (Blueprint $table) {
            $table->id();
            $table->decimal('CDI_atual', 5,2);
            $table->decimal('SELIC_atual', 5,2);
            $table->decimal('Corretagem_acoes', 10,7);
            $table->decimal('Corretagem_fii', 10,7);
            $table->decimal('Corretagem_criptos', 10,7);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracaos');
    }
};
