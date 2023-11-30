<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'adm@adm.com',
            'password' => bcrypt('123456'),
            //'profile' => 'Administrador',
        ]);
        User::create([
            'name' => 'Fernando',
            'email' => 'fernando@adm.com',
            'password' => bcrypt('123456'),
            //'profile' => 'Administrador',
        ]);
      
    }
}
