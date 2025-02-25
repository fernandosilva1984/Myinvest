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
        Schema::create('fundo_saudes', function (Blueprint $table) {
            $table->id();
            $table->date('data_');
            $table->decimal('valor',15,2);
            $table->string('tipo');
            $table->string('categoria')->nullable();
            $table->string('descricao');
            $table->string('usuario');
            $table->string('comprovante')->nullable();
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
        Schema::dropIfExists('fundo_saudes');
    }
};
