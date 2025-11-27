<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Grafico;
use App\Models\GrupoGrafico;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Permissao;
use App\Models\Relatorio;
use App\Models\Submodulo;

use Illuminate\Database\Seeder;

class ZZZ_20251114_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Submódulo Dashboards2'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Submódulo
        Submodulo::create(['id' => '34', 'modulo_id' => '1', 'name' => 'Dashboards 2', 'menu_text' => 'Dashboards 2', 'menu_url' => 'dashboards2', 'menu_route' => 'dashboards2', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'dashboards2', 'prefix_route' => 'dashboards2', 'mobile' => 0, 'menu_text_mobile' => 'Dashboard 2', 'viewing_order' => 20]);

        //Permissões
        Permissao::create(['id' => 162, 'submodulo_id' => 34, 'name' => 'dashboards2_list', 'description' => 'Visualizar Registro - Dashboards 2']);
        Permissao::create(['id' => 163, 'submodulo_id' => 34, 'name' => 'dashboards2_create', 'description' => 'Criar Registro - Dashboards 2']);
        Permissao::create(['id' => 164, 'submodulo_id' => 34, 'name' => 'dashboards2_show', 'description' => 'Visualizar Registro - Dashboards 2']);
        Permissao::create(['id' => 165, 'submodulo_id' => 34, 'name' => 'dashboards2_edit', 'description' => 'Editar Registro - Dashboards 2']);
        Permissao::create(['id' => 166, 'submodulo_id' => 34, 'name' => 'dashboards2_destroy', 'description' => 'Deletar Registro - Dashboards 2']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 162]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 163]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 164]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 165]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 166]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Submódulo Dashboards3'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Submódulo
        Submodulo::create(['id' => '35', 'modulo_id' => '1', 'name' => 'Dashboards 3', 'menu_text' => 'Dashboards 3', 'menu_url' => 'dashboards3', 'menu_route' => 'dashboards3', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'dashboards3', 'prefix_route' => 'dashboards3', 'mobile' => 0, 'menu_text_mobile' => 'Dashboard 3', 'viewing_order' => 30]);

        //Permissões
        Permissao::create(['id' => 167, 'submodulo_id' => 35, 'name' => 'dashboards3_list', 'description' => 'Visualizar Registro - Dashboards 3']);
        Permissao::create(['id' => 168, 'submodulo_id' => 35, 'name' => 'dashboards3_create', 'description' => 'Criar Registro - Dashboards 3']);
        Permissao::create(['id' => 169, 'submodulo_id' => 35, 'name' => 'dashboards3_show', 'description' => 'Visualizar Registro - Dashboards 3']);
        Permissao::create(['id' => 170, 'submodulo_id' => 35, 'name' => 'dashboards3_edit', 'description' => 'Editar Registro - Dashboards 3']);
        Permissao::create(['id' => 171, 'submodulo_id' => 35, 'name' => 'dashboards3_destroy', 'description' => 'Deletar Registro - Dashboards 3']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 167]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 168]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 169]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 170]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 171]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::create(['id' => 1, 'name' => 'Usuários Grupos', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 80]);
        Grafico::create(['id' => 2, 'name' => 'Usuários Situações', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 90]);
        Grafico::create(['id' => 3, 'name' => 'Funcionários Contratações', 'dashboard' => 1, 'tipo' => 2, 'ordem_visualizacao' => 10]);
        Grafico::create(['id' => 4, 'name' => 'Funcionários Funções', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 20]);
        Grafico::create(['id' => 5, 'name' => 'Funcionários Gêneros', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 30]);
        Grafico::create(['id' => 6, 'name' => 'Clientes Status', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 40]);
        Grafico::create(['id' => 7, 'name' => 'Clientes Tipos', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 50]);
        Grafico::create(['id' => 8, 'name' => 'Transações Operações', 'dashboard' => 1, 'tipo' => 2, 'ordem_visualizacao' => 60]);
        Grafico::create(['id' => 9, 'name' => 'Transações Submódulos', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 70]);
        Grafico::create(['id' => 10, 'name' => 'Operações', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 5]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupos Gráficos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 1]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 2]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 3]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 4]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 5]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 6]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 7]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 8]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 9]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 10]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatório''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Relatorio::create(['id' => 9, 'name' => 'Ficha Funcionário', 'descricao' => '', 'ordem_visualizacao' => 9]);

        //grupo_id=1
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 9]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // // Documento Fontes'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // DocumentoFonte::create(['id' => 6, 'name' => 'DOCUMENTOS FINANCEIROS', 'ordem' => 60]);
        // //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // // Documentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Documento::create(['id' => 65, 'name' => 'Folha de Ponto', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 6, 'ordem' => 10]);
        // Documento::create(['id' => 66, 'name' => 'Contracheque', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 6, 'ordem' => 20]);
        // Documento::create(['id' => 67, 'name' => 'Vale Refeição', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 6, 'ordem' => 30]);
        // Documento::create(['id' => 68, 'name' => 'Vale Transporte', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 6, 'ordem' => 40]);
        // //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
