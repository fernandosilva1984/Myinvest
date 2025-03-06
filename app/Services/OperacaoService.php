<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OperacaoService
{
    public function calcularPrecoMedioEResultado($idCarteira, $idAtivo, $data, $qtd, $valorUnitario, $valorTotal)
    {
        // Chama a procedure no banco de dados
        DB::statement('CALL CalcularPrecoMedioEResultado(?, ?, ?, ?, ?, ?)', [
            $idCarteira,
            $idAtivo,
            $data,
            $qtd,
            $valorUnitario,
            $valorTotal,
        ]);
    }
}