<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cotacao;

class CotacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cotacao::create([
            'id_ativo'=> '1',
            'data_hora'=> '2023-10-01 23:59:59',
            'valor'=> '10.00',
        ]);
        Cotacao::create([
            'id_ativo'=> '1',
            'data_hora'=> '2023-10-01 20:59:59',
            'valor'=> '10.20',
        ]);
        Cotacao::create([
            'id_ativo'=> '1',
            'data_hora'=> '2023-10-01 21:59:59',
            'valor'=> '10.10',
        ]);
        Cotacao::create([
            'id_ativo'=> '1',
            'data_hora'=> '2023-10-01 22:59:59',
            'valor'=> '10.15',
        ]);
        Cotacao::create([
            'id_ativo'=> '2',
            'data_hora'=> '2023-10-01 23:59:59',
            'valor'=> '25.00',
        ]);
        Cotacao::create([
            'id_ativo'=> '2',
            'data_hora'=> '2023-10-01 22:59:59',
            'valor'=> '25.50',
        ]);
    }
}
