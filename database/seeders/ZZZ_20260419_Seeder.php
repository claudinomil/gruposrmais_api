<?php

namespace Database\Seeders;

use App\Models\Grafico;
use App\Models\GraficoGrupo;
use App\Models\GrupoGrafico;
use Illuminate\Database\Seeder;

class ZZZ_20260419_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Gráfico Grupos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        GraficoGrupo::where('id', 3)->update(['name' => 'Clientes x Edificações']);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos - Criar''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::create(['id' => 11, 'sistema' => 12, 'grafico_grupo_id' => 3, 'name' => 'LUCs Ocupados', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 10]);
        Grafico::create(['id' => 12, 'sistema' => 12, 'grafico_grupo_id' => 3, 'name' => 'Documentos Exigidos', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 20]);
        Grafico::create(['id' => 13, 'sistema' => 12, 'grafico_grupo_id' => 3, 'name' => 'Status Documental Geral', 'dashboard' => 1, 'tipo' => 1, 'ordem_visualizacao' => 30]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupos Gráficos - Criar'''''''''''''''''''''''''''''''''''''''''''''''''''
        // Administrador
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 11]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 12]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 13]);

        // Domínio Clientes
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 11]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 12]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 13]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
