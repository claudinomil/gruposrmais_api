<?php

namespace App\Http\Controllers;

use App\Models\ProdutoControleSituacaoItem;
use App\Models\ProdutoEntrada;
use App\Models\ProdutoEntradaItem;
use App\Models\ProdutoMovimentacao;

class PatrimonioController extends Controller
{
    public function informacao($produto_numero_patrimonio)
    {
        $dados = array();

        $dados['produto'] = ProdutoEntradaItem
            ::join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as nome',
                'produtos.descricao',
                'produtos.fotografia',
                'produtos.ca',

                'produto_categorias.name as categoria',

                'produtos_entradas_itens.produto_numero_patrimonio as numero_patrimonio',

                'estoques_locais.name as local',
                'estoques_locais.estoque_id',

                'produto_situacoes.name as situacao',

                'empresas.name as local_empresa',
                'clientes.name as local_cliente'
            )
            ->where('produtos_entradas_itens.produto_numero_patrimonio', $produto_numero_patrimonio)
            ->first();

        $dados['movimentacoes'] = ProdutoMovimentacao
            ::join('produtos_movimentacoes_itens', 'produtos_movimentacoes_itens.produto_movimentacao_id', 'produtos_movimentacoes.id')
            ->join('produtos_entradas_itens', 'produtos_entradas_itens.id', 'produtos_movimentacoes_itens.produto_entrada_item_id')
            ->join('estoques_locais as origens_estoques_locais', 'origens_estoques_locais.id', 'produtos_movimentacoes.origem_estoque_local_id')
            ->join('estoques as origens_estoques', 'origens_estoques.id', 'origens_estoques_locais.estoque_id')
            ->leftjoin('empresas as origens_empresas', 'origens_empresas.id', 'origens_estoques_locais.empresa_id')
            ->leftjoin('clientes as origens_clientes', 'origens_clientes.id', 'origens_estoques_locais.cliente_id')

            ->join('estoques_locais as destinos_estoques_locais', 'destinos_estoques_locais.id', 'produtos_movimentacoes.destino_estoque_local_id')
            ->join('estoques as destinos_estoques', 'destinos_estoques.id', 'destinos_estoques_locais.estoque_id')
            ->leftjoin('empresas as destinos_empresas', 'destinos_empresas.id', 'destinos_estoques_locais.empresa_id')
            ->leftjoin('clientes as destinos_clientes', 'destinos_clientes.id', 'destinos_estoques_locais.cliente_id')

            ->select(
                'produtos_movimentacoes.*',

                'origens_estoques.id as origemEstoqueId',
                'origens_estoques_locais.name as origemEstoqueLocalName',
                'origens_estoques.name as origemEstoqueName',
                'origens_empresas.name as origemEmpresaName',
                'origens_clientes.name as origemClienteName',

                'destinos_estoques.id as destinoEstoqueId',
                'destinos_estoques_locais.name as destinoEstoqueLocalName',
                'destinos_estoques.name as destinoEstoqueName',
                'destinos_empresas.name as destinoEmpresaName',
                'destinos_clientes.name as destinoClienteName'
            )->orderby('produtos_movimentacoes.data_movimentacao')
            ->orderby('produtos_movimentacoes.hora_movimentacao')
            ->where('produtos_entradas_itens.produto_numero_patrimonio', $produto_numero_patrimonio)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function listagem_geral()
    {
        $dados = array();

        $dados['produtos'] = ProdutoEntrada
            ::join('produtos_entradas_itens', 'produtos_entradas_itens.produto_entrada_id', 'produtos_entradas.id')
            ->join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as nome',
                'produtos.descricao',
                'produtos.fotografia',
                'produtos.ca',

                'produto_categorias.name as categoria',

                'produtos_entradas.data_emissao as data_emissao',

                'produtos_entradas_itens.produto_numero_patrimonio as numero_patrimonio',
                'produtos_entradas_itens.produto_valor_unitario as valor_unitario',

                'estoques.name as estoque',

                'estoques_locais.name as local',
                'estoques_locais.estoque_id',

                'produto_situacoes.id as situacao_id',
                'produto_situacoes.name as situacao',

                'empresas.name as local_empresa',
                'clientes.name as local_cliente'
            )
            ->orderby('produtos.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function patrimonio_situacoes($produto_entrada_item_id)
    {
        $dados = array();

        $dados['patrimonio_situacoes'] = ProdutoControleSituacaoItem
            ::join('produtos_entradas_itens', 'produtos_entradas_itens.id', 'produtos_controle_situacoes_itens.produto_entrada_item_id')
            ->join('produto_situacoes as anterior_produto_situacoes', 'anterior_produto_situacoes.id', 'produtos_controle_situacoes_itens.anterior_produto_situacao_id')
            ->join('produto_situacoes as atual_produto_situacoes', 'atual_produto_situacoes.id', 'produtos_controle_situacoes_itens.atual_produto_situacao_id')
            ->join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->select(
                'produtos_controle_situacoes_itens.*',
                'anterior_produto_situacoes.name as anteriorProdutoSituacaoName',
                'atual_produto_situacoes.name as atualProdutoSituacaoName',
                'produtos.name as produtoName',
                'produto_categorias.name as produtoCategoriaName'
            )
            ->where('produtos_entradas_itens.id', $produto_entrada_item_id)
            ->orderby('produtos_controle_situacoes_itens.data_alteracao')
            ->orderby('produtos_controle_situacoes_itens.hora_alteracao')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }
}
