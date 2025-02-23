<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracao;

class ConfiguracaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(): void
    {

        Configuracao::create([
            //01
            'CDI_atual'=>'13.15',
            'SELIC_atual'=>'13.50',
            'Corretagem_acoes'=>'0.030589',
            'Corretagem_fii'=>'0.030589',
            'Corretagem_Criptos'=>'1.52',

        ]);
    }
}
