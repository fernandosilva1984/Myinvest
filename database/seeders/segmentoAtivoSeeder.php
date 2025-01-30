<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\segmentoAtivo;

class segmentoAtivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        segmentoAtivo::create([
            'SegmentoAtivo'=>'Bancos',
        ]);
        segmentoAtivo::create([
            'SegmentoAtivo'=>'Energia',
        ]);
        segmentoAtivo::create([
            'SegmentoAtivo'=>'Petroleo e Gás',
        ]);
        segmentoAtivo::create([
            'SegmentoAtivo'=>'Financeiro',
        ]);
        segmentoAtivo::create([
            'SegmentoAtivo'=>'Bebidas',
        ]);
    }
}
