<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Grafico;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\Modulo;
use App\Models\Permissao;
use App\Models\Relatorio;
use App\Models\Submodulo;
use App\Models\VisitaTecnicaPergunta;
use Illuminate\Database\Seeder;

class ZZZ_20260125_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Gráficos - Sistema Padrão Update'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::where('id', 1)->update(['sistema' => 1]);
        Grafico::where('id', 2)->update(['sistema' => 1]);
        Grafico::where('id', 3)->update(['sistema' => 1]);
        Grafico::where('id', 4)->update(['sistema' => 1]);
        Grafico::where('id', 5)->update(['sistema' => 1]);
        Grafico::where('id', 6)->update(['sistema' => 1]);
        Grafico::where('id', 7)->update(['sistema' => 1]);
        Grafico::where('id', 8)->update(['sistema' => 1]);
        Grafico::where('id', 9)->update(['sistema' => 1]);
        Grafico::where('id', 10)->update(['sistema' => 1]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos - Sistema Domínio Clientes - Create'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::create(['id' => 11, 'sistema' => 2, 'name' => 'Funcionários Contratações', 'dashboard' => 1, 'tipo' => 2, 'ordem_visualizacao' => 10]);
        Grafico::create(['id' => 12, 'sistema' => 2, 'name' => 'Funcionários Funções', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 20]);
        Grafico::create(['id' => 13, 'sistema' => 2, 'name' => 'Funcionários Gêneros', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 30]);
        Grafico::create(['id' => 14, 'sistema' => 2, 'name' => 'Operações', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 5]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatórios - Sistema Padrão Update'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Relatorio::where('id', 1)->update(['sistema' => 1]);
        Relatorio::where('id', 2)->update(['sistema' => 1]);
        Relatorio::where('id', 3)->update(['sistema' => 1]);
        Relatorio::where('id', 6)->update(['sistema' => 1]);
        Relatorio::where('id', 7)->update(['sistema' => 1]);
        Relatorio::where('id', 8)->update(['sistema' => 1]);
        Relatorio::where('id', 9)->update(['sistema' => 1]);
        Relatorio::where('id', 10)->update(['sistema' => 1]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatórios - Sistema Domínio Clientes - Create'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Relatorio::create(['id' => 11, 'sistema' => 2, 'name' => 'Segurança', 'descricao' => '', 'ordem_visualizacao' => 10]);
        Relatorio::create(['id' => 12, 'sistema' => 2, 'name' => 'Ponto de Interesse', 'descricao' => '', 'ordem_visualizacao' => 20]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Domínio Clientes'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Dados - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 43, 'modulo_id' => 3, 'name' => 'Clientes Relatórios', 'menu_text' => 'Relatórios', 'menu_url' => 'clientes_relatorios', 'menu_route' => 'clientes_relatorios', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes_relatorios', 'prefix_route' => 'clientes_relatorios', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 10]);

        // Permissões
        Permissao::create(['id' => 200, 'submodulo_id' => 43, 'name' => 'clientes_relatorios_list', 'description' => '']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 200]);
        // Dados - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
