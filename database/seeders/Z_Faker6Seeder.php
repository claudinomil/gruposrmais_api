<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Funcionario;
use App\Models\GrupoGrafico;
use App\Models\User;
use Illuminate\Database\Seeder;

class Z_Faker6Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Grupos Gráficos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 11]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 12]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 13]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 14]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 15]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 16]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
