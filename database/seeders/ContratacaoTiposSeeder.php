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
        ContratacaoTipo::create(['id' => 1, 'name' => 'CLT']);
        ContratacaoTipo::create(['id' => 2, 'name' => 'MEI']);
        ContratacaoTipo::create(['id' => 3, 'name' => 'Obra Certa']);
        ContratacaoTipo::create(['id' => 4, 'name' => 'Temporário']);
        ContratacaoTipo::create(['id' => 5, 'name' => 'Não Informado']);
    }
}
