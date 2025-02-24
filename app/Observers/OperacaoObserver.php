<?php
namespace App\Observers;

use App\Models\Operacao;
use App\Models\Ativo;

class OperacaoObserver
{
    /**
     * Executa após uma operação ser criada.
     *
     * @param Operacao $operacao
     * @return void
     */
    public function created(Operacao $operacao)
    {
        $ativo = Ativo::find($operacao->ativo_id);

        if ($ativo) {
            if ($operacao->tipo === 'C') {
                // Atualiza o preço médio apenas para compras
                $quantidadeTotalCompras = $ativo->operacoes()->where('tipo', 'C')->sum('qtd');
                $totalGasto = $ativo->operacoes()->where('tipo', 'C')->sum(\DB::raw('qtd * valor_unitario'));

                if ($quantidadeTotalCompras > 0) {
                    $ativo->preco_medio = $totalGasto / $quantidadeTotalCompras;
                }
            } elseif ($operacao->tipo === 'V') {
                // Atualiza o preço médio para vendas
                $precoMedioAtual = $ativo->preco_medio;
                $precoVenda = $operacao->preco;
                $quantidadeVendida = $operacao->quantidade;
                $quantidadeRestante = $ativo->quantidade_total - $quantidadeVendida;

                if ($quantidadeRestante > 0) {
                    $diferenca = ($precoVenda - $precoMedioAtual) * $quantidadeVendida;
                    $ativo->preco_medio = $precoMedioAtual + ($diferenca / $quantidadeRestante);
                } else {
                    // Se não houver mais ativos, define o preço médio como 0
                    $ativo->preco_medio = 0;
                }
            }

            // Atualiza a quantidade total do ativo (considerando compras e vendas)
            $quantidadeTotal = $ativo->operacoes()->where('tipo', 'C')->sum('qtd') -
                               $ativo->operacoes()->where('tipo', 'V')->sum('qtd');

            $ativo->quantidade_total = $quantidadeTotal;
            $ativo->save();
        }
    }

    /**
     * Executa após uma operação ser atualizada.
     *
     * @param Operacao $operacao
     * @return void
     */
    public function updated(Operacao $operacao)
    {
        // Recalcula o preço médio e a quantidade total se a operação for atualizada
        $this->recalcularAtivo($operacao->ativo_id);
    }

    /**
     * Executa após uma operação ser deletada.
     *
     * @param Operacao $operacao
     * @return void
     */
    public function deleted(Operacao $operacao)
    {
        // Recalcula o preço médio e a quantidade total se a operação for deletada
        $this->recalcularAtivo($operacao->ativo_id);
    }

    /**
     * Recalcula o preço médio e a quantidade total do ativo.
     *
     * @param int $ativoId
     * @return void
     */
    private function recalcularAtivo($ativoId)
    {
        $ativo = Ativo::find($ativoId);

        if ($ativo) {
            // Recalcula o preço médio (apenas para compras)
            $quantidadeTotalCompras = $ativo->operacoes()->where('tipo', 'C')->sum('qtd');
            $totalGasto = $ativo->operacoes()->where('tipo', 'C')->sum(\DB::raw('qtd * valor_unitario'));

            if ($quantidadeTotalCompras > 0) {
                $ativo->preco_medio = $totalGasto / $quantidadeTotalCompras;
            } else {
                $ativo->preco_medio = 0; // Se não houver compras, define o preço médio como 0
            }

            // Recalcula a quantidade total (considerando compras e vendas)
            $quantidadeTotal = $ativo->operacoes()->where('tipo', 'C')->sum('qtd') -
                               $ativo->operacoes()->where('tipo', 'V')->sum('qtd');

            $ativo->quantidade_total = $quantidadeTotal;
            $ativo->save();
        }
    }
}
