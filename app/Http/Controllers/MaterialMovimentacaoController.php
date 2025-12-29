<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\MaterialMovimentacaoStoreRequest;
use App\Models\EstoqueLocal;
use App\Models\MaterialEntradaItem;
use App\Models\MaterialMovimentacao;
use App\Models\MaterialMovimentacaoItem;
use Illuminate\Http\Request;

class MaterialMovimentacaoController extends Controller
{
    private $material_movimentacao;

    public function __construct(MaterialMovimentacao $material_movimentacao)
    {
        $this->material_movimentacao = $material_movimentacao;
    }

    public function index(Request $request)
    {
        $registros = $this->material_movimentacao
        ->join('estoques_locais as origens_estoques_locais', 'origens_estoques_locais.id', 'materiais_movimentacoes.origem_estoque_local_id')
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
        )
        ->orderby('materiais_movimentacoes.data_movimentacao', 'DESC')
        ->orderby('materiais_movimentacoes.hora_movimentacao', 'DESC')
        ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->material_movimentacao->find($id);

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

            // Estoques Locais
            $registros['estoques_locais'] = EstoqueLocal
                ::leftjoin('estoques', 'estoques.id', 'estoques_locais.estoque_id')
                ->leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
                ->leftjoin('clientes', 'clientes.id', 'estoques_locais.cliente_id')
                ->select('estoques_locais.*', 'estoques.name as estoqueName', 'empresas.name as empresaName', 'clientes.name as clienteName')
                ->orderby('estoques.name')
                ->orderby('empresas.name')
                ->orderby('clientes.name')
                ->orderby('estoques_locais.name')
                ->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(MaterialMovimentacaoStoreRequest $request)
    {
        try {
            // Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            $lock = SuporteFacade::bloquearTabelaRegistro('materiais_movimentacoes');

            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }

            // Data, Hora e Tipo de Movimentação
            $request['data_movimentacao'] = date('d/m/Y');
            $request['hora_movimentacao'] = date('H:i:s');
            $request['tipo'] = 'transferencia';

            // Incluindo registro
            $registro = $this->material_movimentacao->create($request->all());

            // Estoque Local de Destino
            $destino_estoque_local_id = $request['destino_estoque_local_id'];

            // Verificar Estoque Local Destino se é Empresa ou Cliente para lançar na variável $material_situacao_id
            $destino_estoque_local = EstoqueLocal::where('id', $destino_estoque_local_id)->first();
            $estoque_id = $destino_estoque_local->estoque_id;

            if ($estoque_id == 1) {
                $material_situacao_id = 1; // ATIVO - permite movimentação
            } else if ($estoque_id == 2) {
                $material_situacao_id = 2; // EM USO - permite movimentação
            } else {
                $material_situacao_id = 1; // ATIVO - permite movimentação
            }

            // Edições
            if (isset($request['materiais_entradas_itens'])) {
                $materiaisEntradasItensSelecionados = $request['materiais_entradas_itens'];

                // Varrer selecionados
                foreach ($materiaisEntradasItensSelecionados as $materialEntradaItemId) {
                    // Incluir na tabela materiais_movimentacoes_itens
                    MaterialMovimentacaoItem::create(['material_movimentacao_id' => $registro['id'], 'material_entrada_item_id' => $materialEntradaItemId]);

                    // Pegar registro
                    $materialEntradaItem = MaterialEntradaItem::find($materialEntradaItemId);

                    // Pegar dados para criar registro de Controle de Situações
                    $d_material_entrada_item_id = $materialEntradaItemId;
                    $d_anterior_material_situacao_id = $materialEntradaItem->material_situacao_id;
                    $d_atual_material_situacao_id = $material_situacao_id;
                    $d_anterior_estoque_local_id = $materialEntradaItem->estoque_local_id;
                    $d_atual_estoque_local_id = $destino_estoque_local_id;
                    $d_observacao = 'Registro criado ao Fazer Movimentação';
                    $d_data_alteracao = $request['data_movimentacao'];
                    $d_hora_alteracao = $request['hora_movimentacao'];

                    // Alterar tabela materiais_entradas_itens
                    $materialEntradaItem->update(['estoque_local_id' => $destino_estoque_local_id, 'material_situacao_id' => $material_situacao_id]);

                    // Criar registro na tabela materiais_controle_situacoes_itens
                    SuporteFacade::gravarRegistroControleSituacao(
                        $d_material_entrada_item_id,
                        $d_anterior_material_situacao_id,
                        $d_atual_material_situacao_id,
                        $d_anterior_estoque_local_id,
                        $d_atual_estoque_local_id,
                        $d_observacao,
                        $d_data_alteracao,
                        $d_hora_alteracao
                    );
                }
            }

            // Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
            SuporteFacade::desbloquearTabelaRegistro('materiais_movimentacoes');

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, 'null');
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
        $registros = $this->material_movimentacao
            ->select(['materiais_movimentacoes.*'])
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

    public function materiais_entradas_itens($operacao, $estoque_local_id, $material_movimentacao_id)
    {
        if ($operacao == 'create') {
            $registros = MaterialEntradaItem
                ::join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
                ->select('materiais_entradas_itens.*', 'materiais.fotografia as materialFotografia')
                ->where('materiais_entradas_itens.estoque_local_id', $estoque_local_id)
                ->whereIn('materiais_entradas_itens.material_situacao_id', [1, 2, 5]) // 1(ATIVO)  2(EM USO)  5(EMPRÉSTIMO)
                ->orderby('materiais.name')
                ->orderby('materiais_entradas_itens.material_numero_patrimonio')
                ->get();
        }

        if ($operacao == 'view') {
            $registros = MaterialMovimentacao
                ::join('materiais_movimentacoes_itens', 'materiais_movimentacoes_itens.material_movimentacao_id', 'materiais_movimentacoes.id')
                ->join('materiais_entradas_itens', 'materiais_entradas_itens.id', 'materiais_movimentacoes_itens.material_entrada_item_id')
                ->join('materiais', 'materiais.id', 'materiais_entradas_itens.material_id')
                ->select('materiais_entradas_itens.*', 'materiais.fotografia as materialFotografia')
                ->where('materiais_movimentacoes.id', $material_movimentacao_id)
                ->where('materiais_movimentacoes.origem_estoque_local_id', $estoque_local_id)
                ->whereIn('materiais_entradas_itens.material_situacao_id', [1, 2, 5]) // 1(ATIVO)  2(EM USO)  5(EMPRÉSTIMO)
                ->orderby('materiais.name')
                ->orderby('materiais_entradas_itens.material_numero_patrimonio')
                ->get();
        }

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }
}
