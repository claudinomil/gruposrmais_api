<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{
    public function run()
    {
        Empresa::create(['id' => 1, 'name' => 'SRMAIS']);
        Empresa::create(['id' => 2, 'name' => 'CONSULTORIA MAIS']);
    }
}
