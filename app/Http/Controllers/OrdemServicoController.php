<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\OrdemServicoStoreRequest;
use App\Http\Requests\OrdemServicoUpdateRequest;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\FormaPagamento;
use App\Models\FormaPagamentoStatus;
use App\Models\Funcionario;
use App\Models\OrdemServicoDestino;
use App\Models\OrdemServicoEquipe;
use App\Models\OrdemServicoExecutivo;
use App\Models\OrdemServicoPrioridade;
use App\Models\OrdemServicoServico;
use App\Models\OrdemServicoStatus;
use App\Models\OrdemServicoTipo;
use App\Models\OrdemServicoVeiculo;
use App\Models\Servico;
use App\Models\Veiculo;
use Illuminate\Support\Facades\DB;
use App\Models\OrdemServico;

class OrdemServicoController extends Controller
{
    private $ordem_servico;

    public function __construct(OrdemServico $ordem_servico)
    {
        $this->ordem_servico = $ordem_servico;
    }

    public function index($empresa_id)
    {
        $registros = $this->ordem_servico
            ->leftJoin('ordem_servico_tipos', 'ordens_servicos.ordem_servico_tipo_id', '=', 'ordem_servico_tipos.id')
            ->leftJoin('clientes', 'ordens_servicos.cliente_id', '=', 'clientes.id')
            ->select(['ordens_servicos.*', 'ordem_servico_tipos.name as ordemServicoTipoName', 'clientes.name as clienteName'])
            ->where('ordens_servicos.empresa_id', $empresa_id)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->ordem_servico
                ->leftJoin('ordem_servico_tipos', 'ordens_servicos.ordem_servico_tipo_id', '=', 'ordem_servico_tipos.id')
                ->leftJoin('ordem_servico_status', 'ordens_servicos.ordem_servico_status_id', '=', 'ordem_servico_status.id')
                ->leftJoin('ordem_servico_prioridades', 'ordens_servicos.ordem_servico_prioridade_id', '=', 'ordem_servico_prioridades.id')
                ->leftJoin('formas_pagamentos', 'ordens_servicos.forma_pagamento_id', '=', 'formas_pagamentos.id')
                ->leftJoin('formas_pagamentos_status', 'ordens_servicos.forma_pagamento_status_id', '=', 'formas_pagamentos_status.id')
                ->select(['ordens_servicos.*', 'ordem_servico_tipos.name as ordemServicoTipoName', 'ordem_servico_status.name as ordemServicoStatusName', 'ordem_servico_prioridades.name as ordemServicoPrioridadeName', 'formas_pagamentos.name as formaPagamentoName'])
                ->where('ordens_servicos.id', '=', $id)
                ->get()[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //buscar dados dos servicos para a ordem_servico
                $registro['ordem_servico_servicos'] = OrdemServicoServico::where('ordem_servico_id', '=', $id)->get();

                //buscar dados dos veiculos para a ordem_servico
                $registro['ordem_servico_veiculos'] = OrdemServicoVeiculo::where('ordem_servico_id', '=', $id)->get();

                //buscar dados dos executivos para a ordem_servico
                $registro['ordem_servico_executivos'] = OrdemServicoExecutivo::where('ordem_servico_id', '=', $id)->get();

                //buscar dados das equipes para a ordem_servico
                $registro['ordem_servico_equipes'] = OrdemServicoEquipe::where('ordem_servico_id', '=', $id)->get();

                //buscar dados dos destinos para a ordem_servico
                $registro['ordem_servico_destinos'] = OrdemServicoDestino::where('ordem_servico_id', '=', $id)->get();

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

            //Servicos
            $registros['servicos'] = Servico::where('empresa_id', '=', $empresa_id)->get();

            //Funcionários
            $funcionarios = Funcionario
                ::leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->select(['funcionarios.*', 'funcoes.name as funcaoName'])
                ->get();

            $registros['funcionarios'] = $funcionarios;

            //Ordens Serviços Prioridades
            $registros['ordem_servico_prioridades'] = OrdemServicoPrioridade::all();

            //Ordens Serviços Tipos
            $registros['ordem_servico_tipos'] = OrdemServicoTipo::all();

            //Ordens Serviços Status
            $registros['ordem_servico_status'] = OrdemServicoStatus::all();

            //Formas Pagamentos
            $registros['formas_pagamentos'] = FormaPagamento::all();

            //Formas Pagamentos Status
            $registros['formas_pagamentos_status'] = FormaPagamentoStatus::all();

            //Clientes Executivos
            $registros['clientes_executivos'] = ClienteExecutivo::all();

            //Veiculos
            $veiculos = Veiculo
                ::leftJoin('veiculo_marcas', 'veiculos.veiculo_marca_id', '=', 'veiculo_marcas.id')
                ->leftJoin('veiculo_modelos', 'veiculos.veiculo_modelo_id', '=', 'veiculo_modelos.id')
                ->leftJoin('veiculo_combustiveis', 'veiculos.veiculo_combustivel_id', '=', 'veiculo_combustiveis.id')
                ->leftJoin('veiculo_categorias', 'veiculos.veiculo_categoria_id', '=', 'veiculo_categorias.id')
                ->select(['veiculos.*', 'veiculo_marcas.name as veiculoMarcaName', 'veiculo_modelos.name as veiculoModeloName', 'veiculo_combustiveis.name as veiculoCombustivelName', 'veiculo_categorias.name as veiculoCategoriaName'])
                ->get();

            $registros['veiculos'] = $veiculos;

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(OrdemServicoStoreRequest $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Colocar empresa_id no Request
            $request['empresa_id'] = $empresa_id;

            //Acertos campos''''''''''''''''''''''''''''''''''''''''''''''''
            //ordem_servico_status_id
            $request['ordem_servico_status_id'] = 1;

            //numero_ordem_servico
            $reg = OrdemServico::latest()->first();
            if ($reg) {
                $request['numero_ordem_servico'] = $reg['numero_ordem_servico'] + 1;
            } else {
                $request['numero_ordem_servico'] = 1;
            }

            //data_abertura
            $request['data_abertura'] = date('d/m/Y');

            //hora_abertura
            $request['hora_abertura'] = date('H:i:s');

            //ano_ordem_servico
            $request['ano_ordem_servico'] = substr($request['data_abertura'], 6, 4);

            //data_prevista
            $request['data_prevista'] = $request['data_abertura'];

            //hora_prevista
            $request['hora_prevista'] = $request['hora_abertura'];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Incluindo registro
            $registro = $this->ordem_servico->create($request->all());

            //Editar dados na tabela ordens_servicos_servicos
            SuporteFacade::editOrdemServicoServico(1, $registro['id'], $request);

            //Editar dados na tabela ordens_servicos_destinos
            SuporteFacade::editOrdemServicoDestino(1, $registro['id'], $request);

            //Editar dados na tabela ordens_servicos_veiculos
            SuporteFacade::editOrdemServicoVeiculo(1, $registro['id'], $request);

            //Editar dados na tabela ordens_servicos_executivos
            SuporteFacade::editOrdemServicoExecutivo(1, $registro['id'], $request);

            //Editar dados na tabela ordens_servicos_equipes
            SuporteFacade::editOrdemServicoEquipe(1, $registro['id'], $request);

            //Return
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(OrdemServicoUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->ordem_servico->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Alterando registro
                $registro->update($request->all());

                //Editar dados na tabela ordens_servicos_servicos
                SuporteFacade::editOrdemServicoServico(3, $registro['id'], $request);

                //Editar dados na tabela ordens_servicos_destinos
                SuporteFacade::editOrdemServicoDestino(3, $registro['id'], $request);

                //Editar dados na tabela ordens_servicos_veiculos
                SuporteFacade::editOrdemServicoVeiculo(3, $registro['id'], $request);

                //Editar dados na tabela ordens_servicos_executivos
                SuporteFacade::editOrdemServicoExecutivo(3, $registro['id'], $request);

                //Editar dados na tabela ordens_servicos_equipes
                SuporteFacade::editOrdemServicoEquipe(3, $registro['id'], $request);

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
            $registro = $this->ordem_servico->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Editar dados na tabela ordens_servicos_servicos
                SuporteFacade::editOrdemServicoServico(2, $registro['id'], '');

                //Editar dados na tabela ordens_servicos_destinos
                SuporteFacade::editOrdemServicoDestino(2, $registro['id'], '');

                //Editar dados na tabela ordens_servicos_veiculos
                SuporteFacade::editOrdemServicoVeiculo(2, $registro['id'], '');

                //Editar dados na tabela ordens_servicos_executivos
                SuporteFacade::editOrdemServicoExecutivo(2, $registro['id'], '');

                //Editar dados na tabela ordens_servicos_equipes
                SuporteFacade::editOrdemServicoEquipe(2, $registro['id'], '');

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
        $registros = $this->ordem_servico
            ->leftJoin('clientes', 'ordens_servicos.cliente_id', '=', 'clientes.id')
            ->select(['ordens_servicos.*', 'clientes.name as clienteName'])
            ->where('ordens_servicos.empresa_id', '=', $empresa_id)
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
