<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdutoSituacao;

class ZZZ_20251216_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Produto Situações'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        ProdutoSituacao::create(['id' => 1, 'name' => 'ATIVO', 'descricao' => 'Patrimônio ativo e liberado para movimentações.', 'permite_movimentacao' => 1]);
        ProdutoSituacao::create(['id' => 2, 'name' => 'EM USO', 'descricao' => 'Produto atualmente em uso por um setor, cliente ou colaborador.', 'permite_movimentacao' => 1]);
        ProdutoSituacao::create(['id' => 3, 'name' => 'EM MANUTENÇÃO', 'descricao' => 'Produto enviado para manutenção preventiva ou corretiva.', 'permite_movimentacao' => 0]);
        ProdutoSituacao::create(['id' => 4, 'name' => 'EM TRÂNSITO', 'descricao' => 'Produto em processo de transferência entre locais.', 'permite_movimentacao' => 0]);
        ProdutoSituacao::create(['id' => 5, 'name' => 'EMPRÉSTIMO', 'descricao' => 'Produto emprestado temporariamente para outro setor ou unidade.', 'permite_movimentacao' => 1]);
        ProdutoSituacao::create(['id' => 6, 'name' => 'RESERVADO', 'descricao' => 'Produto reservado para movimentação futura, ainda não liberado.', 'permite_movimentacao' => 0]);
        ProdutoSituacao::create(['id' => 7, 'name' => 'INATIVO', 'descricao' => 'Produto fora de uso, aguardando destinação (ex.: conserto, baixa, descarte).', 'permite_movimentacao' => 0]);
        ProdutoSituacao::create(['id' => 8, 'name' => 'BAIXADO', 'descricao' => 'Produto baixado do patrimônio por descarte, doação ou perda.', 'permite_movimentacao' => 0]);
        ProdutoSituacao::create(['id' => 9, 'name' => 'PERDIDO / EXTRAVIADO', 'descricao' => 'Produto não localizado fisicamente ou extraviado.', 'permite_movimentacao' => 0]);
        ProdutoSituacao::create(['id' => 10, 'name' => 'EM AQUISIÇÃO', 'descricao' => 'Produto em processo de compra ou aguardando entrada no estoque patrimonial.', 'permite_movimentacao' => 0]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
