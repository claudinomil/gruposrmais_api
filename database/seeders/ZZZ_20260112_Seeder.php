<?php

namespace Database\Seeders;

use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20260112_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Alterar localização do submodulo proposta'''''''''''''''''''''''''''''''''''''''''''''''
        Submodulo::where('id', 21)->update(['modulo_id' => 7, 'viewing_order' => 5]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
