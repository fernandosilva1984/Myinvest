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
        CREATE VIEW proventos_ativos AS 
            select
            `d`.`id_ativo` AS `id_ativo`,
            `a`.`Ticket`   AS `ticket_ativo`,
            `d`.`data_com` AS `data_com`,
            `d`.`data_pag`    AS `data_pag`,
            sum((case when (`o`.`tipo` = 'C') then `o`.`qtd` when (`o`.`tipo` = 'V') then -(`o`.`qtd`) else 0 end)) AS `saldo_operacoes`,
            (`d`.`valor_total` * SUM((CASE WHEN (`o`.`tipo` = 'C') THEN `o`.`qtd` WHEN (`o`.`tipo` = 'V') THEN -(`o`.`qtd`) ELSE 0 END))) AS `provento`
            from ((`dividendos` `d`
                join `ativos` `a`
                on ((`d`.`id_ativo` = `a`.`id`)))
            left join `operacaos` `o`
                on (((`d`.`id_ativo` = `o`.`id_ativo`)
                    and (`o`.`data` <= `d`.`data_com`))))
            group by `d`.`id_ativo`,`a`.`Ticket`,`d`.`data_com`
            order by `d`.`id_ativo`,`d`.`data_pag`;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proventos_ativos_view');
    }
};
