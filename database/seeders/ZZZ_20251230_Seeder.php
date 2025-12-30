<?php

namespace Database\Seeders;

use App\Models\GrupoRelatorio;
use App\Models\Relatorio;
use Illuminate\Database\Seeder;

class ZZZ_20251230_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Relatório''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Relatorio::create(['id' => 10, 'name' => 'Listagem Patrimônios', 'descricao' => '', 'ordem_visualizacao' => 10]);

        // grupo_id=1
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 10]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
