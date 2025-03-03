<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProventoAtivosCart01 extends Model
{
        protected $table = 'proventos_ativos_cart_1';
        protected $primaryKey = 'id_ativo'; // Defina a chave primária, se necessário
        public $timestamps = false; // Desabilita timestamps, já que é uma view
}

