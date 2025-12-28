<?php

namespace App\Http\Controllers;

use App\Models\MaterialEntrada;
use Illuminate\Http\Request;

class MaterialListagemGeralController extends Controller
{
    public function index(Request $request)
    {
        $empresa_id = $request->header('X-Empresa-Id');

        $registros = MaterialEntrada
            ::join('materiais_entradas_itens', 'materiais_entradas_itens.material_entrada_id', 'materiais_entradas.id')
            ->join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
            ->join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
            ->join('material_situacoes', 'material_situacoes.id', 'materiais_entradas_itens.material_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'materiais_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'materiais.name as material_nome',
                'materiais.descricao as material_descricao',
                'materiais.fotografia as material_fotografia',
                'materiais.ca as material_ca',

                'material_categorias.name as material_categoria',

                'materiais_entradas.data_emissao as material_data_aquisicao',

                'materiais_entradas_itens.id',
                'materiais_entradas_itens.material_numero_patrimonio as material_numero_patrimonio',
                'materiais_entradas_itens.material_valor_unitario as material_valor_unitario',

                'estoques.name as material_estoque_nome',

                'estoques_locais.name as material_local',
                'estoques_locais.estoque_id as material_estoque_id',

                'material_situacoes.id as material_situacao_id',
                'material_situacoes.name as material_situacao',

                'empresas.name as material_local_empresa',
                'clientes.name as material_local_cliente'
            )
            //->where('materiais_entradas.empresa_id', $empresa_id)
            ->orderby('materiais.name')
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
        $registros = MaterialEntrada
            ::join('materiais_entradas_itens', 'materiais_entradas_itens.material_entrada_id', 'materiais_entradas.id')
            ->join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
            ->join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
            ->join('material_situacoes', 'material_situacoes.id', 'materiais_entradas_itens.material_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'materiais_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'materiais.name as material_nome',
                'materiais.descricao as material_descricao',
                'materiais.fotografia as material_fotografia',
                'materiais.ca as material_ca',

                'material_categorias.name as material_categoria',

                'materiais_entradas.data_emissao as material_data_aquisicao',

                'materiais_entradas_itens.id',
                'materiais_entradas_itens.material_numero_patrimonio as material_numero_patrimonio',
                'materiais_entradas_itens.material_valor_unitario as material_valor_unitario',

                'estoques.name as material_estoque_nome',

                'estoques_locais.name as material_local',
                'estoques_locais.estoque_id as material_estoque_id',

                'material_situacoes.id as material_situacao_id',
                'material_situacoes.name as material_situacao',

                'empresas.name as material_local_empresa',
                'clientes.name as material_local_cliente'
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
