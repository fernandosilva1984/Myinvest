<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateViewPosicaoAtivos extends Command
{
    protected $signature = 'view:generate-posicao-ativos';
    protected $description = 'Cria a View view_posicao_ativos dinamicamente com base nas datas da tabela dividendos';

    public function handle()
    {
        $this->info("Gerando a view view_posicao_ativos...");

        // Obtém todas as datas distintas da tabela dividendos
        $datas = DB::table('dividendos')->distinct()->orderBy('data_com')->pluck('data_com');

        if ($datas->isEmpty()) {
            $this->error("Nenhuma data encontrada na tabela dividendos. A view não foi criada.");
            return;
        }

        // Monta as colunas dinamicamente
        $columns = "";
        foreach ($datas as $data) {
            $colName = "posicao_" . str_replace("-", "_", $data);
            $columns .= "SUM(CASE
                              WHEN o.data <= '$data' THEN o.qtd * (CASE WHEN o.tipo = 'compra' THEN 1 ELSE -1 END)
                              ELSE 0
                          END) AS `$colName`,\n";
        }

        // Monta o SQL final da View
        $sql = "
        CREATE or replace VIEW view_posicao_ativos AS
        SELECT
            a.id AS id_ativo,
            a.Ticket,
            $columns
            0 AS `dummy_column`
        FROM ativos a
        LEFT JOIN operacaos o ON a.id = o.id_ativo
        LEFT JOIN dividendos d ON a.id = d.id_ativo
        GROUP BY a.id, a.Ticket;
        ";

        // Remove a View antiga, se existir
        DB::statement("DROP VIEW IF EXISTS view_posicao_ativos;");

        // Cria a nova View
        DB::statement($sql);

        $this->info("View view_posicao_ativos criada com sucesso!");
    }
}
