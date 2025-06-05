<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\VisitaTecnicaStoreRequest;
use App\Http\Requests\VisitaTecnicaUpdateRequest;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\VisitaTecnicaDado;
use App\Models\VisitaTecnicaPergunta;
use App\Models\VisitaTecnicaStatus;
use App\Models\VisitaTecnicaTipo;
use Illuminate\Support\Facades\DB;
use App\Models\VisitaTecnica;

class VisitaTecnicaController extends Controller
{
    private $visita_tecnica;

    public function __construct(VisitaTecnica $visita_tecnica)
    {
        $this->visita_tecnica = $visita_tecnica;
    }

    public function index($empresa_id)
    {
        $registros = $this->visita_tecnica
            ->leftJoin('visita_tecnica_tipos', 'visitas_tecnicas.visita_tecnica_tipo_id', '=', 'visita_tecnica_tipos.id')
            ->leftJoin('clientes', 'visitas_tecnicas.cliente_id', '=', 'clientes.id')
            ->select(['visitas_tecnicas.*', 'visita_tecnica_tipos.name as visitaTecnicaTipoName', 'clientes.name as clienteName'])
            ->where('clientes.empresa_id', $empresa_id)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->visita_tecnica
                ->Join('clientes', 'visitas_tecnicas.cliente_id', '=', 'clientes.id')
                ->Join('visita_tecnica_tipos', 'visitas_tecnicas.visita_tecnica_tipo_id', '=', 'visita_tecnica_tipos.id')
                ->Join('visita_tecnica_status', 'visitas_tecnicas.visita_tecnica_status_id', '=', 'visita_tecnica_status.id')
                ->select(['visitas_tecnicas.*', 'clientes.name as clienteName', 'visita_tecnica_tipos.name as visitaTecnicaTipoName', 'visita_tecnica_status.name as visitaTecnicaStatusName'])
                ->where('visitas_tecnicas.id', '=', $id)
                ->get()[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //buscar dados visitas_tecnicas_dados
                $registro['visitas_tecnicas_dados'] = VisitaTecnicaDado::where('visita_tecnica_id', '=', $id)->orderby('ordem')->get();

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
            $registros['clientes'] = Cliente::where('empresa_id', '=', $empresa_id)->get();

            //Funcionários
            $funcionarios = Funcionario
                ::leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->select(['funcionarios.*', 'funcoes.name as funcaoName'])
                ->where('funcionarios.empresa_id', '=', $empresa_id)
                ->get();

            $registros['funcionarios'] = $funcionarios;

            //Visitas Tecnicas Tipos
            $registros['visita_tecnica_tipos'] = VisitaTecnicaTipo::all();

            //Visitas Tecnicas Status
            $registros['visita_tecnica_status'] = VisitaTecnicaStatus::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(VisitaTecnicaStoreRequest $request)
    {
        try {
            //Acertos campos''''''''''''''''''''''''''''''''''''''''''''''''
            //visita_tecnica_status_id
            $request['visita_tecnica_status_id'] = 1;

            //numero_visita_tecnica
            $reg = VisitaTecnica::latest()->first();
            if ($reg) {
                $request['numero_visita_tecnica'] = $reg['numero_visita_tecnica'] + 1;
            } else {
                $request['numero_visita_tecnica'] = 1;
            }

            //data_abertura
            $request['data_abertura'] = date('d/m/Y');

            //hora_abertura
            $request['hora_abertura'] = date('H:i:s');

            //ano_visita_tecnica
            $request['ano_visita_tecnica'] = substr($request['data_abertura'], 6, 4);

            //data_prevista
            $request['data_prevista'] = $request['data_abertura'];

            //hora_prevista
            $request['hora_prevista'] = $request['hora_abertura'];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Buscar dados Cliente''''''''''''''''''''''''''''''''''''''''''
            $cliente = Cliente::find($request['cliente_id']);

            if (!$cliente) {
                return $this->sendResponse('Cliente não encontrado.', 2040, null, null);
            } else {
                $request['cliente_nome'] = $cliente['name'];
                $request['cliente_telefone'] = $cliente['telefone_1'];
                $request['cliente_celular'] = $cliente['celular_1'];
                $request['cliente_email'] = $cliente['email'];
                $request['cliente_logradouro'] = $cliente['logradouro'];
                $request['cliente_bairro'] = $cliente['bairro'];
                $request['cliente_cidade'] = $cliente['localidade'];
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Incluindo registro na tabela visitas_tecnicas
            $registro = $this->visita_tecnica->create($request->all());

            //Incluindo registros na tabela visitas_tecnicas_dados''''''''''
            $visita_tecnica_id = $registro['id'];
            $visita_tecnica_tipo_id = $registro['visita_tecnica_tipo_id'];

            $visita_tecnica_perguntas = VisitaTecnicaPergunta::where('visita_tecnica_tipo_id', $visita_tecnica_tipo_id)->get();

            foreach ($visita_tecnica_perguntas as $visita_tecnica_pergunta) {
                $dados = $visita_tecnica_pergunta->toArray(); // transforma o objeto em array

                $dados['visita_tecnica_id'] = $visita_tecnica_id;
                unset($dados['id'], $dados['created_at'], $dados['updated_at']);

                VisitaTecnicaDado::create($dados);

                // Gravar transação
                // Transacoes::transacaoRecord();
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Return
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(VisitaTecnicaUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->visita_tecnica->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Alterando registro
                $registro->update($request->all());

                //Return
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
            $registro = $this->visita_tecnica->find($id);

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

    public function filter($array_dados, $empresa_id)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->visita_tecnica
            ->leftJoin('clientes', 'visitas_tecnicas.cliente_id', '=', 'clientes.id')
            ->select(['visitas_tecnicas.*', 'clientes.name as clienteName'])
            ->where('clientes.empresa_id', '=', $empresa_id)
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
