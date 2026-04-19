<?php

namespace Database\Seeders;

use App\Models\Grafico;
use App\Models\GraficoGrupo;
use App\Models\GrupoGrafico;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Permissao;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Relatorio;
use Illuminate\Database\Seeder;

class ZZZ_20260414_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
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
            } else if ($submodulo['id'] == 17) { // Dashboards
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'view-dashboard']);
            } else if ($submodulo['id'] == 50) { // Vistorias Sistemas
                $submodulo->update(['mobile' => 1, 'mobile_icon' => 'wall-fire']);
            } else {
                $submodulo->update(['mobile' => 0, 'mobile_icon' => 'help']);
            }
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráfico Grupos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        GraficoGrupo::create(['name' => 'Sistema', 'ordem_visualizacao' => 10]);
        GraficoGrupo::create(['name' => 'Operações', 'ordem_visualizacao' => 20]);
        GraficoGrupo::create(['name' => 'Clientes', 'ordem_visualizacao' => 30]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos - Alterar''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::where('id', 1)->update(['grafico_grupo_id' => 1, 'sistema' => '1']);
        Grafico::where('id', 2)->update(['grafico_grupo_id' => 1, 'sistema' => '1']);
        Grafico::where('id', 3)->update(['grafico_grupo_id' => 1, 'sistema' => '12']);
        Grafico::where('id', 4)->update(['grafico_grupo_id' => 1, 'sistema' => '12']);
        Grafico::where('id', 5)->update(['grafico_grupo_id' => 1, 'sistema' => '12']);
        Grafico::where('id', 6)->update(['grafico_grupo_id' => 1, 'sistema' => '12']);
        Grafico::where('id', 7)->update(['grafico_grupo_id' => 1, 'sistema' => '12']);
        Grafico::where('id', 8)->update(['grafico_grupo_id' => 1, 'sistema' => '1']);
        Grafico::where('id', 9)->update(['grafico_grupo_id' => 1, 'sistema' => '1']);
        Grafico::where('id', 10)->update(['grafico_grupo_id' => 2, 'sistema' => '12']);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupos Gráficos - Deletar'''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoGrafico::where('grafico_id', 11)->delete();
        GrupoGrafico::where('grafico_id', 12)->delete();
        GrupoGrafico::where('grafico_id', 13)->delete();
        GrupoGrafico::where('grafico_id', 14)->delete();
        GrupoGrafico::where('grafico_id', 15)->delete();
        GrupoGrafico::where('grafico_id', 16)->delete();
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos - Deletar''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::where('id', 11)->delete();
        Grafico::where('id', 12)->delete();
        Grafico::where('id', 13)->delete();
        Grafico::where('id', 14)->delete();
        Grafico::where('id', 15)->delete();
        Grafico::where('id', 16)->delete();
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatórios - Alterar''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Relatorio::where('id', 6)->update(['sistema' => '12']);
        Relatorio::where('id', 8)->update(['sistema' => '12']);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupo Relatórios - Deletar''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoRelatorio::where('relatorio_id', 11)->delete();
        GrupoRelatorio::where('relatorio_id', 12)->delete();
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatórios - Deletar''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Relatorio::where('id', 11)->delete();
        Relatorio::where('id', 12)->delete();
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
