<?php

namespace Database\Seeders;

use App\Models\ClienteSistemaPreventivo;
use App\Models\GrupoPermissao;

use Illuminate\Database\Seeder;

class Z_Faker7Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Submódulo Equipamentos Preventivos''''''''''''''''''''''''''''''''''''''''

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 236]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 237]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 238]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 239]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 240]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Sistemas Preventivos''''''''''''''''''''''''''''''''''''''''''''

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 226]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 227]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 228]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 229]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 230]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
