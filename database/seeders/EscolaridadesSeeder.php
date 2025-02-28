<?php

namespace Database\Seeders;

use App\Models\Escolaridade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscolaridadesSeeder extends Seeder
{
    public function run()
    {
        Escolaridade::create(['name' => 'Analfabeto']);
        Escolaridade::create(['name' => 'Até 5º Ano Incompleto']);
        Escolaridade::create(['name' => '5º Ano Completo']);
        Escolaridade::create(['name' => '6º ao 9º Ano do Fundamental']);
        Escolaridade::create(['name' => 'Fundamental Completo']);
        Escolaridade::create(['name' => 'Médio Incompleto']);
        Escolaridade::create(['name' => 'Médio Completo']);
        Escolaridade::create(['name' => 'Superior Incompleto']);
        Escolaridade::create(['name' => 'Superior Completo']);
        Escolaridade::create(['name' => 'Mestrado']);
        Escolaridade::create(['name' => 'Doutorado']);
        Escolaridade::create(['name' => 'Ignorado']);
    }
}
