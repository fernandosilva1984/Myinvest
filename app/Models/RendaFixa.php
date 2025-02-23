<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RendaFixa extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'id_ativo',
        'descrição',
        'data_aplicacao',
        'prazo',
        'data_venc',
        'valor_aplic',
        'iof',
        'ir',
        'indice',
        'taxa',
        'taxa_rent',
        'id_banco_emissor',
        'id_banco_gestor',
        'id_carteira',
        'conta',
        'status'
        ];
}
