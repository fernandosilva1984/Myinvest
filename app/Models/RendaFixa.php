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
        'id_tipo',
        'descrição',
        'data_aplicacao',
        'data_venc',
        'valor_aplic',
        'iof',
        'ir',
        'indice',
        'taxa',
        'taxa_rent',
        'banco_emissor',
        'banco_gestor',
        'conta',
        'status'
        ];
}
