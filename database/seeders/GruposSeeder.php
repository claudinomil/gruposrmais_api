<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    public function run()
    {
        Grupo::create(['empresa_id' => 1, 'name' => 'ADMINISTRADOR']);
    }
}
