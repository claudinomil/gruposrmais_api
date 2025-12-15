<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialMovimentacaoStoreRequest;
use App\Http\Requests\MaterialMovimentacaoUpdateRequest;
use App\Models\EstoqueLocal;
use App\Models\MaterialMovimentacao;
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

            'origens_estoques_locais.name as origemEstoqueLocalName',
            'origens_estoques.name as origemEstoqueName',
            'origens_empresas.name as origemEmpresaName',
            'origens_clientes.name as origemClienteName',

            'destinos_estoques_locais.name as destinoEstoqueLocalName',
            'destinos_estoques.name as destinoEstoqueName',
            'destinos_empresas.name as destinoEmpresaName',
            'destinos_clientes.name as destinoClienteName'
        )->get();



//         $query = $this->material_movimentacao
//         ->join('estoques_locais as origens_estoques_locais', 'origens_estoques_locais.id', 'materiais_movimentacoes.origem_estoque_local_id')
//         ->join('estoques as origens_estoques', 'origens_estoques.id', 'origens_estoques_locais.estoque_id')
//         ->leftjoin('empresas as origens_empresas', 'origens_empresas.id', 'origens_estoques_locais.empresa_id')
//         ->leftjoin('clientes as origens_clientes', 'origens_clientes.id', 'origens_estoques_locais.cliente_id')

//         ->join('estoques_locais as destinos_estoques_locais', 'destinos_estoques_locais.id', 'materiais_movimentacoes.destino_estoque_local_id')
//         ->join('estoques as destinos_estoques', 'destinos_estoques.id', 'destinos_estoques_locais.estoque_id')
//         ->leftjoin('empresas as destinos_empresas', 'destinos_empresas.id', 'destinos_estoques_locais.empresa_id')
//         ->leftjoin('clientes as destinos_clientes', 'destinos_clientes.id', 'destinos_estoques_locais.cliente_id')

//         ->select(
//             'materiais_movimentacoes.*',

//             'origens_estoques_locais.name as origemEstoqueLocalName',
//             'origens_estoques.name as origemEstoqueName',
//             'origens_empresas.name as origemEmpresaName',
//             'origens_clientes.name as origemClienteName',

//             'destinos_estoques_locais.name as destinoEstoqueLocalName',
//             'destinos_estoques.name as destinoEstoqueName',
//             'destinos_empresas.name as destinoEmpresaName',
//             'destinos_clientes.name as destinoClienteName'
//         );



//         // Obter SQL e bindings
// $sql = $query->toSql();
// $bindings = $query->getBindings();

// // Substituir os ? pelos valores reais (para visualização)
// $fullSql = vsprintf(
//     str_replace('?', "'%s'", $sql),
//     array_map(function ($binding) {
//         return is_numeric($binding) ? $binding : addslashes($binding);
//     }, $bindings)
// );

// // Agora $fullSql contém a SQL completa
// // Você pode dd, logar ou guardar onde quiser:
// $registros = $fullSql;







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
            //Incluindo registro
            $registro = $this->material_movimentacao->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, 'null');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(MaterialMovimentacaoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->material_movimentacao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = $this->material_movimentacao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
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
}
