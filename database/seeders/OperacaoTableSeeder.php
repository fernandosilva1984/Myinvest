<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Operacao;

class OperacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operacao::create([
            'id_carteira'=> '1',
            'id_ativo'=> '1',
            'data'=> '2023-10-01',
            'qtd' => '5',
            'valor_unitario'=> '10.00',
            'obs'=>'sem observação',
            'tipo' => 'C',
        ]);
        Operacao::create([
            'id_carteira'=> '1',
            'id_ativo'=> '2',
            'data'=> '2023-11-01',
            'qtd' => '50',
            'valor_unitario'=> '10.00',
            'tipo' => 'C',
        ]);
        Operacao::create([
            'id_carteira'=> '2',
            'id_ativo'=> '2',
            'data'=> '2023-06-01',
            'qtd' => '20',
            'valor_unitario'=> '100.00',
            'tipo' => 'C',
        ]);
        Operacao::create([
            'id_carteira'=> '1',
            'id_ativo'=> '2',
            'data'=> '2023-10-01',
            'qtd' => '5',
            'valor_unitario'=> '10.00',
            'tipo' => 'V',
        ]);
        Operacao::create([
            'id_carteira'=> '1',
            'id_ativo'=> '1',
            'data'=> '2023-10-01',
            'qtd' => '5',
            'valor_unitario'=> '10.00',
            'tipo' => 'V',
        ]);
    }
}
