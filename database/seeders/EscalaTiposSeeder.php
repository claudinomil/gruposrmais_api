<?php

namespace Database\Seeders;

use App\Models\EscalaJornada;
use Illuminate\Database\Seeder;

class EscalaTiposSeeder extends Seeder
{
    public function run()
    {
        //criando
        EscalaJornada::create(['name' => '12x36', 'quantidade_alas' => 4, 'quantidade_horas' => 12]);
        EscalaJornada::create(['name' => '24x48', 'quantidade_alas' => 3, 'quantidade_horas' => 24]);
        EscalaJornada::create(['name' => '24x72', 'quantidade_alas' => 4, 'quantidade_horas' => 24]);
    }
}
