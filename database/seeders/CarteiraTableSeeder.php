<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carteira;

class CarteiraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carteira::create([
            'Nome'=>'Marina',
            'Proprietario'=>'Marina Júlia',
            'Valor_Investido'=>'8971.72',
            'Valor_Mercado'=>'7933.22',
            'Resultado'=>'-11.58',
        ]);
        Carteira::create([
            'Nome'=>'Fernando',
            'Proprietario'=>'José Fernando da Silva',
            'Valor_Investido'=>'7500.00',
            'Valor_Mercado'=>'800.00',
            'Resultado'=>'-1.00',
        ]);
      
    }
}
