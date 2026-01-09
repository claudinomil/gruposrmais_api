<?php

namespace Database\Seeders;

use App\Models\ProdutoEntrada;
use App\Models\ProdutoEntradaItem;
use App\Models\PontoInteresse;
use App\Models\PontoInteresseEspecialidade;
use Illuminate\Database\Seeder;

class Z_Faker3Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Dar entradas em produtos (Entradas / Movimentações)'''''''''''''''''''''''''''''''''''''''''''''''''''
        $numero_patrimonio = 1234;

        for($i=1; $i<=5; $i++) {
            ProdutoEntrada::create([
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

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 1,
                'produto_categoria_name' => 'Equipamentos de Proteção Individual',
                'produto_name' => 'Capacete',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 2,
                'produto_categoria_name' => 'Equipamentos de Proteção Individual',
                'produto_name' => 'Luvas',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 3,
                'produto_categoria_name' => 'Equipamentos de Proteção Individual',
                'produto_name' => 'Coturno',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 4,
                'produto_categoria_name' => 'Equipamentos de Proteção Individual',
                'produto_name' => 'Máscara',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 5,
                'produto_categoria_name' => 'Equipamentos de Proteção Individual',
                'produto_name' => 'Óculos',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 6,
                'produto_categoria_name' => 'Equipamentos de Proteção Individual',
                'produto_name' => 'Extintor (PQS)',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 7,
                'produto_categoria_name' => 'Equipamentos de Combate a Incêndio',
                'produto_name' => 'Extintor (CO₂)',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);

            //xxxyyywww
            $numero_patrimonio++;
            ProdutoEntradaItem::create([
                'produto_entrada_id' => $i,
                'produto_id' => 8,
                'produto_categoria_name' => 'Equipamentos de Combate a Incêndio',
                'produto_name' => 'Extintor (água)',
                'produto_numero_patrimonio' => '0'.$numero_patrimonio,
                'produto_valor_unitario' => 40,
                'estoque_local_id' => 1,
                'produto_situacao_id' => 10
            ]);
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
