<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundoSaude extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'data_',
        'valor',
        'tipo',
        'categoria',
        'descricao',
        'usuario',
        'comprovante',
        'status'
        ];
}
