<?php

namespace Database\Seeders;

use App\Models\Estoque;
use App\Models\EstoqueLocal;
use App\Models\Permissao;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20251210_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Submódulo Clientes Locais para Estoques Locais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::where('id', 36)->update([
            'modulo_id' => 10,
            'name' => 'Locais',
            'menu_text' => 'Locais',
            'menu_url' => 'estoques_locais',
            'menu_route' => 'estoques_locais',
            'menu_icon' => 'fas fa-angle-right',
            'prefix_permissao' => 'estoques_locais',
            'prefix_route' => 'estoques_locais',
            'mobile' => 0,
            'menu_text_mobile' => 'Meus Estoques Locais',
            'viewing_order' => 20
        ]);

        // Permissões
        Permissao::where('id', 172)->update(['name' => 'estoques_locais_list']);
        Permissao::where('id', 173)->update(['name' => 'estoques_locais_create']);
        Permissao::where('id', 174)->update(['name' => 'estoques_locais_show']);
        Permissao::where('id', 175)->update(['name' => 'estoques_locais_edit']);
        Permissao::where('id', 176)->update(['name' => 'estoques_locais_destroy']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Materiais Entradas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::where('id', 37)->update([
            'name' => 'Entradas',
            'menu_text' => 'Entradas',
            'viewing_order' => 30
        ]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo Materiais Movimentações''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::where('id', 38)->update([
            'name' => 'Movimentações',
            'menu_text' => 'Movimentações',
            'viewing_order' => 40
        ]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Estoques'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Estoque::create(['id' => 1, 'name' => 'Empresa', 'ordem' => 1]);
        Estoque::create(['id' => 2, 'name' => 'Cliente', 'ordem' => 2]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Estoques Locais''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        EstoqueLocal::create(['id' => 1, 'name' => 'ALMOXARIFADO GLOBAL', 'estoque_id' => 1, 'empresa_id' => 1]);
        EstoqueLocal::create(['id' => 2, 'name' => 'ALMOXARIFADO GLOBAL', 'estoque_id' => 1, 'empresa_id' => 2]);
        EstoqueLocal::create(['id' => 3, 'name' => 'ALMOXARIFADO', 'estoque_id' => 2, 'cliente_id' => 1]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
