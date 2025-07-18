<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Http\Requests\ClienteExecutivoStoreRequest;
use App\Http\Requests\ClienteExecutivoUpdateRequest;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\ClienteExecutivoDocumento;
use App\Models\Estado;
use App\Models\Genero;
use App\Models\IdentidadeOrgao;
use App\Models\Nacionalidade;
use Illuminate\Http\Request;

class ClienteExecutivoController extends Controller
{
    private $cliente_executivo;

    public function __construct(ClienteExecutivo $cliente_executivo)
    {
        $this->cliente_executivo = $cliente_executivo;
    }

    public function index($empresa_id)
    {
        $registros = $this->cliente_executivo
            ->leftJoin('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
            ->select(['clientes_executivos.*', 'clientes.name as clienteName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->cliente_executivo->find($id);

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

            //Clientes
            $registros['clientes'] = Cliente::all();

            //Gêneros
            $registros['generos'] = Genero::all();

            //Nacionalidades
            $registros['nacionalidades'] = Nacionalidade::all();

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

    public function store(ClienteExecutivoStoreRequest $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Colocar empresa_id no Request
            $request['empresa_id'] = $empresa_id;

            //Incluindo registro
            $registro = $this->cliente_executivo->create($request->all());

            //Return
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(ClienteExecutivoUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->cliente_executivo->find($id);

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
            $registro = $this->cliente_executivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela ordens_servicos_executivos
                if (SuporteFacade::verificarRelacionamento('ordens_servicos_executivos', 'cliente_executivo_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Ordens Serviços Executivos.', 2040, null, null);
                }

                //Tabela clientes_executivos_documentos
                if (SuporteFacade::verificarRelacionamento('clientes_executivos_documentos', 'cliente_executivo_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Clientes Executivos Documentos.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Apagar dados na tabela clientes_executivos_documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                ClienteExecutivoDocumento::where('cliente_executivo_id', '=', $id)->delete();
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
        $registros = $this->cliente_executivo
            ->leftJoin('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
            ->select(['clientes_executivos.*', 'clientes.name as clienteName'])
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

    public function modal_info($id)
    {
        try {
            $registro = array();

            //ClienteExecutivo
            $cliente_executivo = ClienteExecutivo
                ::leftJoin('generos', 'clientes_executivos.genero_id', '=', 'generos.id')
                ->select(['clientes_executivos.*', 'generos.name as generoName'])
                ->where('clientes_executivos.id', '=', $id)
                ->get();

            $registro['cliente_executivo'] = $cliente_executivo[0];

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_foto(Request $request, $id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($request['empresa_id']);

            $registro = $this->cliente_executivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                //Transação
                $dadosAtual = array();
                $dadosAtual['empresa_id'] = $request['empresa_id'];
                $dadosAtual['name'] = $request['name'];
                $dadosAtual['foto'] = 'Foto atualizada';

                Transacoes::transacaoRecord(3, 2, 'clientes_executivos', $request, $dadosAtual);

                //Return
                return $this->sendResponse('Foto atualizada com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_documento(Request $request)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($request['empresa_id']);

            //Incluir Registro
            if ($request['acao'] == 1) {
                //Registro
                ClienteExecutivoDocumento::create($request->all());

                //Transação
                Transacoes::transacaoRecord(2, 1, 'clientes_executivos', $request, $request);

                //Return
                return $this->sendResponse('Documento enviado com sucesso.', 2000, null, $request);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function documentos($cliente_executivo_id)
    {
        try {
            $registros = ClienteExecutivoDocumento
                ::where('cliente_executivo_id', $cliente_executivo_id)
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_documento($cliente_executivo_documento_id, $empresa_id)
    {
        //Atualisar objeto Auth::user()
        SuporteFacade::setUserLogged($empresa_id);

        $registro = ClienteExecutivoDocumento::find($cliente_executivo_documento_id);

        if (!$registro) {
            return $this->sendResponse('Documento não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(2, 3, 'clientes_executivos', $registro, $registro);

            //Return
            return $this->sendResponse('Documento excluído com sucesso.', 2000, null, $registro['caminho']);
        }
    }

    public function cartoes_emergenciais_registros()
    {
        $registros = $this->cliente_executivo->orderby('id')->get(['id']);

        return response()->json($registros, 200);
    }

    public function cartoes_emergenciais_dados($empresa_id, $ids)
    {
        try {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $registros = ClienteExecutivo
                ::leftJoin('generos', 'clientes_executivos.genero_id', '=', 'generos.id')
                ->leftJoin('clientes', 'clientes_executivos.cliente_id', '=', 'clientes.id')
                ->select(['clientes_executivos.*', 'generos.name as generoName', 'clientes.name as clienteName'])
                ->wherein('clientes_executivos.id', $ids)
                ->get();

            if (!$registros) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $registros);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
