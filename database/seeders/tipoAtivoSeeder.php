<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\tipoAtivo;

class tipoAtivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tipoAtivo::create([
            //01
            'tipoAtivo'=>'Ações',
        ]);
        tipoAtivo::create([
            //02
            'tipoAtivo'=>'FII',
        ]);
        tipoAtivo::create([
            //03
            'tipoAtivo'=>'RF',
        ]);
        tipoAtivo::create([
            //04
            'tipoAtivo'=>'Cripto',
        ]);
        tipoAtivo::create([
            //05
            'tipoAtivo'=>'FI',
        ]);
    }
}
