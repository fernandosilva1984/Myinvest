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
        Schema::create('carteiras', function (Blueprint $table) {
            $table->id();
            $table->string('Nome');
            $table->string('Proprietario');
            $table->decimal('Valor_Investido', 15,2);
            $table->decimal('Valor_Mercado', 15,2);
            $table->decimal('Resultado', 5,2);
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carteiras');
    }
};
