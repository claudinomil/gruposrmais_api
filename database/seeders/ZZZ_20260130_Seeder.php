<?php

namespace Database\Seeders;

use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Permissao;
use App\Models\GrupoPermissao;

use Illuminate\Database\Seeder;

class ZZZ_20260130_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Módulo Controle Preventivos e seus Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Criar Módulo''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Modulo::create(['id' => 11, 'name' => 'Controle Preventivos', 'menu_text' => 'Controle Preventivos', 'menu_url' => 'controle_preventivos', 'menu_route' => 'controle_preventivos', 'menu_icon' => 'bx bxs-check-shield', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 87]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Edificações'''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 44, 'modulo_id' => 11, 'name' => 'Edificações', 'menu_text' => 'Edificações', 'menu_url' => 'edificacoes', 'menu_route' => 'edificacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'edificacoes', 'prefix_route' => 'edificacoes', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 10]);

        // Criar Permissões
        Permissao::create(['id' => 201, 'submodulo_id' => 44, 'name' => 'edificacoes_list', 'description' => 'Visualizar Registro - Edificações']);
        Permissao::create(['id' => 202, 'submodulo_id' => 44, 'name' => 'edificacoes_create', 'description' => 'Criar Registro - Edificações']);
        Permissao::create(['id' => 203, 'submodulo_id' => 44, 'name' => 'edificacoes_show', 'description' => 'Visualizar Registro - Edificações']);
        Permissao::create(['id' => 204, 'submodulo_id' => 44, 'name' => 'edificacoes_edit', 'description' => 'Editar Registro - Edificações']);
        Permissao::create(['id' => 205, 'submodulo_id' => 44, 'name' => 'edificacoes_destroy', 'description' => 'Deletar Registro - Edificações']);

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 201]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 202]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 203]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 204]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 205]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Edificações Locais''''''''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 46, 'modulo_id' => 11, 'name' => 'Edificações - Locais', 'menu_text' => 'Locais', 'menu_url' => 'edificacoes_locais', 'menu_route' => 'edificacoes_locais', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'edificacoes_locais', 'prefix_route' => 'edificacoes_locais', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 30]);

        // Criar Permissões
        Permissao::create(['id' => 211, 'submodulo_id' => 46, 'name' => 'edificacoes_locais_list', 'description' => 'Visualizar Registro - Edificações Locais']);
        Permissao::create(['id' => 212, 'submodulo_id' => 46, 'name' => 'edificacoes_locais_create', 'description' => 'Criar Registro - Edificações Locais']);
        Permissao::create(['id' => 213, 'submodulo_id' => 46, 'name' => 'edificacoes_locais_show', 'description' => 'Visualizar Registro - Edificações Locais']);
        Permissao::create(['id' => 214, 'submodulo_id' => 46, 'name' => 'edificacoes_locais_edit', 'description' => 'Editar Registro - Edificações Locais']);
        Permissao::create(['id' => 215, 'submodulo_id' => 46, 'name' => 'edificacoes_locais_destroy', 'description' => 'Deletar Registro - Edificações Locais']);

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 211]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 212]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 213]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 214]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 215]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Mapas Preventivos''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 47, 'modulo_id' => 11, 'name' => 'Mapas Preventivos', 'menu_text' => 'Mapas Preventivos', 'menu_url' => 'mapas_preventivos', 'menu_route' => 'mapas_preventivos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'mapas_preventivos', 'prefix_route' => 'mapas_preventivos', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 40]);

        // Criar Permissões
        Permissao::create(['id' => 216, 'submodulo_id' => 47, 'name' => 'mapas_preventivos_list', 'description' => 'Visualizar Registro - Mapas Preventivos']);
        Permissao::create(['id' => 217, 'submodulo_id' => 47, 'name' => 'mapas_preventivos_create', 'description' => 'Criar Registro - Mapas Preventivos']);
        Permissao::create(['id' => 218, 'submodulo_id' => 47, 'name' => 'mapas_preventivos_show', 'description' => 'Visualizar Registro - Mapas Preventivos']);
        Permissao::create(['id' => 219, 'submodulo_id' => 47, 'name' => 'mapas_preventivos_edit', 'description' => 'Editar Registro - Mapas Preventivos']);
        Permissao::create(['id' => 220, 'submodulo_id' => 47, 'name' => 'mapas_preventivos_destroy', 'description' => 'Deletar Registro - Mapas Preventivos']);

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 216]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 217]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 218]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 219]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 220]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Medidas Segurança'''''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 48, 'modulo_id' => 11, 'name' => 'Medidas Segurança', 'menu_text' => 'Medidas Segurança', 'menu_url' => 'medidas_seguranca', 'menu_route' => 'medidas_seguranca', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'medidas_seguranca', 'prefix_route' => 'medidas_seguranca', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 4]);

        // Criar Permissões
        Permissao::create(['id' => 221, 'submodulo_id' => 48, 'name' => 'medidas_seguranca_list', 'description' => 'Visualizar Registro - Medidas Segurança']);
        Permissao::create(['id' => 222, 'submodulo_id' => 48, 'name' => 'medidas_seguranca_create', 'description' => 'Criar Registro - Medidas Segurança']);
        Permissao::create(['id' => 223, 'submodulo_id' => 48, 'name' => 'medidas_seguranca_show', 'description' => 'Visualizar Registro - Medidas Segurança']);
        Permissao::create(['id' => 224, 'submodulo_id' => 48, 'name' => 'medidas_seguranca_edit', 'description' => 'Editar Registro - Medidas Segurança']);
        Permissao::create(['id' => 225, 'submodulo_id' => 48, 'name' => 'medidas_seguranca_destroy', 'description' => 'Deletar Registro - Medidas Segurança']);

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 221]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 222]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 223]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 224]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 225]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Sistemas Preventivos''''''''''''''''''''''''''''''''''''''''''''

        // Criar Submódulo
        Submodulo::create(['id' => 49, 'modulo_id' => 11, 'name' => 'Sistemas Preventivos', 'menu_text' => 'Sistemas Preventivos', 'menu_url' => 'sistemas_preventivos', 'menu_route' => 'sistemas_preventivos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'sistemas_preventivos', 'prefix_route' => 'sistemas_preventivos', 'mobile' => 0, 'menu_text_mobile' => 'Meus ', 'viewing_order' => 7]);

        // Criar Permissões
        Permissao::create(['id' => 226, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_list', 'description' => 'Visualizar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 227, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_create', 'description' => 'Criar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 228, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_show', 'description' => 'Visualizar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 229, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_edit', 'description' => 'Editar Registro - Sistemas Preventivos']);
        Permissao::create(['id' => 230, 'submodulo_id' => 49, 'name' => 'sistemas_preventivos_destroy', 'description' => 'Deletar Registro - Sistemas Preventivos']);

        // Criar Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 226]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 227]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 228]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 229]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 230]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submodulos alterar''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $submodulos = Submodulo::all();

        foreach ($submodulos as $submodulo) {
            if ($submodulo['id'] == 14) { // Funcionários
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'account-hard-hat']);
            } else if ($submodulo['id'] == 16) { // Clientes
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'account-tie']);
            } else if ($submodulo['id'] == 22) { // Visitas Técnicas
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'receipt-text-outline']);
            } else if ($submodulo['id'] == 26) { // Ordens Serviços
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'list-box-outline']);
            } else if ($submodulo['id'] == 33) { // Brigadas Incêndios
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'wall-fire']);
            } else {
                $submodulo->update(['mobile' => 0, 'mobile_icon' => 'help']);
            }
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
