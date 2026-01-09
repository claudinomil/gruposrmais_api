<?php

namespace App\Http\Controllers;

use App\Models\ProdutoEntrada;
use Illuminate\Http\Request;

class ProdutoListagemGeralController extends Controller
{
    public function index(Request $request)
    {
        $empresa_id = $request->header('X-Empresa-Id');

        $registros = ProdutoEntrada
            ::join('produtos_entradas_itens', 'produtos_entradas_itens.produto_entrada_id', 'produtos_entradas.id')
            ->join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as produto_nome',
                'produtos.descricao as produto_descricao',
                'produtos.fotografia as produto_fotografia',
                'produtos.ca as produto_ca',

                'produto_categorias.name as produto_categoria',

                'produtos_entradas.data_emissao as produto_data_aquisicao',

                'produtos_entradas_itens.id',
                'produtos_entradas_itens.produto_numero_patrimonio as produto_numero_patrimonio',
                'produtos_entradas_itens.produto_valor_unitario as produto_valor_unitario',

                'estoques.name as produto_estoque_nome',

                'estoques_locais.name as produto_local',
                'estoques_locais.estoque_id as produto_estoque_id',

                'produto_situacoes.id as produto_situacao_id',
                'produto_situacoes.name as produto_situacao',

                'empresas.name as produto_local_empresa',
                'clientes.name as produto_local_cliente'
            )
            //->where('produtos_entradas.empresa_id', $empresa_id)
            ->orderby('produtos_entradas_itens.produto_numero_patrimonio')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();

        //Registros
        $registros = ProdutoEntrada
            ::join('produtos_entradas_itens', 'produtos_entradas_itens.produto_entrada_id', 'produtos_entradas.id')
            ->join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as produto_nome',
                'produtos.descricao as produto_descricao',
                'produtos.fotografia as produto_fotografia',
                'produtos.ca as produto_ca',

                'produto_categorias.name as produto_categoria',

                'produtos_entradas.data_emissao as produto_data_aquisicao',

                'produtos_entradas_itens.id',
                'produtos_entradas_itens.produto_numero_patrimonio as produto_numero_patrimonio',
                'produtos_entradas_itens.produto_valor_unitario as produto_valor_unitario',

                'estoques.name as produto_estoque_nome',

                'estoques_locais.name as produto_local',
                'estoques_locais.estoque_id as produto_estoque_id',

                'produto_situacoes.id as produto_situacao_id',
                'produto_situacoes.name as produto_situacao',

                'empresas.name as produto_local_empresa',
                'clientes.name as produto_local_cliente'
            )
            ->where(function($query) use($filtros) {
                //Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for($i=1; $i<=$qtdFiltros; $i++) {
                    //Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo+1];
                    $operacao = $filtros[$indexCampo+2];
                    $dado = $filtros[$indexCampo+3];

                    //Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
                    }
                    if ($operacao == 2) {
                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
                    }
                    if ($operacao == 3) {
                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
                    }
                    if ($operacao == 4) {
                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
                    }
                    if ($operacao == 5) {
                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
                    }
                    if ($operacao == 6) {
                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
                    }
                    if ($operacao == 7) {
                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
                    }
                    if ($operacao == 8) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
                    }

                    //Atualizar indexCampo
                    $indexCampo = $indexCampo + 4;
                }
            }
            )->get();

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }
}
