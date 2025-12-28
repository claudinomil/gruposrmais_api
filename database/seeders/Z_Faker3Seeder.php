<?php

namespace Database\Seeders;

use App\Models\MaterialEntrada;
use App\Models\MaterialEntradaItem;
use App\Models\PontoInteresse;
use App\Models\PontoInteresseEspecialidade;
use Illuminate\Database\Seeder;

class Z_Faker3Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Dar entradas em materiais (Entradas / Movimentações)'''''''''''''''''''''''''''''''''''''''''''''''''''
        $numero_patrimonio = 1234;

        for($i=1; $i<=5; $i++) {
            MaterialEntrada::create([
                'id' => $i,
                'empresa_id' => 1,
                'fornecedor_id' => $i,
                'nf_numero' => '0000'.$i,
                'nf_serie' => '00'.$i,
                'nf_chave_acesso' => '00000 00000 00000 00000 0000',
                'data_emissao' => date('d/m/Y'),
                'valor_total' => 320.00,
                'valor_desconto' => 0.00,
                'estoque_local_id' => 1
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 1,
                'material_categoria_name' => 'Equipamentos de Proteção Individual',
                'material_name' => 'Capacete',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 2,
                'material_categoria_name' => 'Equipamentos de Proteção Individual',
                'material_name' => 'Luvas',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 3,
                'material_categoria_name' => 'Equipamentos de Proteção Individual',
                'material_name' => 'Coturno',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 4,
                'material_categoria_name' => 'Equipamentos de Proteção Individual',
                'material_name' => 'Máscara',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 5,
                'material_categoria_name' => 'Equipamentos de Proteção Individual',
                'material_name' => 'Óculos',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 6,
                'material_categoria_name' => 'Equipamentos de Proteção Individual',
                'material_name' => 'Extintor (PQS)',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 7,
                'material_categoria_name' => 'Equipamentos de Combate a Incêndio',
                'material_name' => 'Extintor (CO₂)',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);

            $numero_patrimonio++;
            MaterialEntradaItem::create([
                'material_entrada_id' => $i,
                'material_id' => 8,
                'material_categoria_name' => 'Equipamentos de Combate a Incêndio',
                'material_name' => 'Extintor (água)',
                'material_numero_patrimonio' => '0'.$numero_patrimonio,
                'material_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'material_situacao_id' => 10
            ]);
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
