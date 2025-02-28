<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Models\BrigadaEscala;
use App\Models\BrigadaRonda;
use App\Models\BrigadaRondaSegurancaMedida;
use App\Models\Cliente;
use App\Models\ClienteServico;
use App\Models\ClienteServicoBrigadista;
use App\Models\EscalaTipo;
use App\Models\Funcionario;
use App\Models\Servico;
use App\Models\ServicoStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClienteServicoController extends Controller
{
    private $cliente_servico;

    public function __construct(ClienteServico $cliente_servico)
    {
        $this->cliente_servico = $cliente_servico;
    }

    public function index($empresa_id)
    {
        $registros = $this->cliente_servico
            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
            ->select(['clientes_servicos.*', 'clientes.name as clienteName', 'funcionarios.name as funcionarioName', 'servicos.servico_tipo_id', 'servicos.name as servicoName', 'servico_status.name as servicoStatusName'])
            ->where('servicos.empresa_id', $empresa_id)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);

    }

    public function show($id)
    {
        try {
            $registro = $this->cliente_servico->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //buscar dados dos brigadistas para o servico
                $registro['cliente_servicos_brigadistas'] = ClienteServicoBrigadista::where('cliente_servico_id', '=', $id)->orderby('ala')->get();

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

            //Servicos
            $registros['servicos'] = Servico::where('empresa_id', '=', $empresa_id)->get();

            //Servico Status
            $registros['servico_status'] = ServicoStatus::all();

            //Funcionarios
            $registros['funcionarios'] = Funcionario::where('empresa_id', '=', $empresa_id)->get();

            //Escala Tipos
            $registros['escala_tipos'] = EscalaTipo::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(Request $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Datas formato americano'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($request['data_inicio'] != '') {$request['data_inicio'] = Carbon::createFromFormat('d/m/Y', $request['data_inicio'])->format('Y-m-d');}
            if ($request['data_fim'] != '') {$request['data_fim'] = Carbon::createFromFormat('d/m/Y', $request['data_fim'])->format('Y-m-d');}
            if ($request['data_vencimento'] != '') {$request['data_vencimento'] = Carbon::createFromFormat('d/m/Y', $request['data_vencimento'])->format('Y-m-d');}
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Principais''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $validator_1 = Validator::make($request->all(),
                [
                    'cliente_id' => ['required', 'integer', 'numeric'],
                    'servico_id' => ['required', 'integer', 'numeric'],
                    'servico_status_id' => ['required', 'integer', 'numeric', Rule::notIn([1])],
                    'quantidade' => ['nullable'],
                    'data_inicio' => ['nullable', 'date'],
                    'data_fim' => ['nullable', 'date'],
                    'data_vencimento' => ['nullable', 'date'],
                    'valor' => ['nullable']
                ],
                [
                    'cliente_id.required' => 'O Cliente é requerido.',
                    'cliente_id.integer' => 'O Cliente deve ser um ítem da lista.',
                    'servico_id.required' => 'O Serviço é requerido.',
                    'servico_id.integer' => 'O Serviço deve ser um ítem da lista.',
                    'servico_status_id.required' => 'O Status é requerido.',
                    'servico_status_id.integer' => 'O Status deve ser um ítem da lista.',
                    'servico_status_id.not_in' => 'O Status "EXECUTADO" não deve ser acionado nesse Submódulo.',
                    'data_inicio.date_format' => 'A Data Início não é uma data válida.',
                    'data_fim.date_format' => 'A Data Fim não é uma data válida.',
                    'data_vencimento.date_format' => 'A Data Vencimento não é uma data válida.'
                ]
            );

            if ($validator_1->fails()) {
                return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_1->errors(), $request);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Tipo Serviço''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $servico_tipo_id = Servico::where('id', '=', $request['servico_id'])->get('servico_tipo_id');
            $servico_tipo_id = $servico_tipo_id[0]['servico_tipo_id'];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Brigada'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 1) {
                $validator_2 = Validator::make($request->all(),
                    [
                        'data_inicio' => ['required', 'date'],
                        'data_fim' => ['required', 'date', 'after_or_equal:data_inicio'],
                        'bi_escala_tipo_id' => ['required', 'integer', 'numeric'],
                        'bi_quantidade_alas_escala' => ['required', 'integer', 'numeric'],
                        'bi_quantidade_brigadistas_por_ala' => ['required', 'integer', 'numeric'],
                        'bi_quantidade_brigadistas_total' => ['required', 'integer', 'numeric'],
                        'bi_hora_inicio_ala' => ['required']
                    ],
                    [
                        'data_inicio.required' => 'A Data Início é requerida.',
                        'data_inicio.date' => 'A Data Início não é uma data válida.',
                        'data_fim.required' => 'A Data Fim é requerida.',
                        'data_fim.date' => 'A Data Fim não é uma data válida.',
                        'data_fim.after_or_equal' => 'A Data Fim não pode ser menor que a Data Início.',
                        'bi_escala_tipo_id.required' => 'A Escala é requerida.',
                        'bi_escala_tipo_id.integer' => 'A Escala deve ser um número inteiro.',
                        'bi_quantidade_alas_escala.required' => 'A Qtd de Alas é requerido.',
                        'bi_quantidade_alas_escala.integer' => 'A Qtd de Alas deve ser um número inteiro.',
                        'bi_quantidade_brigadistas_por_ala.required' => 'Brigadistas Ala é requerido.',
                        'bi_quantidade_brigadistas_por_ala.integer' => 'Brigadistas Ala deve ser um número inteiro.',
                        'bi_quantidade_brigadistas_total.required' => 'Brigadistas Total é requerido.',
                        'bi_quantidade_brigadistas_total.integer' => 'Brigadistas Total deve ser um número inteiro.',
                        'bi_hora_inicio_ala.required' => 'Hora início ala é requerida.'
                    ]
                );

                if ($validator_2->fails()) {
                    return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_2->errors(), $request);
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Manutenção''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 2) {
                $validator_2 = Validator::make($request->all(),
                    [
                        'data_inicio' => ['required', 'date_format:d/m/Y'],
                        'data_fim' => ['required', 'date', 'after_or_equal:data_inicio']
                    ],
                    [
                        'data_inicio.required' => 'A Data Início é requerida.',
                        'data_inicio.date' => 'A Data Início não é uma data válida.',
                        'data_fim.required' => 'A Data Fim é requerida.',
                        'data_fim.date' => 'A Data Fim não é uma data válida.',
                        'data_fim.after_or_equal' => 'A Data Fim não pode ser menor que a Data Início.',
                    ]
                );

                if ($validator_2->fails()) {
                    return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_2->errors(), $request);
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Visita Técnica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 3) {
                $validator_2 = Validator::make($request->all(),
                    [
                        'data_inicio' => ['required', 'date'],
                        'data_fim' => ['required', 'date', 'date_equals:data_inicio']
                    ],
                    [
                        'data_inicio.required' => 'A Data Início é requerida.',
                        'data_inicio.date' => 'A Data Início não é uma data válida.',
                        'data_fim.required' => 'A Data Fim é requerida.',
                        'data_fim.date' => 'A Data Fim não é uma data válida.',
                        'data_fim.date_equals' => 'A Data Fim deve ser igual a Data Início.',
                    ]
                );

                if ($validator_2->fails()) {
                    return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_2->errors(), $request);
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Incluindo registro
            $registro = ClienteServico::create($request->all());

            //Recuperando id da inclusão
            $cliente_servico_id = $registro['id'];

            //Tipo Serviço: BRIGADA DE INCÊNDIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 1) {
                //Editar dados na tabela cliente_servicos_brigadistas
                SuporteFacade::editClienteServicoBrigadistas(1, $cliente_servico_id, $request);

                //Gravar Brigada
                SuporteFacade::createBrigada($cliente_servico_id, $empresa_id);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Tipo Serviço: VISITA TÉCNICA''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 3) {
                //Gravar Visita Técnica
                SuporteFacade::createVisitaTecnica($cliente_servico_id, $empresa_id);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, $registro);
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
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Datas formato americano'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($request['data_inicio'] != '') {$request['data_inicio'] = Carbon::createFromFormat('d/m/Y', $request['data_inicio'])->format('Y-m-d');}
            if ($request['data_fim'] != '') {$request['data_fim'] = Carbon::createFromFormat('d/m/Y', $request['data_fim'])->format('Y-m-d');}
            if ($request['data_vencimento'] != '') {$request['data_vencimento'] = Carbon::createFromFormat('d/m/Y', $request['data_vencimento'])->format('Y-m-d');}
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Principais''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $validator_1 = Validator::make($request->all(),
                [
                    'cliente_id' => ['required', 'integer', 'numeric'],
                    'servico_id' => ['required', 'integer', 'numeric'],
                    'servico_status_id' => ['required', 'integer', 'numeric', Rule::notIn([1])],
                    'quantidade' => ['nullable'],
                    'data_inicio' => ['nullable', 'date'],
                    'data_fim' => ['nullable', 'date'],
                    'data_vencimento' => ['nullable', 'date'],
                    'valor' => ['nullable']
                ],
                [
                    'cliente_id.required' => 'O Cliente é requerido.',
                    'cliente_id.integer' => 'O Cliente deve ser um ítem da lista.',
                    'servico_id.required' => 'O Serviço é requerido.',
                    'servico_id.integer' => 'O Serviço deve ser um ítem da lista.',
                    'servico_status_id.required' => 'O Status é requerido.',
                    'servico_status_id.integer' => 'O Status deve ser um ítem da lista.',
                    'servico_status_id.not_in' => 'O Status "EXECUTADO" não deve ser acionado nesse Submódulo.',
                    'data_inicio.date_format' => 'A Data Início não é uma data válida.',
                    'data_fim.date_format' => 'A Data Fim não é uma data válida.',
                    'data_vencimento.date_format' => 'A Data Vencimento não é uma data válida.'
                ]
            );

            if ($validator_1->fails()) {
                return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_1->errors(), $request);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Tipo Serviço''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $servico_tipo_id = Servico::where('id', '=', $request['servico_id'])->get('servico_tipo_id');
            $servico_tipo_id = $servico_tipo_id[0]['servico_tipo_id'];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Brigada'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 1) {
                $validator_2 = Validator::make($request->all(),
                    [
                        'data_inicio' => ['required', 'date'],
                        'data_fim' => ['required', 'date', 'after_or_equal:data_inicio'],
                        'bi_escala_tipo_id' => ['required', 'integer', 'numeric'],
                        'bi_quantidade_alas_escala' => ['required', 'integer', 'numeric'],
                        'bi_quantidade_brigadistas_por_ala' => ['required', 'integer', 'numeric'],
                        'bi_quantidade_brigadistas_total' => ['required', 'integer', 'numeric'],
                        'bi_hora_inicio_ala' => ['required']
                    ],
                    [
                        'data_inicio.required' => 'A Data Início é requerida.',
                        'data_inicio.date' => 'A Data Início não é uma data válida.',
                        'data_fim.required' => 'A Data Fim é requerida.',
                        'data_fim.date' => 'A Data Fim não é uma data válida.',
                        'data_fim.after_or_equal' => 'A Data Fim não pode ser menor que a Data Início.',
                        'bi_escala_tipo_id.required' => 'A Escala é requerida.',
                        'bi_escala_tipo_id.integer' => 'A Escala deve ser um número inteiro.',
                        'bi_quantidade_alas_escala.required' => 'A Qtd de Alas é requerido.',
                        'bi_quantidade_alas_escala.integer' => 'A Qtd de Alas deve ser um número inteiro.',
                        'bi_quantidade_brigadistas_por_ala.required' => 'Brigadistas Ala é requerido.',
                        'bi_quantidade_brigadistas_por_ala.integer' => 'Brigadistas Ala deve ser um número inteiro.',
                        'bi_quantidade_brigadistas_total.required' => 'Brigadistas Total é requerido.',
                        'bi_quantidade_brigadistas_total.integer' => 'Brigadistas Total deve ser um número inteiro.',
                        'bi_hora_inicio_ala.required' => 'Hora início ala é requerida.'
                    ]
                );

                if ($validator_2->fails()) {
                    return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_2->errors(), $request);
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Manutenção''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 2) {
                $validator_2 = Validator::make($request->all(),
                    [
                        'data_inicio' => ['required', 'date_format:d/m/Y'],
                        'data_fim' => ['required', 'date', 'after_or_equal:data_inicio']
                    ],
                    [
                        'data_inicio.required' => 'A Data Início é requerida.',
                        'data_inicio.date' => 'A Data Início não é uma data válida.',
                        'data_fim.required' => 'A Data Fim é requerida.',
                        'data_fim.date' => 'A Data Fim não é uma data válida.',
                        'data_fim.after_or_equal' => 'A Data Fim não pode ser menor que a Data Início.',
                    ]
                );

                if ($validator_2->fails()) {
                    return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_2->errors(), $request);
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Validando Dados Visita Técnica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($servico_tipo_id == 3) {
                $validator_2 = Validator::make($request->all(),
                    [
                        'data_inicio' => ['required', 'date'],
                        'data_fim' => ['required', 'date', 'date_equals:data_inicio']
                    ],
                    [
                        'data_inicio.required' => 'A Data Início é requerida.',
                        'data_inicio.date' => 'A Data Início não é uma data válida.',
                        'data_fim.required' => 'A Data Fim é requerida.',
                        'data_fim.date' => 'A Data Fim não é uma data válida.',
                        'data_fim.date_equals' => 'A Data Fim deve ser igual a Data Início.',
                    ]
                );

                if ($validator_2->fails()) {
                    return $this->sendResponse('Falha na validação dos dados.', 2020, $validator_2->errors(), $request);
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //buscando registro
            $registro = $this->cliente_servico->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Verificar se operação pode ser realizada
                $validacao = SuporteFacade::validarClienteServico(1, $id);
                if ($validacao) {return $this->sendResponse($validacao, 4060, null, null);}

                //Alterando registro
                $registro->update($request->all());

                //Tipo Serviço: BRIGADA DE INCÊNDIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                if ($servico_tipo_id == 1) {
                    //Editar dados na tabela cliente_servicos_brigadistas
                    SuporteFacade::editClienteServicoBrigadistas(3, $id, $request);

                    //Alterar Brigada
                    SuporteFacade::updateBrigada($id);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Tipo Serviço: VISITA TÉCNICA''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                if ($servico_tipo_id == 3) {
                    //Gravar Visita Técnica
                    SuporteFacade::updateVisitaTecnica($id);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

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
            $registro = $this->cliente_servico->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar se operação pode ser realizada
                $validacao = SuporteFacade::validarClienteServico(2, $id);
                if ($validacao) {return $this->sendResponse($validacao, 4060, null, null);}

                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Pegar servico_tipo_id do Serviço do Cliente
                $servico = Servico::where('id', $registro['servico_id'])->get()[0];
                $servico_tipo_id = $servico['servico_tipo_id'];

                //Tipo Serviço: BRIGADA DE INCÊNDIO''''''''''''''''''''''''''''''''''''
                if ($servico_tipo_id == 1) {
                    //Tabela: brigadas_escalas
                    SuporteFacade::deleteBrigadaEscalas(1, $id);

                    //Editar dados na tabela cliente_servicos_brigadistas
                    SuporteFacade::editClienteServicoBrigadistas(2, $id, '');
                }
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Tipo Serviço: VISITA TÉCNICA'''''''''''''''''''''''''''''''''''''''''
                if ($servico_tipo_id == 3) {
                    //Deletar Visita Técnica
                    SuporteFacade::deleteVisitaTecnica($id);
                }
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletando registro
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
//        $registros = $this->cliente_servico
//            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
//            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
//            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
//            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
//            ->select(['clientes_servicos.*', 'clientes.name as clienteName', 'funcionarios.name as funcionarioName', 'servicos.servico_tipo_id', 'servicos.name as servicoName', 'servico_status.name as servicoStatusName'])
//            ->where('servicos.empresa_id', $empresa_id)
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
        $registros = $this->cliente_servico
            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
            ->select(['clientes_servicos.*', 'clientes.name as clienteName', 'funcionarios.name as funcionarioName', 'servicos.servico_tipo_id', 'servicos.name as servicoName', 'servico_status.name as servicoStatusName'])
            ->where('servicos.empresa_id', $empresa_id)
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

    //Eventos para QRCode - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Eventos para QRCode - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    /*
     * Informações Gerais do Cliente Serviço
     * Retorna Dados da Brigada (Escalas e Rondas)
     */
    public function qrcode_brigada_informacoes($id)
    {
        try {
            //Array
            $registro = array();

            //Cliente Serviço
            $registro['cliente_servico'] = $this->cliente_servico
                ->leftJoin('clientes', 'clientes.id', '=', 'clientes_servicos.cliente_id')
                ->leftJoin('funcionarios', 'funcionarios.id', '=', 'clientes_servicos.responsavel_funcionario_id')
                ->leftJoin('servicos', 'servicos.id', '=', 'clientes_servicos.servico_id')
                ->leftJoin('brigadas', 'brigadas.cliente_servico_id', '=', 'clientes_servicos.id')
                ->leftJoin('servico_status', 'servico_status.id', '=', 'clientes_servicos.servico_status_id')
                ->leftJoin('escala_tipos', 'escala_tipos.id', '=', 'clientes_servicos.bi_escala_tipo_id')
                ->select(['clientes_servicos.*', 'clientes.name as clienteName', 'funcionarios.name as funcionarioName', 'servicos.servico_tipo_id', 'servicos.name as servicoName', 'brigadas.id as brigada_id', 'servico_status.name as servicoStatusName', 'escala_tipos.name as escalaTipoName'])
                ->where('clientes_servicos.id', $id)
                ->get();

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Brigadistas
                $registro['brigadistas'] = ClienteServicoBrigadista::where('cliente_servico_id', '=', $id)->orderby('ala')->get();

                //Escalas
                $registro['escalas'] = BrigadaEscala
                    ::leftjoin('funcionarios', 'brigadas_escalas.funcionario_id', 'funcionarios.id')
                    ->leftjoin('escala_frequencias', 'escala_frequencias.id', 'brigadas_escalas.escala_frequencia_id')
                    ->select('brigadas_escalas.*', 'funcionarios.foto', 'escala_frequencias.name as escalaFrequenciaName')
                    ->where('brigadas_escalas.brigada_id', '=', $registro['cliente_servico'][0]['brigada_id'])
                    ->get();

                //Rondas
                $registro['rondas'] = BrigadaRonda::all();


                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    /*
     * Brigada Escalas
     * Retorna Dados da Brigada (Escalas) conforme Data atual
     * Para o Brigadista Iniciar e Encerrar o Serviço
     */
    public function qrcode_brigada_escalas($id)
    {
        try {
            //Array
            $registro = array();

            //Cliente Serviço
            $registro['cliente_servico'] = $this->cliente_servico
                ->leftJoin('clientes', 'clientes.id', '=', 'clientes_servicos.cliente_id')
                ->leftJoin('funcionarios', 'funcionarios.id', '=', 'clientes_servicos.responsavel_funcionario_id')
                ->leftJoin('servicos', 'servicos.id', '=', 'clientes_servicos.servico_id')
                ->leftJoin('brigadas', 'brigadas.cliente_servico_id', '=', 'clientes_servicos.id')
                ->leftJoin('servico_status', 'servico_status.id', '=', 'clientes_servicos.servico_status_id')
                ->leftJoin('escala_tipos', 'escala_tipos.id', '=', 'clientes_servicos.bi_escala_tipo_id')
                ->select(['clientes_servicos.*', 'clientes.name as clienteName', 'funcionarios.name as funcionarioName', 'servicos.servico_tipo_id', 'servicos.name as servicoName', 'brigadas.id as brigada_id', 'servico_status.name as servicoStatusName', 'escala_tipos.name as escalaTipoName'])
                ->where('clientes_servicos.id', $id)
                ->get();

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Condição para data da Escala que vai apresentar na tela'''''''''''''''''''''''''''''''''''''''''''''''
                /*
                 * Se a hora atual for entre 23:00 e 23:59 traz registros do próximo dia.
                 * Se não, trás os registros do dia atual.
                 */

                $data = date('Y-m-d');
                $hora = date('H:i:s');

                if ($hora > '23:00:00' and $hora < '23:59:00') {
                    $data = date('Y-m-d', strtotime("+1 days",strtotime($data)));
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Escalas
                $registro['escalas'] = BrigadaEscala
                    ::leftjoin('funcionarios', 'brigadas_escalas.funcionario_id', 'funcionarios.id')
                    ->leftjoin('users', 'users.funcionario_id', 'funcionarios.id')
                    ->leftjoin('escala_frequencias', 'escala_frequencias.id', 'brigadas_escalas.escala_frequencia_id')
                    ->select('brigadas_escalas.*', 'funcionarios.foto as funcionarioFoto', 'users.email as usuarioEmail', 'escala_frequencias.name as escalaFrequenciaName')
                    ->where('brigadas_escalas.brigada_id', '=', $registro['cliente_servico'][0]['brigada_id'])
                    ->where('brigadas_escalas.data_chegada', '=', $data)
                    ->get();

                //Rondas
                $ids = array();

                foreach ($registro['escalas'] as $escala) {
                    $ids[] = $escala['id'];
                }

                $registro['rondas'] = BrigadaRonda
                    ::whereIn('brigadas_rondas.brigada_escala_id', $ids)
                    ->get();

                //Return
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    /*
     * Brigada Escalas
     * Grava dados de Chegada, Rondas e Saída
     */
    public function qrcode_brigada_escala_operacao_salvar(Request $request, $brigada_escala_id)
    {
        //Verificando se dados do Usuário conferem
        $user = DB::table('users')->where('email', $request['email'])->get();

        if ($user->count() == 1) {
            //Verificando Password
            if (Hash::check($request['password'], $user[0]->password)) {
                $brigada_escala = BrigadaEscala::find($brigada_escala_id);

                //Pegar user_id e empresa_id para usar nas transações'''''''''''''''''
                $user_id = $user[0]->id;
                $empresa_id = SuporteFacade::retornaEmpresaId(1, $brigada_escala_id);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                if (!$brigada_escala) {
                    return $this->sendResponse('Escala não encontrada.', 4060, null, null);
                } else {
                    //OPERAÇÃO: Iniciar Serviço
                    if ($request['brigada_escala_operacao'] == 1) {
                        //Acertos request
                        $request['escala_frequencia_id'] = 1;
                        $request['foto_chegada_real'] = $request['foto_real'];
                        $request['data_chegada_real'] = date('Y-m-d');
                        $request['hora_chegada_real'] = date('H:i:s');

                        //Log de Transações: Dados Anterior
                        $brigadaEscala = BrigadaEscala::where('id', $brigada_escala_id)->get()[0];
                        $dadosAnterior = array();
                        $dadosAnterior['brigada_escala_id'] = $brigadaEscala['id'];
                        $dadosAnterior['escala_frequencia_id'] = $brigadaEscala['escala_frequencia_id'];
                        $dadosAnterior['data_chegada_real'] = $brigadaEscala['data_chegada_real'];
                        $dadosAnterior['hora_chegada_real'] = $brigadaEscala['hora_chegada_real'];
                        $dadosAnterior['data_saida_real'] = $brigadaEscala['data_saida_real'];
                        $dadosAnterior['hora_saida_real'] = $brigadaEscala['hora_saida_real'];

                        //Log de Transações: Dados Atual
                        $dadosAtual = array();
                        $dadosAtual['brigada_escala_id'] = $brigadaEscala['id'];
                        $dadosAtual['escala_frequencia_id'] = $request['escala_frequencia_id'];
                        $dadosAtual['data_chegada_real'] = $request['data_chegada_real'];
                        $dadosAtual['hora_chegada_real'] = $request['hora_chegada_real'];
                        $dadosAtual['data_saida_real'] = $brigadaEscala['data_saida_real'];
                        $dadosAtual['hora_saida_real'] = $brigadaEscala['hora_saida_real'];

                        //Alterando registro
                        $brigada_escala->update($request->all());

                        //Log de Transações: Gravar Transação
                        Transacoes::transacaoRecord(5, 2, 'brigadas', $dadosAnterior, $dadosAtual, $empresa_id, $user_id);
                    }

                    //OPERAÇÃO: Iniciar Ronda
                    if ($request['brigada_escala_operacao'] == 2) {
                        //Acertos request
                        $request['foto'] = $request['foto_real'];
                        $request['data_encerramento_ronda'] = date('Y-m-d');
                        $request['hora_encerramento_ronda'] = date('H:i:s');

                        //Alterando registro
                        $registro = BrigadaRonda::create($request->all());

                        //Log de Transações'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                        //gravar transacao
                        Transacoes::transacaoRecord(3, 1, 'brigadas', $request, $request, $empresa_id, $user_id);
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        //Gravar dados na tabela brigadas_rondas_seguranca_medidas''''''''''''''''''''''''''''''''''''''
                        $brigada_ronda_id = $registro['id'];

                        SuporteFacade::createRondaSegurancaMedidas($brigada_ronda_id, $request->all());



//                        $numero_pavimentos = 50;
//                        $ids_seguranca_medidas = array_unique($request['ids_seguranca_medidas']); //Retirando ids repetidos
//
//                        for($i=1; $i<=$numero_pavimentos; $i++) {
//                            foreach ($ids_seguranca_medidas as $seguranca_medida_id) {
//                                if (isset($request['seguranca_medida_id_' . $i . '_' . $seguranca_medida_id])) {
//                                    //Dados Atual
//                                    $dadosAtual = array();
//                                    $dadosAtual['brigada_ronda_id'] = $brigada_ronda_id;
//                                    $dadosAtual['pavimento'] = $i;
//                                    $dadosAtual['seguranca_medida_id'] = $seguranca_medida_id;
//                                    $dadosAtual['seguranca_medida_nome'] = $request['seguranca_medida_nome_' . $i . '_' . $seguranca_medida_id];
//                                    $dadosAtual['seguranca_medida_quantidade'] = $request['seguranca_medida_quantidade_' . $i . '_' . $seguranca_medida_id];
//                                    $dadosAtual['seguranca_medida_tipo'] = $request['seguranca_medida_tipo_' . $i . '_' . $seguranca_medida_id];
//                                    $dadosAtual['seguranca_medida_observacao'] = $request['seguranca_medida_observacao_' . $i . '_' . $seguranca_medida_id];
//                                    $dadosAtual['status'] = $request['status_' . $i . '_' . $seguranca_medida_id];
//                                    $dadosAtual['observacao'] = $request['observacao_' . $i . '_' . $seguranca_medida_id];
//
//                                    $brigada_ronda_seguranca_medida = BrigadaRondaSegurancaMedida::where('brigada_ronda_id', $brigada_ronda_id)->where('pavimento', $i)->where('seguranca_medida_id', $seguranca_medida_id)->get();
//
//                                    if ($brigada_ronda_seguranca_medida->count() == 1) {
//                                        BrigadaRondaSegurancaMedida::where('brigada_ronda_id', $brigada_ronda_id)->where('pavimento', $i)->where('seguranca_medida_id', $seguranca_medida_id)->update($dadosAtual);
//
//                                        //gravar transacao
//                                        Transacoes::transacaoRecord(4, 2, 'brigadas', $brigada_ronda_seguranca_medida[0], $dadosAtual);
//                                    } else {
//                                        BrigadaRondaSegurancaMedida::create($dadosAtual);
//
//                                        //gravar transacao
//                                        Transacoes::transacaoRecord(4, 1, 'brigadas', $dadosAtual, $dadosAtual);
//                                    }
//                                }
//                            }
//                        }





                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                    }

                    //OPERAÇÃO: Encerrar Serviço
                    if ($request['brigada_escala_operacao'] == 3) {
                        //Acertos request
                        $request['foto_saida_real'] = $request['foto_real'];
                        $request['data_saida_real'] = date('Y-m-d');
                        $request['hora_saida_real'] = date('H:i:s');

                        //Log de Transações: Dados Anterior
                        $brigadaEscala = BrigadaEscala::where('id', $brigada_escala_id)->get()[0];
                        $dadosAnterior = array();
                        $dadosAnterior['brigada_escala_id'] = $brigadaEscala['id'];
                        $dadosAnterior['escala_frequencia_id'] = $brigadaEscala['escala_frequencia_id'];
                        $dadosAnterior['data_chegada_real'] = $brigadaEscala['data_chegada_real'];
                        $dadosAnterior['hora_chegada_real'] = $brigadaEscala['hora_chegada_real'];
                        $dadosAnterior['data_saida_real'] = $brigadaEscala['data_saida_real'];
                        $dadosAnterior['hora_saida_real'] = $brigadaEscala['hora_saida_real'];

                        //Log de Transações: Dados Atual
                        $dadosAtual = array();
                        $dadosAtual['brigada_escala_id'] = $brigadaEscala['id'];
                        $dadosAtual['escala_frequencia_id'] = $brigadaEscala['escala_frequencia_id'];
                        $dadosAtual['data_chegada_real'] = $brigadaEscala['data_chegada_real'];
                        $dadosAtual['hora_chegada_real'] = $brigadaEscala['hora_chegada_real'];
                        $dadosAtual['data_saida_real'] = $request['data_saida_real'];
                        $dadosAtual['hora_saida_real'] = $request['hora_saida_real'];

                        //Alterando registro
                        $brigada_escala->update($request->all());

                        //Log de Transações: Gravar Transação
                        Transacoes::transacaoRecord(5, 2, 'brigadas', $dadosAnterior, $dadosAtual, $empresa_id, $user_id);
                    }

                    return $this->sendResponse('Escala atualizada com sucesso.', 2000, null, $brigada_escala);
                }
            } else {
                return $this->sendResponse('Senha não confere.', 4060, null, null);
            }
        } else {
            return $this->sendResponse('Usuário não encontrado.', 4060, null, null);
        }
    }
    //Eventos para QRCode - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Eventos para QRCode - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
