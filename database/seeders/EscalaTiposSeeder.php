<?php

namespace Database\Seeders;

use App\Models\EscalaTipo;
use Illuminate\Database\Seeder;

class EscalaTiposSeeder extends Seeder
{
    public function run()
    {
        //criando
        EscalaTipo::create(['name' => '12x36', 'quantidade_alas' => 4, 'quantidade_horas_trabalhadas' => 12, 'quantidade_horas_descanso' => 36]);
        EscalaTipo::create(['name' => '24x48', 'quantidade_alas' => 3, 'quantidade_horas_trabalhadas' => 24, 'quantidade_horas_descanso' => 48]);
        EscalaTipo::create(['name' => '24x72', 'quantidade_alas' => 4, 'quantidade_horas_trabalhadas' => 24, 'quantidade_horas_descanso' => 72]);
    }
}
