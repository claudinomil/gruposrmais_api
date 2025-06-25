<?php

namespace Database\Seeders;

use App\Models\Agrupamento;
use App\Models\GrupoRelatorio;
use App\Models\Relatorio;
use App\Models\VisitaTecnicaPergunta;
use App\Models\VisitaTecnicaStatus;
use App\Models\VisitaTecnicaTipo;
use Illuminate\Database\Seeder;

class ZZZ_20250615_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //agrupamento_id=2 : Diversos
        Relatorio::create(['id' => 7, 'agrupamento_id' => 2, 'name' => 'Cartão Emergencial', 'descricao' => '', 'ordem_visualizacao' => 2]);

        //grupo_id=1
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 7]);
    }
}
