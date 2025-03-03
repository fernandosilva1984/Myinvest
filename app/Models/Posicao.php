<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posicao extends Model
{
    public function cotacaoAtual()
        {

            $saida = $this->hasOne(Cotacao::class,'id_ativo')->select('id_ativo', DB::raw('valor'))->latest();

              return $saida;
        }
        public function saldoOperacoes(): float
        {
            $compras = $this->operacoes()->where('tipo', 'C')->sum('qtd');
            $vendas = $this->operacoes()->where('tipo', 'V')->sum('qtd');

            return $compras - $vendas;
        }

        public function carteira()
    {
        return $this->hasOne(Carteira::class,  'id','id_carteira');
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
}
