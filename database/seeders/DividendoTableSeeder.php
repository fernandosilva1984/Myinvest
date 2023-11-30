<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dividendo;

class DividendoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dividendo::create([
        'id_ativo'=> '1',
        'data_ref'=> '2023-11-01',
        'valor_dividendo'=> '0.25',
        'valor_jcp'=> '0.15',
        'data_com'=> '2023-11-30',
        'data_pag'=> '2023-12-15',
        ]);
        Dividendo::create([
            'id_ativo'=> '1',
            'data_ref'=> '2023-10-01',
            'valor_dividendo'=> '0.50',
            'valor_jcp'=> '1.15',
            'data_com'=> '2023-10-30',
            'data_pag'=> '2023-12-30',
            ]);
        Dividendo::create([
        'id_ativo'=> '2',
        'data_ref'=> '2023-06-01',
        'valor_dividendo'=> '5.25',
        'valor_jcp'=> '0.00',
        'data_com'=> '2023-10-30',
        'data_pag'=> '2023-12-15',
        ]);
        Dividendo::create([
        'id_ativo'=> '2',
        'data_ref'=> '2023-05-01',
        'valor_dividendo'=> '3.0',
        'valor_jcp'=> '0.00',
        'data_com'=> '2023-05-15',
        'data_pag'=> '2023-06-06',
        ]);
    }
}
