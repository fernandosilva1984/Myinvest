<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cotacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'id_ativo',
        'data_hora',
        'valor',
        'status'
        ];

        public function ativo()
    {
        return $this->hasOne(Ativo::class,  'id','id_ativo');
    }
}
