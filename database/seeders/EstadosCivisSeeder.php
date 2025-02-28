<?php

namespace Database\Seeders;

use App\Models\EstadoCivil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosCivisSeeder extends Seeder
{
    public function run()
    {
        EstadoCivil::create(['name' => 'Solteiro(a)']);
        EstadoCivil::create(['name' => 'Casado(a)']);
        EstadoCivil::create(['name' => 'Divorciado(a)']);
        EstadoCivil::create(['name' => 'Viúvo(a)']);
        EstadoCivil::create(['name' => 'Separado(a) judicialmente']);
    }
}
