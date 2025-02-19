<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banco;

class BancoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banco::create([
            //01
            'nome'=> 'BANCO INTER',
            'razao_social'=> 'BANCO INTER SA',
            'CNPJ'=> '1',
            'logradouro'=> 'AV 19 de maio',
            'bairro'=>'Centro',
            'cidade' => 'LAJEDO',
            'UF'=>'PE',
        ]);
        Banco::create([
            //02
            'nome'=> 'CAIXA ECONOMICA',
            'razao_social'=> 'CEF SA',
            'CNPJ'=> '2',
            'logradouro'=> 'AV 19 de maio',
            'bairro'=>'Centro',
            'cidade' => 'LAJEDO',
            'UF'=>'PE',
        ]);
        Banco::create([
            //03
            'nome'=> 'BANCO DO BRASIL',
            'razao_social'=> 'BB SA',
            'CNPJ'=> '3',
            'logradouro'=> 'AV 19 de maio',
            'bairro'=>'Centro',
            'cidade' => 'LAJEDO',
            'UF'=>'PE',
        ]);
        Banco::create([
            //04
            'nome'=> 'MERCADO PAGO',
            'razao_social'=> 'MERCADO PAGO SA',
            'CNPJ'=> '4',
            'logradouro'=> 'AV 19 de maio',
            'bairro'=>'Centro',
            'cidade' => 'LAJEDO',
            'UF'=>'PE',
        ]);
    }
}
