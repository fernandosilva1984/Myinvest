<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuracao extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'CDI_atual',
        'SELIC_atual',
        'Corretagem_acoes',
        'Corretagem_fii',
        'Corretagem_Criptos'
        ];
}
