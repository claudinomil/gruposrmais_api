<?php

namespace Database\Seeders;

use App\Models\Grafico;
use Illuminate\Database\Seeder;

class ZZZ_20260507_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Gráficos - Criar''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::create(['id' => 14, 'sistema' => 12, 'grafico_grupo_id' => 3, 'name' => 'Distribuição de Lojas por Nível', 'dashboard' => 1, 'tipo' => 2, 'ordem_visualizacao' => 15]);
        Grafico::create(['id' => 15, 'sistema' => 12, 'grafico_grupo_id' => 3, 'name' => 'Documentos Exigidos por Tipo', 'dashboard' => 1, 'tipo' => 3, 'ordem_visualizacao' => 20]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráficos - Alterar''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grafico::where('id', 11)->update(['name' => 'Ocupação das Lojas']);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
