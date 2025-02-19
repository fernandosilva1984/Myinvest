<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ativo extends Model
{
    use HasFactory, SoftDeletes;
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
        public function operacoes(): HasMany
        {
            return $this->hasMany(Operacao::class,  'id_ativo');
        }
            // Função para calcular o saldo das operações
        public function saldoOperacoes(): int
        {
            $compras = $this->operacoes()->where('tipo', 'C')->sum('qtd');
            $vendas = $this->operacoes()->where('tipo', 'V')->sum('qtd');

            return $compras - $vendas;
        }

}
