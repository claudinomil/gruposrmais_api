<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\FornecedorStoreRequest;
use App\Http\Requests\FornecedorUpdateRequest;
use App\Models\Banco;
use App\Models\Genero;
use App\Models\IdentidadeOrgao;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    private $fornecedor;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    public function index($empresa_id)
    {
        $registros = DB::table('fornecedores')
            ->leftJoin('identidade_orgaos', 'fornecedores.identidade_orgao_id', '=', 'identidade_orgaos.id')
            ->leftJoin('estados', 'fornecedores.identidade_estado_id', '=', 'estados.id')
            ->leftJoin('generos', 'fornecedores.genero_id', '=', 'generos.id')
            ->leftJoin('bancos', 'fornecedores.banco_id', '=', 'bancos.id')
            ->select(['fornecedores.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'bancos.name as bancoName'])
            ->where('fornecedores.empresa_id', $empresa_id)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->fornecedor->find($id);

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

            //Gêneros
            $registros['generos'] = Genero::all();

            //Bancos
            $registros['bancos'] = Banco::all();

            //Órgãos Identidades
            $registros['identidade_orgaos'] = IdentidadeOrgao::all();

            //Estados para a Identidade
            $registros['identidade_estados'] = Estado::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(FornecedorStoreRequest $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Colocar empresa_id no Request
            $request['empresa_id'] = $empresa_id;

            //Incluindo registro
            $this->fornecedor->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(FornecedorUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->fornecedor->find($id);

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

    public function extraData($id)
    {
        try {
            $registro = array();

            //Fornecedor
            $fornecedor = Fornecedor::
                where('fornecedores.id', '=', $id)
                ->get();

            $registro['fornecedor'] = $fornecedor[0];

            //Compras no Fornecedor
            $fornecedor_compras = [];

            $registro['fornecedor_compras'] = $fornecedor_compras;

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
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
            $registro = $this->fornecedor->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

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

//    public function search($field, $value, $empresa_id)
//    {
//        $registros = DB::table('fornecedores')
//            ->leftJoin('identidade_orgaos', 'fornecedores.identidade_orgao_id', '=', 'identidade_orgaos.id')
//            ->leftJoin('estados', 'fornecedores.identidade_estado_id', '=', 'estados.id')
//            ->leftJoin('generos', 'fornecedores.genero_id', '=', 'generos.id')
//            ->leftJoin('bancos', 'fornecedores.banco_id', '=', 'bancos.id')
//            ->select(['fornecedores.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'bancos.name as bancoName'])
//            ->where('fornecedores.empresa_id', '=', $empresa_id)
//            ->where($field, 'like', '%' . $value . '%')
//            ->get();
//
//        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
//    }

    public function filter($array_dados, $empresa_id)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->fornecedor
            ->leftJoin('identidade_orgaos', 'fornecedores.identidade_orgao_id', '=', 'identidade_orgaos.id')
            ->leftJoin('estados', 'fornecedores.identidade_estado_id', '=', 'estados.id')
            ->leftJoin('generos', 'fornecedores.genero_id', '=', 'generos.id')
            ->leftJoin('bancos', 'fornecedores.banco_id', '=', 'bancos.id')
            ->select(['fornecedores.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'bancos.name as bancoName'])
            ->where('fornecedores.empresa_id', '=', $empresa_id)
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
