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
            'tipoAtivo'=>'Ações',
        ]);
        tipoAtivo::create([
            'tipoAtivo'=>'FII',
        ]);
        tipoAtivo::create([
            'tipoAtivo'=>'RF',
        ]);
        tipoAtivo::create([
            'tipoAtivo'=>'Cripto',
        ]);
    }
}
