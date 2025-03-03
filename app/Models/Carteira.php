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

        public function dividendos()
        {

            $dividendos =$this->hasMany(Movimentacao::class,  'id_carteira', 'id')
              ->select('id_carteira', DB::raw('sum(valor_total) as `total`'))->where('tipo', 'D')->groupBy('id_carteira');
            return $dividendos;

        }

        public function dividendos_NEW()
        {
            switch ($this->id) {
                case 1:
                    $dividendos = $this->hasMany(ProventoAtivosCart01::class, 'id_carteira', 'id')
                        ->select('id_carteira', DB::raw('sum(provento) as `total`'))
                        ->groupBy('id_carteira');
                    break;
                case 2:
                    $dividendos = $this->hasMany(ProventoAtivosCart02::class, 'id_carteira', 'id')
                        ->select('id_carteira', DB::raw('sum(provento) as `total`'))
                        ->groupBy('id_carteira');
                    break;
                case 3:
                    $dividendos = $this->hasMany(ProventoAtivosCart03::class, 'id_carteira', 'id')
                        ->select('id_carteira', DB::raw('sum(provento) as `total`'))
                        ->groupBy('id_carteira');
                    break;
                default:
                    $dividendos = $this->hasMany(ProventoAtivosCart05::class, 'id_carteira', 'id')
                        ->select('id_carteira', DB::raw('sum(provento) as `total`'))
                        ->groupBy('id_carteira');
                    break;
            }

            return $dividendos;
/*}/*
            $dividendos =$this->hasMany(Movimentacao::class,  'id_carteira', 'id')
              ->select('id_carteira', DB::raw('sum(valor_total) as `total`'))->where('tipo', 'D')->groupBy('id_carteira');
            return $dividendos;
*/
        }

        public function saldo()
        {

            $totalAportes = $this->hasMany(Movimentacao::class, 'id_carteira', 'id')
            ->where('tipo', 'A')
            ->sum('valor_total');

            $totalSaques = $this->hasMany(Movimentacao::class, 'id_carteira', 'id')
            ->where('tipo', 'S')
            ->sum('valor_total');
            // Soma dos dividendos
            $totalDividendos = $this->hasMany(Movimentacao::class, 'id_carteira', 'id')
            ->where('tipo', 'D')
            ->sum('valor_total');

// Soma dos resultados das operações
$totalOperacoes = $this->hasMany(Operacao::class, 'id_carteira')
    ->where('tipo', 'V')
    ->sum('resultado');

// Cálculo do saldo
$saldo = $totalAportes + $totalDividendos - ($totalSaques - $totalOperacoes);

return $saldo;
        }






    }
