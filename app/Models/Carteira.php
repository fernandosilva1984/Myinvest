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

        public function Saldo_operacoes()
        {

            $saldo_operacao = $this->hasMany(Operacao::class,  'id_carteira')
            ->select('id_carteira', DB::raw('sum(resultado) as `total`'))->where('tipo', 'V')->groupBy('id_carteira');
              //->select('id_carteira', DB::raw('id','tipo','data','valor_total','id_carteira'))->where('tipo','=','S');

              return $saldo_operacao;
        }
        public function Aportes()
        {
            $Aportes =$this->hasMany(Movimentacao::class,  'id_carteira', 'id')
              ->select('id_carteira', DB::raw('sum(valor_total) as `total`'))->where('tipo', 'A')->groupBy('id_carteira');
              return $Aportes;
        }
        public function Saques()
        {

            $Saques =$this->hasMany(Movimentacao::class,  'id_carteira', 'id')
              ->select('id_carteira', DB::raw('sum(valor_total) as `total`'))->where('tipo', 'S')->groupBy('id_carteira');
            return $Saques;

        }

        public function saldo()
        {

            $totalAportes = $this->hasMany(Movimentacao::class, 'id_carteira', 'id')
            ->where('tipo', 'A')
            ->sum('valor_total');

            $totalSaques = $this->hasMany(Movimentacao::class, 'id_carteira', 'id')
            ->where('tipo', 'S')
            ->sum('valor_total');

            return $totalAportes - $totalSaques;
        }






    }
