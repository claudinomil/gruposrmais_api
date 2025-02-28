<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerosSeeder extends Seeder
{
    public function run()
    {
        //criando Genero
        Genero::create(['name' => 'Masculino']);
        Genero::create(['name' => 'Feminino']);
    }
}
