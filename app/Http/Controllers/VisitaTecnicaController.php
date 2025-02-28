<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Models\ClienteServico;
use App\Models\User;
use App\Models\VisitaTecnicaSegurancaMedida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\VisitaTecnica;
use Illuminate\Http\Request;

class VisitaTecnicaController extends Controller
{
    private $visita_tecnica;

    public function __construct(VisitaTecnica $visita_tecnica)
    {
        $this->visita_tecnica = $visita_tecnica;
    }

    public function index($empresa_id)
    {
        //Registros para Grade
        $registros = $this->visita_tecnica
            ::Join('clientes_servicos', 'clientes_servicos.id', '=', 'visitas_tecnicas.cliente_servico_id')
            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
            ->select([
                'visitas_tecnicas.*'
                , DB::raw('DATE_FORMAT(clientes_servicos.data_inicio, "%d/%m/%Y") as data_inicio')
                , 'clientes_servicos.servico_status_id'
                , 'servicos.name as servicoName'
                , 'clientes.name as clienteName'
                , 'servico_status.name as servicoStatusName'
                , 'funcionarios.name as funcionarioName'
            ])
            ->where('visitas_tecnicas.empresa_id', $empresa_id)
            ->where('servicos.servico_tipo_id', '=', 3)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            //Buscar Registro
            $registro = $this->visita_tecnica
                ->leftjoin('users', 'users.id', 'visitas_tecnicas.executado_user_id')
                ->leftjoin('funcionarios', 'funcionarios.id', 'users.funcionario_id')
                ->select('visitas_tecnicas.*', 'funcionarios.name as executado_user_funcionario')
                ->where('visitas_tecnicas.id', $id)
                ->get()[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //buscar dados da tabela clientes_servicos
                $registro['clientes_servicos_servico'] = ClienteServico
                    ::leftjoin('clientes', 'clientes_servicos.cliente_id', 'clientes.id')
                    ->leftjoin('servico_status', 'clientes_servicos.servico_status_id', 'servico_status.id')
                    ->leftjoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', 'funcionarios.id')
                    ->select('clientes_servicos.*', 'clientes.name as clienteName', 'servico_status.name as servicoStatusName', 'funcionarios.name as responsavelFuncionarioName')
                    ->where('clientes_servicos.id', '=', $registro['cliente_servico_id'])
                    ->get()[0];

                //buscar dados das medidas de segurança
                $registro['cliente_seguranca_medidas'] = VisitaTecnicaSegurancaMedida::where('visita_tecnica_id', '=', $id)->get();

                //Dados para Finalizar Serviço
                $registro['dados_servico_executado'] = User
                    ::leftjoin('funcionarios', 'funcionarios.id', 'users.funcionario_id')
                    ->select('users.id as executado_user_id', 'funcionarios.name as executado_user_funcionario')
                    ->where('users.id', Auth::user()->id)
                    ->get()[0];

                $registro['dados_servico_executado']['executado_data'] = date('d/m/Y');

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

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(Request $request, $id, $empresa_id)
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

                //Gravar dados na tabela visitas_tecnicas_seguranca_medidas''''''''''''
                $numero_pavimentos = $request['numero_pavimentos'];
                $ids_seguranca_medidas = array_unique($request['ids_seguranca_medidas']); //Retirando ids repetidos

                for($i=1; $i<=$numero_pavimentos; $i++) {
                    foreach ($ids_seguranca_medidas as $seguranca_medida_id) {
                        if (isset($request['seguranca_medida_id_' . $i . '_' . $seguranca_medida_id])) {
                            //Dados Atual
                            $dadosAtual = array();
                            $dadosAtual['visita_tecnica_id'] = $id;
                            $dadosAtual['pavimento'] = $i;
                            $dadosAtual['seguranca_medida_id'] = $seguranca_medida_id;
                            $dadosAtual['seguranca_medida_nome'] = $request['seguranca_medida_nome_' . $i . '_' . $seguranca_medida_id];
                            $dadosAtual['seguranca_medida_quantidade'] = $request['seguranca_medida_quantidade_' . $i . '_' . $seguranca_medida_id];
                            $dadosAtual['seguranca_medida_tipo'] = $request['seguranca_medida_tipo_' . $i . '_' . $seguranca_medida_id];
                            $dadosAtual['seguranca_medida_observacao'] = $request['seguranca_medida_observacao_' . $i . '_' . $seguranca_medida_id];
                            $dadosAtual['status'] = $request['status_' . $i . '_' . $seguranca_medida_id];
                            $dadosAtual['observacao'] = $request['observacao_' . $i . '_' . $seguranca_medida_id];

                            $visita_tecnica_seguranca_medida = VisitaTecnicaSegurancaMedida::where('visita_tecnica_id', $id)->where('pavimento', $i)->where('seguranca_medida_id', $seguranca_medida_id)->get();

                            if ($visita_tecnica_seguranca_medida->count() == 1) {
                                VisitaTecnicaSegurancaMedida::where('visita_tecnica_id', $id)->where('pavimento', $i)->where('seguranca_medida_id', $seguranca_medida_id)->update($dadosAtual);

                                //gravar transacao
                                Transacoes::transacaoRecord(2, 2, 'visitas_tecnicas', $visita_tecnica_seguranca_medida[0], $dadosAtual);
                            } else {
                                VisitaTecnicaSegurancaMedida::create($dadosAtual);

                                //gravar transacao
                                Transacoes::transacaoRecord(2, 1, 'visitas_tecnicas', $dadosAtual, $dadosAtual);
                            }
                        }
                    }
                }
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Alterar dados na tabela clientes_servicos''''''''''''''''''''''''''''
                if ($request->has('executado_user_id')) {
                    $dataUpdate = array();
                    $dataUpdate['servico_status_id'] = 1;
                    $dataUpdate['responsavel_funcionario_id'] = $request['executado_user_id'];

                    $registroUpdate = ClienteServico::find($registro['cliente_servico_id']);

                    if ($registroUpdate) {
                        $registroUpdate->update($dataUpdate);
                    }
                }
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
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
//        //Registros para Grade
//        $registros = $this->visita_tecnica
//            ::Join('clientes_servicos', 'clientes_servicos.id', '=', 'visitas_tecnicas.cliente_servico_id')
//            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
//            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
//            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
//            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
//            ->select([
//                'visitas_tecnicas.*'
//                , DB::raw('DATE_FORMAT(clientes_servicos.data_inicio, "%d/%m/%Y") as data_inicio')
//                , 'clientes_servicos.servico_status_id'
//                , 'servicos.name as servicoName'
//                , 'clientes.name as clienteName'
//                , 'servico_status.name as servicoStatusName'
//                , 'funcionarios.name as funcionarioName'
//            ])
//            ->where('visitas_tecnicas.empresa_id', $empresa_id)
//            ->where('servicos.servico_tipo_id', '=', 3)
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
        $registros = $this->visita_tecnica
            ::Join('clientes_servicos', 'clientes_servicos.id', '=', 'visitas_tecnicas.cliente_servico_id')
            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
            ->select([
                'visitas_tecnicas.*'
                , DB::raw('DATE_FORMAT(clientes_servicos.data_inicio, "%d/%m/%Y") as data_inicio')
                , 'clientes_servicos.servico_status_id'
                , 'servicos.name as servicoName'
                , 'clientes.name as clienteName'
                , 'servico_status.name as servicoStatusName'
                , 'funcionarios.name as funcionarioName'
            ])
            ->where('visitas_tecnicas.empresa_id', $empresa_id)
            ->where('servicos.servico_tipo_id', '=', 3)
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

    public function medidas_seguranca(int $np, $atc, string $grupo, string $divisao)
    {
        try {
            //Acerto variaves
            $atc = str_replace('.', '', $atc);
            $atc = str_replace('.', '', $atc);
            $atc = str_replace('.', '', $atc);
            $atc = str_replace(',', '.', $atc);

            //Regras para retornar Medidas de Segurança (DECRETO Nº 42, DE 17 DE DEZEMBRO DE 2018)''''''''''''''''''''''

            //Tabela 2 – Exigências para edificações com área menor ou igual a 900m² e até 02 pavimentos.
            if ($np <= 2 and $atc <= 900) {
                //3     Extintores
                //20    Sinalização de segurança
                //16    Iluminação de Emergência
                //18    Saídas de Emergência
                //17    Plano de emergência
                //10    Controle de Materiais de Acabamento
                //9     Controle de fumaça

                if ($grupo == 'A' or $grupo == 'D' or $grupo == 'E' or $grupo == 'G') {
                    if ($divisao == 'A-1' or $divisao == 'A-4') {$seguranca_medidas_ids = [3, 20, 18];}
                    if ($divisao == 'A-2' or $divisao == 'A-3' or $divisao == 'A-5' or $divisao == 'A-6') {$seguranca_medidas_ids = [3, 20, 16, 18];}
                }
                if ($grupo == 'B') {
                    $seguranca_medidas_ids = [3, 20, 16, 18, 10];
                }
                if ($grupo == 'C') {
                    $seguranca_medidas_ids = [3, 20, 16, 18];
                }
                if ($grupo == 'F') {
                    if ($divisao == 'F-1' or $divisao == 'F-2' or $divisao == 'F-3' or $divisao == 'F-4' or $divisao == 'F-7' or $divisao == 'F-8' or $divisao == 'F-10' or $divisao == 'F-11') {$seguranca_medidas_ids = [3, 20, 16, 18, 10];}
                    if ($divisao == 'F-5' or $divisao == 'F-11') {$seguranca_medidas_ids = [3, 20, 16, 18, 10];}
                    if ($divisao == 'F-6') {$seguranca_medidas_ids = [3, 20, 16, 18, 17, 10, 9];}
                    if ($divisao == 'F-9') {$seguranca_medidas_ids = [3, 20, 16, 18];}
                }
                if ($grupo == 'H') {
                    if ($divisao == 'H-1') {$seguranca_medidas_ids = [3, 20, 18];}
                    if ($divisao == 'H-2' or $divisao == 'H-3') {$seguranca_medidas_ids = [3, 20, 16, 18, 17, 10];}
                    if ($divisao == 'H-4') {$seguranca_medidas_ids = [0];}
                }
                if ($grupo == 'I') {
                    if ($divisao == 'I-1' or $divisao == 'I-2' or $divisao == 'I-3') {$seguranca_medidas_ids = [3, 20, 16, 18];}
                }
                if ($grupo == 'J') {
                    if ($divisao == 'J-1' or $divisao == 'J-2' or $divisao == 'J-3' or $divisao == 'J-4') {$seguranca_medidas_ids = [3, 20, 16, 18];}
                }
                if ($grupo == 'L') {
                    if ($divisao == 'L-1' or $divisao == 'L-2' or $divisao == 'L-3') {$seguranca_medidas_ids = [3, 20, 18, 10];}
                }
                if ($grupo == 'M') {
                    if ($divisao == 'M-1' or $divisao == 'M-2' or $divisao == 'M-3' or $divisao == 'M-4' or $divisao == 'M-5' or $divisao == 'M-6' or $divisao == 'M-7' or $divisao == 'M-8' or $divisao == 'M-9') {$seguranca_medidas_ids = [3, 20, 16, 18];}
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $registros = array();

            $registros['medidas_seguranca'] = DB::table('seguranca_medidas')->whereIn('id', $seguranca_medidas_ids)->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
