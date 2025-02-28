<?php

namespace Database\Seeders;

use App\Models\ServicoTipo;
use Illuminate\Database\Seeder;

class ServicoTiposSeeder extends Seeder
{
    public function run()
    {
        //criando
        ServicoTipo::create(['id' => 1, 'name' => 'BRIGADA DE INCÊNDIO']);
        ServicoTipo::create(['id' => 2, 'name' => 'MANUTENÇÃO']);
        ServicoTipo::create(['id' => 3, 'name' => 'VISITA TÉCNICA']);
    }
}
