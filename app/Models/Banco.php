<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'nome',
        'razao_social',
        'CNPJ',
        'logradouro',
        'bairro',
        'cidade',
        'UF',
        'status'
        ];
}
