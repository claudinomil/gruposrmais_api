<?php

namespace Database\Seeders;

use App\Models\ContratacaoTipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContratacaoTiposSeeder extends Seeder
{
    public function run()
    {
        //criando
        ContratacaoTipo::create(['name' => 'CLT']);
        ContratacaoTipo::create(['name' => 'MEI']);
        ContratacaoTipo::create(['name' => 'Obra Certa']);
        ContratacaoTipo::create(['name' => 'Cadastro de Reserva']);
        ContratacaoTipo::create(['name' => 'Não Informado']);
    }
}
