<?php

namespace App\Services;

use App\Models\Ativo;
use App\Models\Dividendo;
use App\Models\Operacao;

class ProventoService
{
    public function getMatrizProventos()
    {
        // Obtém todos os ativos
        $ativos = Ativo::all();

        // Obtém todas as datas de proventos
        $datasProventos = Dividendo::distinct('data_pag')->pluck('data_pag');

        // Matriz para armazenar os resultados
        $matriz = [];

        foreach ($ativos as $ativo) {
            $linha = ['ativo.Ticket' => $ativo->nome];

            foreach ($datasProventos as $data) {
                // Calcula a quantidade líquida de ativos até a data do provento
                $quantidade = Operacao::where('id_ativo', $ativo->id)
                    ->where('data', '<=', $data)
                    ->sum('qtd');

                // Obtém o valor do provento naquela data
                $provento = Dividendo::where('id_ativo', $ativo->id)
                    ->where('data_pag', $data)
                    ->first();

                // Calcula o valor total do provento
                $valorTotal = $quantidade * ($provento ? $provento->valor_total : 0);

                $linha[$data] = $valorTotal;
            }

            $matriz[] = $linha;
        }

        return $matriz;
    }
}
