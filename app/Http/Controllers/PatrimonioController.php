<?php

namespace App\Http\Controllers;

use App\Models\MaterialEntradaItem;
use App\Models\MaterialMovimentacao;

class PatrimonioController extends Controller
{
    public function informacao($material_numero_patrimonio)
    {
        $dados = array();

        $dados['material'] = MaterialEntradaItem
            ::join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
            ->join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
            ->join('material_situacoes', 'material_situacoes.id', 'materiais_entradas_itens.material_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'materiais_entradas_itens.estoque_local_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'materiais.name as nome',
                'materiais.descricao',
                'materiais.fotografia',
                'materiais.ca',

                'material_categorias.name as categoria',

                'materiais_entradas_itens.material_numero_patrimonio as numero_patrimonio',

                'estoques_locais.name as local',
                'estoques_locais.estoque_id',

                'material_situacoes.name as situacao',

                'empresas.name as local_empresa',
                'clientes.name as local_cliente'
            )
            ->where('materiais_entradas_itens.material_numero_patrimonio', $material_numero_patrimonio)->first();

        // $dados['movimentacoes'] = MaterialMovimentacao
        //     ::join('materiais_movimentacoes_itens', 'materiais_movimentacoes_itens.material_movimentacao_id', 'materiais_movimentacoes.id')
        //     ->join('materiais_entradas_itens', 'materiais_entradas_itens.id', 'materiais_movimentacoes_itens.material_entrada_item_id')
        //     ->join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
        //     ->select('materiais_movimentacoes.*')
        //     ->where('materiais_entradas_itens.material_numero_patrimonio', $material_numero_patrimonio)
        //     ->orderby('materiais_movimentacoes.data_movimentacao')
        //     ->orderby('materiais_movimentacoes.hora_movimentacao')
        //     ->get();


        $dados['movimentacoes'] = MaterialMovimentacao
            ::join('estoques_locais as origens_estoques_locais', 'origens_estoques_locais.id', 'materiais_movimentacoes.origem_estoque_local_id')
            ->join('estoques as origens_estoques', 'origens_estoques.id', 'origens_estoques_locais.estoque_id')
            ->leftjoin('empresas as origens_empresas', 'origens_empresas.id', 'origens_estoques_locais.empresa_id')
            ->leftjoin('clientes as origens_clientes', 'origens_clientes.id', 'origens_estoques_locais.cliente_id')

            ->join('estoques_locais as destinos_estoques_locais', 'destinos_estoques_locais.id', 'materiais_movimentacoes.destino_estoque_local_id')
            ->join('estoques as destinos_estoques', 'destinos_estoques.id', 'destinos_estoques_locais.estoque_id')
            ->leftjoin('empresas as destinos_empresas', 'destinos_empresas.id', 'destinos_estoques_locais.empresa_id')
            ->leftjoin('clientes as destinos_clientes', 'destinos_clientes.id', 'destinos_estoques_locais.cliente_id')

            ->select(
                'materiais_movimentacoes.*',

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
            )->orderby('materiais_movimentacoes.data_movimentacao')
            ->orderby('materiais_movimentacoes.hora_movimentacao')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }
}
