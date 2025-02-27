<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSaldoAtivosView extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW saldo_ativos AS
            SELECT
                o.id_ativo,
                o.id_carteira,
                SUM(CASE WHEN o.qtd > 0 THEN o.qtd ELSE -o.qtd END) AS saldo
            FROM operacoes o
            GROUP BY o.id_ativo, o.id_carteira;
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS saldo_ativos");
    }
}
