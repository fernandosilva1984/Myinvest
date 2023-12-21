<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'Nome',
        'Proprietario',
        'status'
        ];

        public function movimentacoes()
        {

            $saida = $this->hasMany(Movimentacao::class,  'id_carteira')->where('tipo', 'S');
              //->select('id_carteira', DB::raw('id','tipo','data','valor_total','id_carteira'))->where('tipo','=','S');

              return $saida;
        }
        public function total_invest()
        {
              return $this->hasMany(Movimentacao::class,  'id_carteira', 'id')
              ->select('id_carteira', DB::raw('sum(valor_total) as `valor_total`'))->groupBy('id_carteira');
        }



    }
