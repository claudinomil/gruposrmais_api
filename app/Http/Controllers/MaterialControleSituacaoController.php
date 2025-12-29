<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialControleSituacaoUpdateRequest;
use App\Models\EstoqueLocal;
use Illuminate\Http\Request;
use App\Models\MaterialEntradaItem;
use App\Models\MaterialSituacao;
use App\Facades\SuporteFacade;
use App\Models\MaterialControleSituacaoItem;
use App\Models\MaterialMovimentacao;
use App\Models\MaterialMovimentacaoItem;

class MaterialControleSituacaoController extends Controller
{
    public function index()
    {
        $registros = MaterialEntradaItem
            ::join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
            ->join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
            ->join('material_situacoes', 'material_situacoes.id', 'materiais_entradas_itens.material_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'materiais_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'materiais.name as material_nome',
                'materiais.descricao as material_descricao',
                'materiais.fotografia',
                'materiais.ca',

                'material_categorias.name as material_categoria',

                'materiais_entradas_itens.id',
                'materiais_entradas_itens.material_numero_patrimonio as numero_patrimonio',

                'estoques.id as material_estoque_id',
                'estoques.name as material_estoque_nome',

                'estoques_locais.name as material_local',
                'estoques_locais.estoque_id',

                'material_situacoes.id as material_situacao_id',
                'material_situacoes.name as material_situacao',

                'empresas.name as material_local_empresa',
                'clientes.name as material_local_cliente'
            )
            ->whereNotIn('material_situacoes.id', [10]) // NÃO COLOCAR O PATRIMÔNIO EM AQUISIÇÃO
            ->orderby('materiais_entradas_itens.material_numero_patrimonio')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = MaterialEntradaItem
                ::join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
                ->join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
                ->join('material_situacoes', 'material_situacoes.id', 'materiais_entradas_itens.material_situacao_id')
                ->join('estoques_locais', 'estoques_locais.id', 'materiais_entradas_itens.estoque_local_id')
                ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
                ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
                ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
                ->select(
                    'materiais_entradas_itens.id',
                    'materiais_entradas_itens.id as material_entrada_item_id',
                    'materiais_entradas_itens.estoque_local_id',
                    'materiais_entradas_itens.material_situacao_id',
                    'materiais.fotografia as material_fotografia',
                    'materiais_entradas_itens.material_numero_patrimonio',
                    'materiais.name as material_nome',
                    'material_categorias.name as material_categoria',
                    'estoques.id as material_estoque_id',
                    'estoques.name as material_estoque_nome',
                    'estoques_locais.name as material_local',
                    'empresas.name as material_local_empresa',
                    'clientes.name as material_local_cliente',
                    'material_situacoes.name as material_situacao'
                )
                ->where('materiais_entradas_itens.id', $id)
                ->orderby('materiais.name')
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
            $registros['material_situacoes'] = MaterialSituacao::orderby('name')->get();

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

    public function update(MaterialControleSituacaoUpdateRequest $request, $id)
    {
        try {
            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('materiais_movimentacoes');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('materiais_entradas');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('materiais_entradas_itens');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Processo - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Processo - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Criar registro na tabela materiais_controle_situacoes_itens
            $request['data_alteracao'] = date('d/m/Y');
            $request['hora_alteracao'] = date('H:i:s');
            $mcsi = MaterialControleSituacaoItem::create($request->all());

            // Buscar registro na tabela materiais_entradas_itens
            $data = array();
            $data['material_situacao_id'] = $request['atual_material_situacao_id'];

            if ($request['atual_estoque_local_id'] != '') {
                $data['estoque_local_id'] = $request['atual_estoque_local_id'];
            }

            $registro = MaterialEntradaItem::find($request['material_entrada_item_id']);

            if (!$registro) {
                // Deletar registro na tabela materiais_controle_situacoes_itens
                MaterialControleSituacaoItem::where('id', $mcsi['id'])->delete();

                // Retorno
                $retorno = 1;
            } else {
                // Alterando registro na tabela materiais_entradas_itens
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
                    $regMov = MaterialMovimentacao::create($dados);

                    // Incluir na tabela materiais_movimentacoes_itens
                    MaterialMovimentacaoItem::create(['material_movimentacao_id' => $regMov['id'], 'material_entrada_item_id' => $request['material_entrada_item_id']]);
                }

                // Retorno
                $retorno = 2;
            }
            // Processo - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Processo - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('materiais_movimentacoes');

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('materiais_entradas');

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('materiais_entradas_itens');

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
        $registros = MaterialEntradaItem
            ::join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
            ->join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
            ->join('material_situacoes', 'material_situacoes.id', 'materiais_entradas_itens.material_situacao_id')
            ->join('estoques_locais', 'estoques_locais.id', 'materiais_entradas_itens.estoque_local_id')
            ->join('estoques', 'estoques.id', 'estoques_locais.estoque_id')
            ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
            ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
            ->select(
                'materiais.name as material_nome',
                'materiais.descricao as material_descricao',
                'materiais.fotografia',
                'materiais.ca',

                'material_categorias.name as material_categoria',

                'materiais_entradas_itens.id',
                'materiais_entradas_itens.material_numero_patrimonio as numero_patrimonio',

                'estoques.id as material_estoque_id',
                'estoques.name as material_estoque_nome',

                'estoques_locais.name as material_local',
                'estoques_locais.estoque_id',

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
            })
            ->orderby('materiais.name')
            ->get();

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }
}
