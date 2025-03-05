<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosicaoAtivosCart1 extends Model
{
        use  LogsActivity;

        protected $table = 'posicao_ativos_cart_1';
        protected $primaryKey = 'id_ativo'; // Defina a chave primária, se necessário
        public $timestamps = false; // Desabilita timestamps, já que é uma view

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }


}
