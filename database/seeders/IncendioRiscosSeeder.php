<?php

namespace Database\Seeders;

use App\Models\IncendioRisco;
use Illuminate\Database\Seeder;

class IncendioRiscosSeeder extends Seeder
{
    public function run()
    {
        IncendioRisco::create(['name' => 'Pequeno']); //1
        IncendioRisco::create(['name' => 'Médio 1']); //2
        IncendioRisco::create(['name' => 'Médio 2']); //3
        IncendioRisco::create(['name' => 'Grande']); //4
    }
}
