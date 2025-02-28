<?php

namespace Database\Seeders;

use App\Models\EscalaFrequencia;
use Illuminate\Database\Seeder;

class EscalaFrequenciasSeeder extends Seeder
{
    public function run()
    {
        //criando
        EscalaFrequencia::create(['name' => 'PRESENÇA']);
        EscalaFrequencia::create(['name' => 'ATRASO']);
        EscalaFrequencia::create(['name' => 'FALTA']);
    }
}
