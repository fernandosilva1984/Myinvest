<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreatePosicaoAtivosView extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'view:create-posicao-ativos';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Cria ou atualiza a view dinâmica de posição de ativos por data_com';

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        // Passo 1: Consultar as datas únicas da tabela dividendos
        $datasCom = DB::table('dividendos')
            ->select('data_com')
            ->distinct()
            ->orderBy('data_com')
            ->pluck('data_com')
            ->toArray();

        if (empty($datasCom)) {
            $this->error('Nenhuma data_com encontrada na tabela dividendos.');
            return;
        }

        // Passo 2: Montar a query SQL dinamicamente
        $colunasSaldo = [];
        foreach ($datasCom as $data) {
            $dataFormatada = date('Y_m_d', strtotime($data)); // Formata a data para ser usada como nome de coluna
            $colunasSaldo[] = "MAX(CASE WHEN s.data_com = '$data' THEN s.saldo ELSE 0 END) AS saldo_$dataFormatada";
        }
        $colunasSaldo = implode(', ', $colunasSaldo);

        $query = "
            CREATE OR REPLACE VIEW posicao_ativos_por_dividendo AS
            WITH saldos_por_data AS (
                SELECT
                    o.id_ativo,
                    d.data_com,
                    SUM(CASE WHEN o.tipo = 'compra' THEN o.qtd ELSE -o.qtd END) AS saldo
                FROM
                    operacaos o
                JOIN
                    dividendos d ON o.id_ativo = d.id_ativo
                WHERE
                    o.data <= d.data_com
                GROUP BY
                    o.id_ativo, d.data_com
            )
            SELECT
                a.Ticket AS ativo,
                $colunasSaldo
            FROM
                ativos a
            LEFT JOIN
                saldos_por_data s ON a.id = s.id_ativo
            GROUP BY
                a.Ticket;
        ";

        // Passo 3: Executar a query para criar ou atualizar a view
        DB::statement($query);

        $this->info('View "posicao_ativos_por_dividendo" criada ou atualizada com sucesso!');
        return 0;
    }
}
