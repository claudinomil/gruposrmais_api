<?php

namespace Database\Seeders;

use App\Models\GrupoPermissao;
use App\Models\Modulo;
use App\Models\Permissao;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20251206_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Criar Módulo'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Modulo::create(['id' => 10, 'name' => 'Patrimônio', 'menu_text' => 'Patrimônio', 'menu_url' => 'patrimonio', 'menu_route' => 'patrimonio', 'menu_icon' => 'bx bxs-box', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 85]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Alterar localização do submodulo dentro do modulo''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Submodulo::where('id', 32)->update(['modulo_id' => 10, 'viewing_order' => 10]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Clientes Locais''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 36, 'modulo_id' => 7, 'name' => 'Clientes (Locais)', 'menu_text' => 'Clientes (Locais)', 'menu_url' => 'clientes_locais', 'menu_route' => 'clientes_locais', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes_locais', 'prefix_route' => 'clientes_locais', 'mobile' => 0, 'menu_text_mobile' => 'Meus Clientes Locais', 'viewing_order' => 15]);

        // Permissões
        Permissao::create(['id' => 172, 'submodulo_id' => 36, 'name' => 'clientes_locais_list', 'description' => 'Visualizar Registro - Clientes (Locais)']);
        Permissao::create(['id' => 173, 'submodulo_id' => 36, 'name' => 'clientes_locais_create', 'description' => 'Criar Registro - Clientes (Locais)']);
        Permissao::create(['id' => 174, 'submodulo_id' => 36, 'name' => 'clientes_locais_show', 'description' => 'Visualizar Registro - Clientes (Locais)']);
        Permissao::create(['id' => 175, 'submodulo_id' => 36, 'name' => 'clientes_locais_edit', 'description' => 'Editar Registro - Clientes (Locais)']);
        Permissao::create(['id' => 176, 'submodulo_id' => 36, 'name' => 'clientes_locais_destroy', 'description' => 'Deletar Registro - Clientes (Locais)']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 172]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 173]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 174]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 175]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 176]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Materiais Entradas''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 37, 'modulo_id' => 10, 'name' => 'Materiais (Entradas)', 'menu_text' => 'Materiais (Entradas)', 'menu_url' => 'materiais_entradas', 'menu_route' => 'materiais_entradas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'materiais_entradas', 'prefix_route' => 'materiais_entradas', 'mobile' => 0, 'menu_text_mobile' => 'Meus Materiais Entradas', 'viewing_order' => 20]);

        // Permissões
        Permissao::create(['id' => 177, 'submodulo_id' => 37, 'name' => 'materiais_entradas_list', 'description' => 'Visualizar Registro - Materiais (Entradas)']);
        Permissao::create(['id' => 178, 'submodulo_id' => 37, 'name' => 'materiais_entradas_create', 'description' => 'Criar Registro - Materiais (Entradas)']);
        Permissao::create(['id' => 179, 'submodulo_id' => 37, 'name' => 'materiais_entradas_show', 'description' => 'Visualizar Registro - Materiais (Entradas)']);
        Permissao::create(['id' => 180, 'submodulo_id' => 37, 'name' => 'materiais_entradas_edit', 'description' => 'Editar Registro - Materiais (Entradas)']);
        Permissao::create(['id' => 181, 'submodulo_id' => 37, 'name' => 'materiais_entradas_destroy', 'description' => 'Deletar Registro - Materiais (Entradas)']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 177]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 178]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 179]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 180]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 181]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Materiais Movimentações''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 38, 'modulo_id' => 10, 'name' => 'Materiais (Movimentações)', 'menu_text' => 'Materiais (Movimentações)', 'menu_url' => 'materiais_movimentacoes', 'menu_route' => 'materiais_movimentacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'materiais_movimentacoes', 'prefix_route' => 'materiais_movimentacoes', 'mobile' => 0, 'menu_text_mobile' => 'Meus Materiais Movimentações', 'viewing_order' => 30]);

        // Permissões
        Permissao::create(['id' => 182, 'submodulo_id' => 38, 'name' => 'materiais_movimentacoes_list', 'description' => 'Visualizar Registro - Materiais (Movimentações)']);
        Permissao::create(['id' => 183, 'submodulo_id' => 38, 'name' => 'materiais_movimentacoes_create', 'description' => 'Criar Registro - Materiais (Movimentações)']);
        Permissao::create(['id' => 184, 'submodulo_id' => 38, 'name' => 'materiais_movimentacoes_show', 'description' => 'Visualizar Registro - Materiais (Movimentações)']);
        Permissao::create(['id' => 185, 'submodulo_id' => 38, 'name' => 'materiais_movimentacoes_edit', 'description' => 'Editar Registro - Materiais (Movimentações)']);
        Permissao::create(['id' => 186, 'submodulo_id' => 38, 'name' => 'materiais_movimentacoes_destroy', 'description' => 'Deletar Registro - Materiais (Movimentações)']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 182]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 183]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 184]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 185]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 186]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
