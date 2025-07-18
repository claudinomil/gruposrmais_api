<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\VeiculoStoreRequest;
use App\Http\Requests\VeiculoUpdateRequest;
use App\Models\VeiculoCategoria;
use App\Models\VeiculoCombustivel;
use App\Models\VeiculoMarca;
use App\Models\VeiculoModelo;
use Illuminate\Support\Facades\DB;
use App\Models\Veiculo;

class VeiculoController extends Controller
{
    private $veiculo;

    public function __construct(Veiculo $veiculo)
    {
        $this->veiculo = $veiculo;
    }

    public function index($empresa_id)
    {
        $registros = DB::table('veiculos')
            ->leftJoin('veiculo_categorias', 'veiculos.veiculo_categoria_id', '=', 'veiculo_categorias.id')
            ->leftJoin('veiculo_combustiveis', 'veiculos.veiculo_combustivel_id', '=', 'veiculo_combustiveis.id')
            ->leftJoin('veiculo_marcas', 'veiculos.veiculo_marca_id', '=', 'veiculo_marcas.id')
            ->leftJoin('veiculo_modelos', 'veiculos.veiculo_modelo_id', '=', 'veiculo_modelos.id')
            ->select(['veiculos.*', 'veiculo_categorias.name as veiculoCategoriaName', 'veiculo_combustiveis.name as veiculoCombustivelName', 'veiculo_marcas.name as veiculoMarcaName', 'veiculo_modelos.name as veiculoModeloName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->veiculo
                ->leftJoin('veiculo_categorias', 'veiculos.veiculo_categoria_id', '=', 'veiculo_categorias.id')
                ->leftJoin('veiculo_combustiveis', 'veiculos.veiculo_combustivel_id', '=', 'veiculo_combustiveis.id')
                ->leftJoin('veiculo_marcas', 'veiculos.veiculo_marca_id', '=', 'veiculo_marcas.id')
                ->leftJoin('veiculo_modelos', 'veiculos.veiculo_modelo_id', '=', 'veiculo_modelos.id')
                ->select(['veiculos.*', 'veiculo_categorias.name as veiculoCategoriaName', 'veiculo_combustiveis.name as veiculoCombustivelName', 'veiculo_marcas.name as veiculoMarcaName', 'veiculo_modelos.name as veiculoModeloName'])
                ->where('veiculos.id', '=', $id)
                ->get()[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
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

    public function auxiliary($empresa_id)
    {
        try {
            $registros = array();

            //Veiculo Categorias
            $registros['veiculo_categorias'] = VeiculoCategoria::all();

            //Veiculo Combustiveis
            $registros['veiculo_combustiveis'] = VeiculoCombustivel::all();

            //Veiculo Marcas
            $registros['veiculo_marcas'] = VeiculoMarca::all();

            //Veiculo Modelos
            $registros['veiculo_modelos'] = VeiculoModelo::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(VeiculoStoreRequest $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Colocar empresa_id no Request
            $request['empresa_id'] = $empresa_id;

            //Incluindo registro
            $this->veiculo->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(VeiculoUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->veiculo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

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

    public function destroy($id, $empresa_id)
    {
        try {
            $registro = $this->veiculo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela ordens_servicos_veiculos
                if (SuporteFacade::verificarRelacionamento('ordens_servicos_veiculos', 'veiculo_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Ordens Serviços Veículos.', 2040, null, null);
                }
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

    public function filter($array_dados, $empresa_id)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->veiculo
            ->leftJoin('veiculo_categorias', 'veiculos.veiculo_categoria_id', '=', 'veiculo_categorias.id')
            ->leftJoin('veiculo_combustiveis', 'veiculos.veiculo_combustivel_id', '=', 'veiculo_combustiveis.id')
            ->leftJoin('veiculo_marcas', 'veiculos.veiculo_marca_id', '=', 'veiculo_marcas.id')
            ->leftJoin('veiculo_modelos', 'veiculos.veiculo_modelo_id', '=', 'veiculo_modelos.id')
            ->select(['veiculos.*', 'veiculo_categorias.name as veiculoCategoriaName', 'veiculo_combustiveis.name as veiculoCombustivelName', 'veiculo_marcas.name as veiculoMarcaName', 'veiculo_modelos.name as veiculoModeloName'])
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
