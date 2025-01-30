<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ativo;

class AtivoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ativo::create([
        'Ticket'=> 'BBAS3',
        'Razao_Social'=> 'Banco do Brasil SA',
        'CNPJ'=> '00000000000191',
        'Valor_mercado'=> '142869692617.20',
        'Valor_patrimonio'=> '153122204000.00',
        'qtd_cotas'=> '2865417020',
        'Valor_PCota'=> '87.56',
        'id_tipo'=> '1',
        'id_segmento'=> '1',
        ]);
        Ativo::create([
        'Ticket'=> 'ABEV3',
        'Razao_Social'=> 'Ambev SA',
        'CNPJ'=> '07526557000100',
        'Valor_mercado'=> '210786289339.92',
        'Valor_patrimonio'=> '90178032000.00',
        'qtd_cotas'=> '2865417020',
        'Valor_PCota'=> '5.72',
        'id_tipo'=> '1',
        'id_segmento'=> '5',
        ]);
      
    }
}
