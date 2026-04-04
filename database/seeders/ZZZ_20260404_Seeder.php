<?php

namespace Database\Seeders;

use App\Models\EquipamentoPreventivo;
use App\Models\SistemaPreventivo;
use App\Models\SistemaPreventivoEquipamento;
use Illuminate\Database\Seeder;

class ZZZ_20260404_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Criar Sistema Preventivo para cada Equipamento Preventivo''''''''''''''''''''''''''''''
        $equipamentos = EquipamentoPreventivo::all();

        foreach($equipamentos as $equipamento) {
            // Medida de Segurança
            $medida_seguranca_id = 0;

            // ALARME DE INCÊNDIO
            if ($equipamento['id'] == 18 or $equipamento['id'] == 35) {$medida_seguranca_id = 2;}

            // APARELHO EXTINTOR
            if ($equipamento['id'] == 3) {$medida_seguranca_id = 3;}

            // HIDRANTE E MANGOTINHO
            if ($equipamento['id'] == 32) {$medida_seguranca_id = 15;}

            if ($medida_seguranca_id != 0) {
                $sistema_preventivo = SistemaPreventivo::create(['medida_seguranca_id' => $medida_seguranca_id, 'name' => $equipamento['name']]);

                SistemaPreventivoEquipamento::create([
                    'sistema_preventivo_id' => $sistema_preventivo['id'],
                    'equipamento_preventivo_id' => $equipamento['id'],
                    'equipamento_preventivo_item' => 1,
                    'equipamento_preventivo_nome' => $equipamento['name'],
                    'equipamento_preventivo_quantidade' => 1
                ]);
            }
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
