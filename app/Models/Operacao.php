<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Operacao extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;
    protected $fillable = [
        'id',
        'id_carteira',
        'id_ativo',
        'data',
        'qtd',
        'valor_unitario',
        'valor_total',
        'preco_medio',
        'resultado',
        'tarifa',
        'tipo',
        'obs',
        'status'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
        public function carteira()
    {
        return $this->hasOne(Carteira::class,  'id','id_carteira');
    }
    public function ativo()
    {
        return $this->hasOne(Ativo::class,  'id','id_ativo');
    }
    protected function valor_unitario(): Attribute{
        return Attribute::make(
            get: fn ($value) => str_replace(".", ",", $value),
            set: fn ( $value) =>
                [
                    'valor_unitario' => str_replace(",", ".", str_replace(".", "", $value)),
                ],
            );
    }
    protected function valor_total(): Attribute{
        return Attribute::make(
            get: fn ($value) => str_replace(".", ",", $value),
            set: fn ( $value) =>
                [
                    'valor_total' => str_replace(",", ".", str_replace(".", "", $value)),
                ],
            );
    }

    protected static function booted()
    {
        static::creating(function ($operacao) {
            if ($operacao->tipo === 'V') {
                $operacao->calcularPrecoMedioEResultado();
            }
        });
    }

    public function calcularPrecoMedioEResultado()
    {
        // Obter todas as operações de compra e venda para o ativo na carteira
        $compras = Operacao::where('id_carteira', $this->id_carteira)
            ->where('id_ativo', $this->id_ativo)
            ->where('tipo', 'C')
            ->get();

        $vendas = Operacao::where('id_carteira', $this->id_carteira)
            ->where('id_ativo', $this->id_ativo)
            ->where('tipo', 'V')
            ->get();

        // Calcular o valor total das compras
        $valorTotalCompras = $compras->sum('valor_total');

        // Calcular a quantidade total de compras
        $qtdCompras = $compras->sum('qtd');

        // Calcular o valor total das vendas
        $valorTotalVendas = $vendas->sum('valor_total');

        // Calcular a quantidade total de vendas
        $qtdVendas = $vendas->sum('qtd');

        // Calcular o resultado acumulado das vendas anteriores
        $resultadoVendasAnteriores = $vendas->sum('resultado');

        // Calcular o preço médio
        if (($qtdCompras - $qtdVendas) != 0) {
            $precoMedio = (($valorTotalCompras + $resultadoVendasAnteriores) - $valorTotalVendas) / ($qtdCompras - $qtdVendas);
        } else {
            $precoMedio = 0; // Evitar divisão por zero
        }

        // Calcular o resultado da venda atual
        $resultado = ($this->valor_unitario - $precoMedio) * $this->qtd;

        // Atualizar os campos na operação de venda
        $this->preco_medio = $precoMedio;
        $this->resultado = $resultado;
    }
}
