<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Models\BrigadaEscala;
use App\Models\BrigadaRonda;
use App\Models\BrigadaRondaSegurancaMedida;
use App\Models\ClienteSegurancaMedida;
use App\Models\ClienteServico;
use App\Models\Brigada;
use Illuminate\Http\Request;

class BrigadaController extends Controller
{
    private $brigada;

    public function __construct(Brigada $brigada)
    {
        $this->brigada = $brigada;
    }

    public function index()
    {
        //Registros para Grade
        $registros = ClienteServico
            ::Join('brigadas', 'clientes_servicos.id', '=', 'brigadas.cliente_servico_id')
            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
            ->select(['brigadas.id', 'clientes_servicos.data_inicio', 'clientes_servicos.data_fim', 'servicos.name as servicoName', 'clientes.name as clienteName', 'servico_status.name as servicoStatusName', 'funcionarios.name as funcionarioName'])
            ->where('servicos.servico_tipo_id', '=', 1)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            //Buscar Registro
            $registro = $this->brigada->find($id);

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

                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
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
        $registros = ClienteServico
            ::Join('brigadas', 'clientes_servicos.id', '=', 'brigadas.cliente_servico_id')
            ->leftJoin('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->leftJoin('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->leftJoin('servico_status', 'clientes_servicos.servico_status_id', '=', 'servico_status.id')
            ->leftJoin('funcionarios', 'clientes_servicos.responsavel_funcionario_id', '=', 'funcionarios.id')
            ->select(['brigadas.id', 'clientes_servicos.data_inicio', 'servicos.name as servicoName', 'clientes.name as clienteName', 'servico_status.name as servicoStatusName', 'funcionarios.name as funcionarioName'])
            ->where('servicos.servico_tipo_id', '=', 1)
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

    //Escalas e Rondas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Escalas e Rondas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function escalas($brigada_id, $es_periodo_data_1, $es_periodo_data_2)
    {
        try {
            //Rodar um Serviço para alterar escala_frequencia_id (ATRASO/FALTOU)
            SuporteFacade::updateEscalaFrequenciaId();

            //Registros
            $registros = array();

            //Escalas
            $registros['escalas'] = BrigadaEscala
                ::leftjoin('funcionarios', 'brigadas_escalas.funcionario_id', 'funcionarios.id')
                ->select('brigadas_escalas.*', 'funcionarios.foto')
                ->where('brigadas_escalas.brigada_id', '=', $brigada_id)
                ->where('brigadas_escalas.data_chegada', '>=', $es_periodo_data_1)
                ->where('brigadas_escalas.data_chegada', '<=', $es_periodo_data_2)
                ->get();

            //Rondas
            $registros['rondas'] = BrigadaRonda::all();

            return $this->sendResponse('Registros enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function ronda_cliente_seguranca_medidas($op, $brigada_escala_id, $brigada_ronda_id)
    {
        try {
            //Retornando dados para Execução da Ronda (tabela: clientes_seguranca_medidas)
            if ($op == 1) {
                //Pegar cliente_id
                $brigada_escala = BrigadaEscala::find($brigada_escala_id);
                $cliente_id = $brigada_escala['cliente_id'];

                //Medidas Segurança
                $seguranca_medidas = ClienteSegurancaMedida
                    ::leftJoin('seguranca_medidas', 'clientes_seguranca_medidas.seguranca_medida_id', '=', 'seguranca_medidas.id')
                    ->select(['clientes_seguranca_medidas.*', 'seguranca_medidas.name as seguranca_medida_nome'])
                    ->where('clientes_seguranca_medidas.cliente_id', '=', $cliente_id)
                    ->orderBy('clientes_seguranca_medidas.pavimento')
                    ->orderBy('seguranca_medidas.name')
                    ->get();
            }

            //Retornando dados para Visualização da Ronda (tabela: brigadas_rondas_seguranca_medidas)
            if ($op == 2) {
                //Medidas Segurança
                $seguranca_medidas = BrigadaRondaSegurancaMedida
                    ::leftJoin('seguranca_medidas', 'brigadas_rondas_seguranca_medidas.seguranca_medida_id', '=', 'seguranca_medidas.id')
                    ->select(['brigadas_rondas_seguranca_medidas.*', 'seguranca_medidas.name as seguranca_medida_nome'])
                    ->where('brigadas_rondas_seguranca_medidas.brigada_ronda_id', '=', $brigada_ronda_id)
                    ->orderBy('brigadas_rondas_seguranca_medidas.pavimento')
                    ->orderBy('seguranca_medidas.name')
                    ->get();
            }

            return $this->sendResponse('Registros enviado com sucesso.', 2000, null, $seguranca_medidas);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
    //Escalas e Rondas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Escalas e Rondas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
