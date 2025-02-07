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
        Schema::create('tipo_ativos', function (Blueprint $table) {
            $table->id();
            $table->string('tipoAtivo')->nullable();
            $table->boolean('status')->default(TRUE);
            $table->softDeletes();
            $table->timestamps()->default(DB::raw('current_timestamp'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_ativos');
    }
};
