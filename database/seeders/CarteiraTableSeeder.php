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
            //1
            'Nome'=>'Marina',
            'Proprietario'=>'Marina Júlia Oliveira Silva',
        ]);
        Carteira::create([
            //2
            'Nome'=>'Fernando',
            'Proprietario'=>'José Fernando da Silva',
        ]);
        Carteira::create([
            //3
            'Nome'=>'Líbina',
            'Proprietario'=>'Líbina Oliveira dos Santos Silva',
        ]);
        Carteira::create([
            //4
            'Nome'=>'Ester',
            'Proprietario'=>'Ester Oliveira Silva',
        ]);
        Carteira::create([
            //5
            'Nome'=>'Dona Lita',
            'Proprietario'=>'Carmelita Matias da Silva',
        ]);
        Carteira::create([
            //6
            'Nome'=>'Florentino',
            'Proprietario'=>'Florentino Caetano da Silva',
        ]);
        Carteira::create([
            //7
            'Nome'=>'Flávio',
            'Proprietario'=>'Flávio Florentino da Silva',
        ]);

    }
}
