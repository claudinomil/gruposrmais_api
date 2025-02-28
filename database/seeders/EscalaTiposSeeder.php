<?php

namespace Database\Seeders;

use App\Models\EscalaTipo;
use Illuminate\Database\Seeder;

class EscalaTiposSeeder extends Seeder
{
    public function run()
    {
        //criando
        EscalaTipo::create(['name' => '12x36', 'quantidade_alas' => 4, 'quantidade_horas' => 12]);
        EscalaTipo::create(['name' => '24x48', 'quantidade_alas' => 3, 'quantidade_horas' => 24]);
        EscalaTipo::create(['name' => '24x72', 'quantidade_alas' => 4, 'quantidade_horas' => 24]);
    }
}
