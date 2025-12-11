<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\MaterialMovimentacaoStoreRequest;
use App\Http\Requests\MaterialMovimentacaoUpdateRequest;
use App\Models\Fornecedor;
use App\Models\Material;
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
        $empresa_id = $request->header('X-Empresa-Id');

        $registros = $this->material_movimentacao
        ->join('fornecedores', 'fornecedores.id', 'materiais_movimentacoes.fornecedor_id')
        ->select('materiais_movimentacoes.*', 'fornecedores.name as fornecedorName')
        ->where('materiais_movimentacoes.empresa_id', $empresa_id)
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
                // Materiais Movimentacoes Itens
                $registro['material_movimentacao_itens'] = MaterialMovimentacaoItem::where('material_movimentacao_id', '=', $id)->get();

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

            // Fornecedores
            $registros['fornecedores'] = Fornecedor::orderby('name')->get();

            //Materiais (com Categorias)
            $registros['materiais'] = Material
                ::join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
                ->select('materiais.*', 'material_categorias.name as materialCategoriaName')
                ->orderby('material_categorias.name')
                ->orderby('materiais.name')
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
            // Empresa ID no $request
            $empresa_id = $request->header('X-Empresa-Id');

            // Merge no request
            $request->merge(['empresa_id' => $empresa_id]);


            //Incluindo registro
            $registro = $this->material_movimentacao->create($request->all());

            //Editar dados na tabela materiais_movimentacoes_itens
            SuporteFacade::editMaterialMovimentacaoItem(1, $registro['id'], $request);

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

                //Editar dados na tabela materiais_movimentacoes_itens
                SuporteFacade::editMaterialMovimentacaoItem(3, $registro['id'], $request);

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

                //Editar dados na tabela materiais_movimentacoes_itens
                SuporteFacade::editMaterialMovimentacaoItem(2, $registro['id'], '');

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
