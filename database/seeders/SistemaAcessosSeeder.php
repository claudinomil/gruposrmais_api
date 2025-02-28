<?php

namespace Database\Seeders;

use App\Models\SistemaAcesso;
use Illuminate\Database\Seeder;

class SistemaAcessosSeeder extends Seeder
{
    public function run()
    {
        SistemaAcesso::create(['name' => 'Somente Desktop']);
        SistemaAcesso::create(['name' => 'Somente Mobile']);
        SistemaAcesso::create(['name' => 'Desktop & Mobile']);
    }
}
