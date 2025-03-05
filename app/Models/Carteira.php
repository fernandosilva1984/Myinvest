<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Carteira extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;
    protected $fillable = [
        'id',
        'Nome',
        'Proprietario',
        'status'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

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
        public function Dividendos_01()
        {
            return $this->hasMany(ProventoAtivosCart01::class, 'id_carteira', 'id')
                ->select('id_carteira', DB::raw('sum(provento) as total'))
                ->groupBy('id_carteira');
        }
        public function Dividendos_02()
        {
            return $this->hasMany(ProventoAtivosCart02::class, 'id_carteira', 'id')
                ->select('id_carteira', DB::raw('sum(provento) as total'))
                ->groupBy('id_carteira');
        }
            public function Dividendos_03()
        {
            return $this->hasMany(ProventoAtivosCart03::class, 'id_carteira', 'id')
                ->select('id_carteira', DB::raw('sum(provento) as total'))
                ->groupBy('id_carteira');
        }
            public function Dividendos_05()
        {
            return $this->hasMany(ProventoAtivosCart05::class, 'id_carteira', 'id')
                ->select('id_carteira',DB::raw('sum(provento) as total'))
                ->groupBy('id_carteira');
        }
            // Accessor para obter o total de dividendos dinamicamente
        public function getDividendosTotalAttribute()
        {
            switch ($this->id) {
                case 1:
                    return $this->Dividendos_01->first()->total ?? 0;
                case 2:
                    return $this->Dividendos_02->first()->total ?? 0;
                case 3:
                    return $this->Dividendos_03->first()->total ?? 0;
                case 5:
                    return $this->Dividendos_05->first()->total ?? 0;
                default:
                    return 0;
            }
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
            $totalDividendos = $this->dividendos_total;
            // Soma dos resultados das operações
            $totalOperacoes = $this->hasMany(Operacao::class, 'id_carteira')
                ->where('tipo', 'V')
                ->sum('resultado');
            // Cálculo do saldo
            $saldo = $totalAportes + $totalDividendos - ($totalSaques - $totalOperacoes);
            return $saldo;
        }
        

        public function getRendaFixa()
        {
            // Obtém a soma do valor_atual
            $valor_atual = $this->hasMany(RendaFixa::class, 'id_carteira', 'id')
                ->where('status', 1) // Filtra por status, se necessário
                ->sum('valor_atual');

            // Obtém a soma do IOF
            $iof = $this->hasMany(RendaFixa::class, 'id_carteira', 'id')
                ->where('status', 1) // Filtra por status, se necessário
                ->sum('iof');

            // Obtém a soma do IR
            $ir = $this->hasMany(RendaFixa::class, 'id_carteira', 'id')
                ->where('status', 1) // Filtra por status, se necessário
                ->sum('ir');

            // Calcula o valor líquido da renda fixa
            $rendaFixa = $valor_atual - ($iof + $ir);

            return $rendaFixa;
        }

        //// funções para resource posicao

        public function getSaldoACOES()
        {
            $acoes = $this->hasMany(Posicao::class, 'id_carteira', 'id')
            ->where('id_tipo', 1) // Filtra por tipo 1 - açoes
            ->sum('patrimonio') ?? 0;

            return $acoes;
        }
        
        public function getSaldoFII()
        {
            $fiis = $this->hasMany(Posicao::class, 'id_carteira', 'id')
            ->where('id_tipo', 2) // Filtra por tipo 2 - FIIS
            ->sum('patrimonio') ?? 0;
            return $fiis;
        }
        public function getSaldoCripto()
        {
            $cripto = $this->hasMany(Posicao::class, 'id_carteira', 'id')
            ->where('id_tipo', 4) // Filtra por tipo 4 - cripto
            ->sum('patrimonio') ?? 0;
            return $cripto;
        }
        public function getResultado()
        {

            $resultado =  ($this->getRendaFixa() + $this->getSaldoACOES() + $this->getSaldoFII() + $this->getSaldoCripto())- $this->saldo();
            return $resultado ;
        }
        public function getAplicado()
        {

            $resultado =  ($this->getRendaFixa() + $this->getSaldoACOES() + $this->getSaldoFII() + $this->getSaldoCripto());
            return $resultado ;
        }

}