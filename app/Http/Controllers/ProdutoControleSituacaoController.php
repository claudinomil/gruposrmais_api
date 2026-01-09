<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoControleSituacaoUpdateRequest;
use App\Models\EstoqueLocal;
use Illuminate\Http\Request;
use App\Models\ProdutoEntradaItem;
use App\Models\ProdutoSituacao;
use App\Facades\SuporteFacade;
use App\Models\ProdutoControleSituacaoItem;
use App\Models\ProdutoMovimentacao;
use App\Models\ProdutoMovimentacaoItem;

class ProdutoControleSituacaoController extends Controller
{
    public function index()
    {
        $registros = ProdutoEntradaItem
            ::join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as produto_nome',
                'produtos.descricao as produto_descricao',
                'produtos.fotografia',
                'produtos.ca',

                'produto_categorias.name as produto_categoria',

                'produtos_entradas_itens.id',
                'produtos_entradas_itens.produto_numero_patrimonio as numero_patrimonio',

                'estoques.id as produto_estoque_id',
                'estoques.name as produto_estoque_nome',

                'estoques_locais.name as produto_local',
                'estoques_locais.estoque_id',

                'produto_situacoes.id as produto_situacao_id',
                'produto_situacoes.name as produto_situacao',

                'empresas.name as produto_local_empresa',
                'clientes.name as produto_local_cliente'
            )
            ->whereNotIn('produto_situacoes.id', [10]) // NÃO COLOCAR O PATRIMÔNIO EM AQUISIÇÃO
            ->orderby('produtos_entradas_itens.produto_numero_patrimonio')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = ProdutoEntradaItem
                ::join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
                ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
                ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
                ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
                ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
                ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
                ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
                ->select(
                    'produtos_entradas_itens.id',
                    'produtos_entradas_itens.id as produto_entrada_item_id',
                    'produtos_entradas_itens.estoque_local_id',
                    'produtos_entradas_itens.produto_situacao_id',
                    'produtos.fotografia as produto_fotografia',
                    'produtos_entradas_itens.produto_numero_patrimonio',
                    'produtos.name as produto_nome',
                    'produto_categorias.name as produto_categoria',
                    'estoques.id as produto_estoque_id',
                    'estoques.name as produto_estoque_nome',
                    'estoques_locais.name as produto_local',
                    'empresas.name as produto_local_empresa',
                    'clientes.name as produto_local_cliente',
                    'produto_situacoes.name as produto_situacao'
                )
                ->where('produtos_entradas_itens.id', $id)
                ->orderby('produtos.name')
                ->first();

                if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
            } else {
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function auxiliary()
    {
        try {
            $registros = array();

            // Situações
            $registros['produto_situacoes'] = ProdutoSituacao::orderby('name')->get();

            // Estoques Locais
            $registros['estoques_locais'] = EstoqueLocal
            ::Join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftJoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftJoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(['estoques_locais.*', 'estoques.name as estoqueName', 'empresas.name as empresaName', 'clientes.name as clienteName'])
            ->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(ProdutoControleSituacaoUpdateRequest $request, $id)
    {
        try {
            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('produtos_movimentacoes');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('produtos_entradas');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('produtos_entradas_itens');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Processo - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Processo - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Criar registro na tabela produtos_controle_situacoes_itens
            $request['data_alteracao'] = date('d/m/Y');
            $request['hora_alteracao'] = date('H:i:s');
            $mcsi = ProdutoControleSituacaoItem::create($request->all());

            // Buscar registro na tabela produtos_entradas_itens
            $data = array();
            $data['produto_situacao_id'] = $request['atual_produto_situacao_id'];

            if ($request['atual_estoque_local_id'] != '') {
                $data['estoque_local_id'] = $request['atual_estoque_local_id'];
            }

            $registro = ProdutoEntradaItem::find($request['produto_entrada_item_id']);

            if (!$registro) {
                // Deletar registro na tabela produtos_controle_situacoes_itens
                ProdutoControleSituacaoItem::where('id', $mcsi['id'])->delete();

                // Retorno
                $retorno = 1;
            } else {
                // Alterando registro na tabela produtos_entradas_itens
                $registro->update($data);

                // Criar Movimentação
                if ($request['atual_estoque_local_id'] != '') {
                    // Dados
                    $dados = array();
                    $dados['origem_estoque_local_id'] = $request['anterior_estoque_local_id'];
                    $dados['destino_estoque_local_id'] = $request['atual_estoque_local_id'];
                    $dados['data_movimentacao'] = date('d/m/Y');
                    $dados['hora_movimentacao'] = date('H:i:s');
                    $dados['tipo'] = 'transferencia';
                    $dados['observacoes'] = 'Movimentação realizada pelo Submódulo Controle Situações';

                    // Incluindo registro
                    $regMov = ProdutoMovimentacao::create($dados);

                    // Incluir na tabela produtos_movimentacoes_itens
                    ProdutoMovimentacaoItem::create(['produto_movimentacao_id' => $regMov['id'], 'produto_entrada_item_id' => $request['produto_entrada_item_id']]);
                }

                // Retorno
                $retorno = 2;
            }
            // Processo - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Processo - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('produtos_movimentacoes');

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('produtos_entradas');

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('produtos_entradas_itens');

            // Retorno
            if ($retorno == 1) {return $this->sendResponse('Registro não encontrado.', 4040, null, null);}
            if ($retorno == 2) {return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, null);}

            return $this->sendResponse('Erro interno.', 5000, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = ProdutoEntradaItem
            ::join('produtos', 'produtos.id', 'produtos_entradas_itens.produto_id')
            ->join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
            ->join('produto_situacoes', 'produto_situacoes.id', 'produtos_entradas_itens.produto_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'produtos_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'produtos.name as produto_nome',
                'produtos.descricao as produto_descricao',
                'produtos.fotografia',
                'produtos.ca',

                'produto_categorias.name as produto_categoria',

                'produtos_entradas_itens.id',
                'produtos_entradas_itens.produto_numero_patrimonio as numero_patrimonio',

                'estoques.id as produto_estoque_id',
                'estoques.name as produto_estoque_nome',

                'estoques_locais.name as produto_local',
                'estoques_locais.estoque_id',

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
            })
            ->orderby('produtos.name')
            ->get();

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }
}
