<?php

namespace Database\Seeders;

use App\Models\GrupoPermissao;
use App\Models\Mapa;
use App\Models\MapaModelo;
use App\Models\MapaPontoTipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permissao;

class ZZZ_20250517_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Submódulos
        DB::table('submodulos')->insert([
            ['id' => '31', 'modulo_id' => '1', 'name' => 'Pontos de Interesse', 'menu_text' => 'Pontos de Interesse', 'menu_url' => 'mapas_pontos_interesse', 'menu_route' => 'mapas_pontos_interesse', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'mapas_pontos_interesse', 'prefix_route' => 'mapas_pontos_interesse', 'mobile' => 0, 'menu_text_mobile' => 'Meus Pontos de Interesse', 'viewing_order' => 118]
        ]);

        //Permissões
        Permissao::create(['id' => 147, 'submodulo_id' => 31, 'name' => 'mapas_pontos_interesse_list', 'description' => 'Visualizar Registro - Pontos de Interesse']);
        Permissao::create(['id' => 148, 'submodulo_id' => 31, 'name' => 'mapas_pontos_interesse_create', 'description' => 'Criar Registro - Pontos de Interesse']);
        Permissao::create(['id' => 149, 'submodulo_id' => 31, 'name' => 'mapas_pontos_interesse_show', 'description' => 'Visualizar Registro - Pontos de Interesse']);
        Permissao::create(['id' => 150, 'submodulo_id' => 31, 'name' => 'mapas_pontos_interesse_edit', 'description' => 'Editar Registro - Pontos de Interesse']);
        Permissao::create(['id' => 151, 'submodulo_id' => 31, 'name' => 'mapas_pontos_interesse_destroy', 'description' => 'Deletar Registro - Pontos de Interesse']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 147]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 148]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 149]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 150]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 151]);

        //Mapas Modelos
        MapaModelo::create(['id' => 1, 'name' => 'LIVRE']);
        MapaModelo::create(['id' => 2, 'name' => 'ORDEM SERVIÇO']);
        MapaModelo::create(['id' => 3, 'name' => 'SERVIÇO DIÁRIO']);
    }
}
