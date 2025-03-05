<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ativo extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;
    protected $fillable = [
        'id',
        'Ticket',
        'Razao_Social',
        'CNPJ',
        'Valor_patrimonio',
        'qtd_cotas',
        'id_tipo',
        'id_segmento',
        'status'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
        // Escopo local para filtrar registros
        public function scopeAtivosAtivos($query)
        {
            return $query->where('status', 1);
        }
        public function tipoAtivo()
        {
            return $this->hasOne(tipoAtivo::class,  'id','id_tipo');
        }
        public function segmentoAtivo()
        {
            return $this->hasOne(segmentoAtivo::class,  'id','id_segmento');
        }

        protected function valor_patrimonio(): Attribute{
            return Attribute::make(
                get: fn ($value) => str_replace(".", ",", $value),
                set: fn ( $value) =>
                    [
                        'valor_patrimonio' => str_replace(",", ".", str_replace(".", "", $value)),
                    ],
                );
        }
      /*  protected function valor_PCota(): Attribute{
            return Attribute::make(
                get: fn ($value) => str_replace(".", ",", $value),
                set: fn ( $value) =>
                    [
                        'valor_PCota`' => str_replace(",", ".", str_replace(".", "", $value)),
                    ],
                );
        }
*/
        public function cotacaoAtual()
        {

            $saida = $this->hasOne(Cotacao::class,'id_ativo')->select('id_ativo', DB::raw('valor'))->latest();

              return $saida;
        }
        // Relacionamento com o model Operacao
        public function operacoes()
        {
            return $this->hasMany(Operacao::class,  'id_ativo');
        }
            // Função para calcular o saldo das operações
        public function saldoOperacoes(): float
        {
            $compras = $this->operacoes()->where('tipo', 'C')->sum('qtd');
            $vendas = $this->operacoes()->where('tipo', 'V')->sum('qtd');

            return $compras - $vendas;
        }
        public function precomedio():float

        {
            $qtdcompras = $this->operacoes()->where('tipo', 'C')->sum('qtd');
            $qtdvendas = $this->operacoes()->where('tipo', 'V')->sum('qtd');
            $resultvendas = $this->operacoes()->where('tipo', 'V')->sum('resultado');
            $valorcompras = $this->operacoes()->where('tipo', 'C')->sum('valor_total');
            $valorvendas = $this->operacoes()->where('tipo', 'V')->sum('valor_total');
            if (($qtdcompras-$qtdvendas) > 0){
                $precomedio = (($valorcompras+$resultvendas)-$valorvendas)/($qtdcompras-$qtdvendas);

            return $precomedio;

            }else{
                return 0;
        }

        }
 // Define o relacionamento com a Carteira
 public function carteira()
 {
     return $this->belongsTo(Carteira::class, 'id_carteira');
 }

   /* public function operacoes()
    {
        return $this->hasMany(Operacao::class, 'id_ativo');
    }*/

    public function dividendos()
    {
        return $this->hasMany(Dividendo::class, 'id_ativo');
    }

    public function saldo($carteiraId = null)
    {
        $query = $this->operacoes();

        if ($carteiraId) {
            $query->where('id_carteira', $carteiraId);
        }

        return $query->sum('qtd');
    }


}
