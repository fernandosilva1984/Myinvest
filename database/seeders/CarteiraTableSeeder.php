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

        ]);
        Carteira::create([
            'Nome'=>'Fernando',
            'Proprietario'=>'José Fernando da Silva',

        ]);

    }
}
