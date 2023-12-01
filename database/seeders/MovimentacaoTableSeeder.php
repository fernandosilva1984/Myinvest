<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movimentacao;

class MovimentacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movimentacao::create([
            'id_carteira'=> '1',
            'data'=> '2023-10-01',
            'valor_total'=> '150.00',
            'tipo' => 'A',
        ]);
        Movimentacao::create([
            'id_carteira'=> '1',
            'data'=> '2023-10-01',
            'valor_total'=> '150.00',
            'tipo' => 'A',
        ]);
        Movimentacao::create([
           'id_carteira'=> '2',
            'data'=> '2023-11-01',
            'valor_total'=> '150.00',
            'tipo' => 'A',
        ]);
        Movimentacao::create([
           'id_carteira'=> '2',
           'data'=> '2023-11-01',
            'valor_total'=> '150.00',
            'tipo' => 'A',
        ]);
        Movimentacao::create([
            'id_carteira'=> '1',
            'data'=> '2023-11-01',
             'valor_total'=> '150.00',
             'tipo' => 'S',
         ]);
         Movimentacao::create([
            'id_carteira'=> '2',
            'data'=> '2023-11-01',
             'valor_total'=> '150.00',
             'tipo' => 'S',
        ]);
    }
}
