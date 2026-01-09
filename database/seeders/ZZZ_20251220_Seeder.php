<?php

namespace Database\Seeders;

use App\Models\GrupoPermissao;
use Illuminate\Database\Seeder;
use App\Models\ProdutoSituacao;
use App\Models\Permissao;
use App\Models\Submodulo;

class ZZZ_20251220_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Submódulo Materiais Controle Situações'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 39, 'modulo_id' => 10, 'name' => 'Controle Situações', 'menu_text' => 'Controle Situações', 'menu_url' => 'materiais_controle_situacoes', 'menu_route' => 'materiais_controle_situacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'materiais_controle_situacoes', 'prefix_route' => 'materiais_controle_situacoes', 'mobile' => 0, 'menu_text_mobile' => 'Meus Materiais Controle Situações', 'viewing_order' => 50]);

        // Permissões
        Permissao::create(['id' => 187, 'submodulo_id' => 39, 'name' => 'materiais_controle_situacoes_list', 'description' => 'Visualizar Registro - Materiais Controle Situações']);
        Permissao::create(['id' => 188, 'submodulo_id' => 39, 'name' => 'materiais_controle_situacoes_create', 'description' => 'Criar Registro - Materiais Controle Situações']);
        Permissao::create(['id' => 189, 'submodulo_id' => 39, 'name' => 'materiais_controle_situacoes_show', 'description' => 'Visualizar Registro - Materiais Controle Situações']);
        Permissao::create(['id' => 190, 'submodulo_id' => 39, 'name' => 'materiais_controle_situacoes_edit', 'description' => 'Editar Registro - Materiais Controle Situações']);
        Permissao::create(['id' => 191, 'submodulo_id' => 39, 'name' => 'materiais_controle_situacoes_destroy', 'description' => 'Deletar Registro - Materiais Controle Situações']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 187]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 188]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 189]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 190]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 191]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Materiais Listagem Geral'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 40, 'modulo_id' => 10, 'name' => 'Listagem Geral', 'menu_text' => 'Listagem Geral', 'menu_url' => 'materiais_listagem_geral', 'menu_route' => 'materiais_listagem_geral', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'materiais_listagem_geral', 'prefix_route' => 'materiais_listagem_geral', 'mobile' => 0, 'menu_text_mobile' => 'Meus Materiais Listagem Geral', 'viewing_order' => 60]);

        // Permissões
        Permissao::create(['id' => 192, 'submodulo_id' => 40, 'name' => 'materiais_listagem_geral_list', 'description' => 'Visualizar Registro - Materiais Listagem Geral']);
        Permissao::create(['id' => 193, 'submodulo_id' => 40, 'name' => 'materiais_listagem_geral_create', 'description' => 'Criar Registro - Materiais Listagem Geral']);
        Permissao::create(['id' => 194, 'submodulo_id' => 40, 'name' => 'materiais_listagem_geral_show', 'description' => 'Visualizar Registro - Materiais Listagem Geral']);
        Permissao::create(['id' => 195, 'submodulo_id' => 40, 'name' => 'materiais_listagem_geral_edit', 'description' => 'Editar Registro - Materiais Listagem Geral']);
        Permissao::create(['id' => 196, 'submodulo_id' => 40, 'name' => 'materiais_listagem_geral_destroy', 'description' => 'Deletar Registro - Materiais Listagem Geral']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 192]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 193]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 194]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 195]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 196]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
