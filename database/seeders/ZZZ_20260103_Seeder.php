<?php

namespace Database\Seeders;

use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Modulo;
use App\Models\Permissao;
use App\Models\ProdutoEntradaItem;
use App\Models\ProdutoTipo;
use App\Models\Relatorio;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20260103_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Módulo Produtos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Módulo
        Modulo::where('id', 10)->update(['name' => 'Controle Produtos', 'menu_text' => 'Controle Produtos', 'menu_url' => 'controle_produtos', 'menu_route' => 'controle_produtos']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Submódulo Produtos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Submódulo
        Submodulo::where('id', 32)->update(['name' => 'Produtos', 'menu_text' => 'Produtos', 'menu_url' => 'produtos', 'menu_route' => 'produtos', 'prefix_permissao' => 'produtos', 'prefix_route' => 'produtos']);

        //Permissões
        Permissao::where('id', 152)->update(['name' => 'produtos_list', 'description' => 'Visualizar Registro - Produtos']);
        Permissao::where('id', 153)->update(['name' => 'produtos_create', 'description' => 'Criar Registro - Produtos']);
        Permissao::where('id', 154)->update(['name' => 'produtos_show', 'description' => 'Visualizar Registro - Produtos']);
        Permissao::where('id', 155)->update(['name' => 'produtos_edit', 'description' => 'Editar Registro - Produtos']);
        Permissao::where('id', 156)->update(['name' => 'produtos_destroy', 'description' => 'Deletar Registro - Produtos']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Produtos Entradas''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Submódulo
        Submodulo::where('id', 37)->update(['name' => 'Entradas', 'menu_text' => 'Entradas', 'menu_url' => 'produtos_entradas', 'menu_route' => 'produtos_entradas', 'prefix_permissao' => 'produtos_entradas', 'prefix_route' => 'produtos_entradas']);

        // Permissões
        Permissao::where('id', 177)->update(['name' => 'produtos_entradas_list', 'description' => 'Visualizar Registro - Entradas']);
        Permissao::where('id', 178)->update(['name' => 'produtos_entradas_create', 'description' => 'Criar Registro - Entradas']);
        Permissao::where('id', 179)->update(['name' => 'produtos_entradas_show', 'description' => 'Visualizar Registro - Entradas']);
        Permissao::where('id', 180)->update(['name' => 'produtos_entradas_edit', 'description' => 'Editar Registro - Entradas']);
        Permissao::where('id', 181)->update(['name' => 'produtos_entradas_destroy', 'description' => 'Deletar Registro - Entradas']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Produtos Movimentações''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::where('id', 38)->update(['name' => 'Movimentações', 'menu_text' => 'Movimentações', 'menu_url' => 'produtos_movimentacoes', 'menu_route' => 'produtos_movimentacoes', 'prefix_permissao' => 'produtos_movimentacoes', 'prefix_route' => 'produtos_movimentacoes']);

        // Permissões
        Permissao::where('id', 182)->update(['name' => 'produtos_movimentacoes_list', 'description' => 'Visualizar Registro - Produtos (Movimentações)']);
        Permissao::where('id', 183)->update(['name' => 'produtos_movimentacoes_create', 'description' => 'Criar Registro - Produtos (Movimentações)']);
        Permissao::where('id', 184)->update(['name' => 'produtos_movimentacoes_show', 'description' => 'Visualizar Registro - Produtos (Movimentações)']);
        Permissao::where('id', 185)->update(['name' => 'produtos_movimentacoes_edit', 'description' => 'Editar Registro - Produtos (Movimentações)']);
        Permissao::where('id', 186)->update(['name' => 'produtos_movimentacoes_destroy', 'description' => 'Deletar Registro - Produtos (Movimentações)']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Produtos Controle Situações'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::where('id', 39)->update(['name' => 'Controle Situações', 'menu_text' => 'Controle Situações', 'menu_url' => 'produtos_controle_situacoes', 'menu_route' => 'produtos_controle_situacoes', 'prefix_permissao' => 'produtos_controle_situacoes', 'prefix_route' => 'produtos_controle_situacoes']);

        // Permissões
        Permissao::where('id', 187)->update(['name' => 'produtos_controle_situacoes_list', 'description' => 'Visualizar Registro - Produtos Controle Situações']);
        Permissao::where('id', 188)->update(['name' => 'produtos_controle_situacoes_create', 'description' => 'Criar Registro - Produtos Controle Situações']);
        Permissao::where('id', 189)->update(['name' => 'produtos_controle_situacoes_show', 'description' => 'Visualizar Registro - Produtos Controle Situações']);
        Permissao::where('id', 190)->update(['name' => 'produtos_controle_situacoes_edit', 'description' => 'Editar Registro - Produtos Controle Situações']);
        Permissao::where('id', 191)->update(['name' => 'produtos_controle_situacoes_destroy', 'description' => 'Deletar Registro - Produtos Controle Situações']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Produtos Listagem Geral'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Submódulo
        Submodulo::where('id', 40)->update(['name' => 'Listagem Geral', 'menu_text' => 'Listagem Geral', 'menu_url' => 'produtos_listagem_geral', 'menu_route' => 'produtos_listagem_geral', 'prefix_permissao' => 'produtos_listagem_geral', 'prefix_route' => 'produtos_listagem_geral']);

        // Permissões
        Permissao::where('id', 192)->update(['name' => 'produtos_listagem_geral_list', 'description' => 'Visualizar Registro - Produtos Listagem Geral']);
        Permissao::where('id', 193)->update(['name' => 'produtos_listagem_geral_create', 'description' => 'Criar Registro - Produtos Listagem Geral']);
        Permissao::where('id', 194)->update(['name' => 'produtos_listagem_geral_show', 'description' => 'Visualizar Registro - Produtos Listagem Geral']);
        Permissao::where('id', 195)->update(['name' => 'produtos_listagem_geral_edit', 'description' => 'Editar Registro - Produtos Listagem Geral']);
        Permissao::where('id', 196)->update(['name' => 'produtos_listagem_geral_destroy', 'description' => 'Deletar Registro - Produtos Listagem Geral']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Produto Tipos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        ProdutoTipo::create(['id' => 1, 'name' => 'PATRIMÔNIO']);
        ProdutoTipo::create(['id' => 2, 'name' => 'ESTOQUE']);
        ProdutoTipo::create(['id' => 3, 'name' => 'UNIFORME']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Preencher campo produto_tipo_id na tabela produtos_entradas_itens''''''''''''''''''''''''''''''''''''''''''''
        for ($i = 1; $i < 400; $i++) {
            $item = ProdutoEntradaItem::find($i);

            if ($item) {
                $item->produto_tipo_id = 1;
                $item->produto_tipo_name = 'PATRIMÔNIO';
                $item->save();
            }
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
