<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE VIEW proventos_ativos_cart_2 AS SELECT
            `d`.`id_ativo`    AS `id_ativo`,
            `o`.`id_carteira` AS `id_carteira`,
            `a`.`Ticket`      AS `ticket_ativo`,
            `d`.`data_com`    AS `data_com`,
            `d`.`data_pag`    AS `data_pag`,
            SUM((CASE WHEN (`o`.`tipo` = 'C') THEN `o`.`qtd` WHEN (`o`.`tipo` = 'V') THEN -(`o`.`qtd`) ELSE 0 END)) AS `saldo_operacoes`,
            (`d`.`valor_total` * SUM((CASE WHEN (`o`.`tipo` = 'C') THEN `o`.`qtd` WHEN (`o`.`tipo` = 'V') THEN -(`o`.`qtd`) ELSE 0 END))) AS `provento`
            FROM ((`dividendos` `d`
                JOIN `ativos` `a`
                ON ((`d`.`id_ativo` = `a`.`id`)))
            LEFT JOIN `operacaos` `o`
                ON (((`d`.`id_ativo` = `o`.`id_ativo`)
                    AND (`o`.`id_carteira` = 2)
                    AND (`o`.`data` <= `d`.`data_com`))))
            GROUP BY `d`.`id_ativo`,`a`.`Ticket`,`d`.`data_pag`
            ORDER BY `d`.`data_com` DESC;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proventos_ativos_cart_02_view');
    }
};
