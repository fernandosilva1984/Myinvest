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
            //01
            'SegmentoAtivo'=>'Bancos',
        ]);
        segmentoAtivo::create([
            //02
            'SegmentoAtivo'=>'Energia',
        ]);
        segmentoAtivo::create([
            //03
            'SegmentoAtivo'=>'Petroleo e Gás',
        ]);
        segmentoAtivo::create([
            //04
            'SegmentoAtivo'=>'Financeiro',
        ]);
        segmentoAtivo::create([
            //05
            'SegmentoAtivo'=>'Bebidas',
        ]);
        segmentoAtivo::create([
            //06
            'SegmentoAtivo'=>'CDB',
        ]);
        segmentoAtivo::create([
            //07
            'SegmentoAtivo'=>'LCI',
        ]);
        segmentoAtivo::create([
            //08
            'SegmentoAtivo'=>'LCA',
        ]);
        segmentoAtivo::create([
            //09
            'SegmentoAtivo'=>'Cripto',
        ]);
        segmentoAtivo::create([
            //10
            'SegmentoAtivo'=>'Títulos e Val. Mob.',
        ]);
        segmentoAtivo::create([
            //11
            'SegmentoAtivo'=>'Shoppings',
        ]);
        segmentoAtivo::create([
            //12
            'SegmentoAtivo'=>'Logística',
        ]);
        segmentoAtivo::create([
            //13
            'SegmentoAtivo'=>'Lajes Corporativas',
        ]);
        segmentoAtivo::create([
            //14
            'SegmentoAtivo'=>'Híbrido',
        ]);
        segmentoAtivo::create([
            //15
            'SegmentoAtivo'=>'Educacional',
        ]);
        segmentoAtivo::create([
            //16
            'SegmentoAtivo'=>'Outros',
        ]);
        segmentoAtivo::create([
            //17
            'SegmentoAtivo'=>'Residencial',
        ]);
        segmentoAtivo::create([
            //18
            'SegmentoAtivo'=>'SUBSCRIÇÃO',
        ]);
        segmentoAtivo::create([
            //19
            'SegmentoAtivo'=>'Varejo',
        ]);
        segmentoAtivo::create([
            //20
            'SegmentoAtivo'=>'Serviços',
        ]);
        segmentoAtivo::create([
            //21
            'SegmentoAtivo'=>'Seguros',
        ]);
        segmentoAtivo::create([
            //22
            'SegmentoAtivo'=>'Fundo de Investimento MM',
        ]);
    }
}
