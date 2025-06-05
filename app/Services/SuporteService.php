<?php

namespace App\Services;

use App\API\ApiReturn;
use App\Facades\Transacoes;
use App\Models\Brigada;
use App\Models\BrigadaEscala;
use App\Models\BrigadaRonda;
use App\Models\BrigadaRondaSegurancaMedida;
use App\Models\Cliente;
use App\Models\ClienteSegurancaMedida;
use App\Models\ClienteServico;
use App\Models\ClienteServicoBrigadista;
use App\Models\EdificacaoClassificacao;
use App\Models\Empresa;
use App\Models\IncendioRisco;
use App\Models\OrdemServicoDestino;
use App\Models\OrdemServicoEquipe;
use App\Models\OrdemServicoExecutivo;
use App\Models\OrdemServicoServico;
use App\Models\OrdemServicoVeiculo;
use App\Models\PropostaServico;
use App\Models\SegurancaMedida;
use App\Models\Servico;
use App\Models\UserConfiguracao;
use App\Models\APAGARVT;
use App\Models\APAGARVTControllerSegurancaMedida;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuporteService
{
    /*
     * Incluir dados de configuração da Empresa do Usuário no objeto Auth::user
     */
    public function setUserLogged($empresa_id=1)
    {
        //Colocar dados do Usuário Logado na variável $user
        $user = Auth::user();

        //Buscar configurações do Usuário Logado conforme Empresa escolhida
        $configuracoes = UserConfiguracao
            ::leftjoin('empresas', 'empresas.id', 'users_configuracoes.empresa_id')
            ->select('users_configuracoes.*', 'empresas.name as empresa')
            ->where('users_configuracoes.user_id', '=', Auth::user()->id)
            ->where('users_configuracoes.empresa_id', '=', $empresa_id)
            ->get();

        if ($configuracoes->count() == 1) {
            $user->empresa_id = $configuracoes[0]['empresa_id'];
            $user->empresa = $configuracoes[0]['empresa'];
            $user->grupo_id = $configuracoes[0]['grupo_id'];
            $user->situacao_id = $configuracoes[0]['situacao_id'];
            $user->sistema_acesso_id = $configuracoes[0]['sistema_acesso_id'];
            $user->layout_mode = $configuracoes[0]['layout_mode'];
            $user->layout_style = $configuracoes[0]['layout_style'];
        } else {
            $user->empresa_id = 0;
            $user->empresa = null;
            $user->grupo_id = 0;
            $user->situacao_id = 0;
            $user->sistema_acesso_id = 0;
            $user->layout_mode = 0;
            $user->layout_style = 0;
        }

        //Setar os dados de configurações do Usuário Logado
        Auth::setUser($user);
    }

    /*
     * Retorna empresa_id
     * De acordo com o id de uma tabela específica
     *
     * @PARAM op=1 : a partir do id da tabela brigadas_escalas
     */
    public function retornaEmpresaId($op, $id)
    {
        if ($op == 1) {
            return BrigadaEscala::join('brigadas', 'brigadas.id', 'brigadas_escalas.brigada_id')->where('brigadas_escalas.id', $id)->get()[0]['empresa_id'];
        }
    }

    /*
     * Verificar relacionamento em tabela
     * Retornar quantidade de registros
     */
    public function verificarRelacionamento($table, $field, $value)
    {
        $qtd = DB::table($table)->where($field, $value)->count();

        return $qtd;
    }

    /*
     * Editar dados na tabela cliente_servicos_brigadistas
     *
     * @PARAM op=1 : Incluir Brigadistas
     * @PARAM op=2 : Excluir Brigadistas (Todos)
     * @PARAM op=3 : Excluir Brigadistas (Todos) e Incluir Brigadistas
     */
    public function editClienteServicoBrigadistas($op, $cliente_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os Brigadistas
            $clienteServicoBrigadistas = ClienteServicoBrigadista::where('cliente_servico_id', $cliente_servico_id)->get();

            foreach ($clienteServicoBrigadistas as $clienteServicoBrigadista) {
                //Dados Anterior
                $dadosAnterior = $clienteServicoBrigadista;

                //Excluir
                ClienteServicoBrigadista::where('id', $clienteServicoBrigadista['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'clientes_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            //Qtd de Brigadistas
            $qtd_reg = count($request['bi_funcionario_id']);

            for ($i=0; $i<=$qtd_reg; $i++) {
                if (isset($request['bi_funcionario_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['cliente_servico_id'] = $cliente_servico_id;
                    $dadosAtual['funcionario_id'] = $request['bi_funcionario_id'][$i];
                    $dadosAtual['funcionario_nome'] = $request['bi_funcionario_nome'][$i];
                    $dadosAtual['ala'] = $request['bi_ala'][$i];

                    //Incluir
                    ClienteServicoBrigadista::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(2, 1, 'clientes_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Validar se pode alterar ou excluir registro na tabela clientes_servicos
     * As validações serão feitas de acordo com o servico_tipo_id (Brigadas, Visitas Técnicas)
     *
     * @PARAM op=1 : Operação de Update
     * @PARAM op=2 : Operação de Destroy
     */
    public function validarClienteServico($op, $cliente_servico_id)
    {
        //Cliente Serviço
        $cliente_servico = ClienteServico
            ::Join('servicos', 'servicos.id', '=', 'clientes_servicos.servico_id')
            ->select('clientes_servicos.servico_status_id', 'servicos.servico_tipo_id')
            ->where('clientes_servicos.id', $cliente_servico_id)
            ->get();

        //Dados
        $servico_status_id = $cliente_servico[0]['servico_status_id'];
        $servico_tipo_id = $cliente_servico[0]['servico_tipo_id'];

        //Validar servico_status_id (Se for "EXECUTADO" não deixar alterar/excluir)'''''''''''''''''''''''''''''''''''''
        if ($servico_status_id == 1) {return 'Operação não pode ser realizada.<br>Serviço já foi Executado.';}
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Tipo Serviço: BRIGADA DE INCÊNDIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if ($servico_tipo_id == 1) {
            //Validar Escalas já executadas
            $escalas_executadas = Brigada
                ::join('brigadas_escalas', 'brigadas_escalas.brigada_id', 'brigadas.id')
                ->where('brigadas.cliente_servico_id', $cliente_servico_id)
                ->where('brigadas_escalas.escala_frequencia_id', '!=', null)
                ->count();

            if ($escalas_executadas > 0) {return 'Operação não pode ser realizada.<br>Já existem Escalas executadas.';}

            //Validar Rondas já executadas
            $rondas_executadas = Brigada
                ::join('brigadas_escalas', 'brigadas_escalas.brigada_id', 'brigadas.id')
                ->join('brigadas_rondas', 'brigadas_rondas.brigada_escala_id', 'brigadas_escalas.id')
                ->where('brigadas.cliente_servico_id', $cliente_servico_id)
                ->count();

            if ($rondas_executadas > 0) {return 'Operação não pode ser realizada.<br>Já existem Rondas executadas.';}
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Tipo Serviço: MANUTENÇÃO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if ($servico_tipo_id == 2) {}
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Tipo Serviço: VISITA TÉCNICA''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if ($servico_tipo_id == 3) {}
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Validado com sucesso
        return false;
    }

    /*
     * Editar dados na tabela users_configuracoes
     */
    public function editUserConfiguracoes($user_id, $request)
    {
        //Buscar Empresas para percorrer
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            //Empresa Id
            $empresa_id = $empresa['id'];

            //Verificando se existe dados para a empresa (testando um campo qualquer. Ex.: grupo_id)
            if (isset($request['grupo_id_' . $empresa_id])) {
                //Dados Atual
                $dadosAtual = array();
                $dadosAtual['user_id'] = $user_id;
                $dadosAtual['empresa_id'] = $empresa_id;
                $dadosAtual['grupo_id'] = $request['grupo_id_' . $empresa_id];
                $dadosAtual['situacao_id'] = $request['situacao_id_' . $empresa_id];
                $dadosAtual['sistema_acesso_id'] = $request['sistema_acesso_id_' . $empresa_id];
                $dadosAtual['layout_mode'] = $request['layout_mode_' . $empresa_id];
                $dadosAtual['layout_style'] = $request['layout_style_' . $empresa_id];

                //Verificar se o Usuário já tem configuração para essa Empresa gravado no banco de dados
                $userConfiguracao = UserConfiguracao::where('user_id', $user_id)->where('empresa_id', $empresa_id)->get();

                //Variavel para controle de operação $operacao (1: incluir / 2: alterar / 3: excluir)
                $operacao = 1;

                //Verificar se dados recebidos estão ok
                if ($dadosAtual['grupo_id'] == '') {
                    $operacao = 3;
                } else {
                    //Se tem no banco (Mudar operação para alteração)
                    if ($userConfiguracao->count() == 1) {$operacao = 2;}

                    //Colocar dados padrões caso estejam vazios
                    if ($dadosAtual['situacao_id'] == '') {$dadosAtual['situacao_id'] = 2;}
                    if ($dadosAtual['sistema_acesso_id'] == '') {$dadosAtual['sistema_acesso_id'] = 1;}
                    if ($dadosAtual['layout_mode'] == '') {$dadosAtual['layout_mode'] = 'layout_mode_light';}
                    if ($dadosAtual['layout_style'] == '') {$dadosAtual['layout_style'] = 'layout_style_vertical_scrollable';}
                }

                //Se não tem no banco
                if ($userConfiguracao->count() == 0) {
                    //Se $operacao = 1
                    if ($operacao == 1) {
                        UserConfiguracao::create($dadosAtual);

                        //gravar transacao
                        Transacoes::transacaoRecord(2, 1, 'users', $dadosAtual, $dadosAtual);
                    }
                }

                //Se tem no banco
                if ($userConfiguracao->count() == 1) {
                    //Se $operacao = 2
                    if ($operacao == 2) {
                        UserConfiguracao::where('user_id', $user_id)->where('empresa_id', $empresa_id)->update($dadosAtual);

                        //gravar transacao
                        $dadosAnterior = $userConfiguracao[0];
                        Transacoes::transacaoRecord(2, 2, 'users', $dadosAnterior, $dadosAtual);
                    }

                    //Se $operacao = 3
                    if ($operacao == 3) {
                        UserConfiguracao::where('user_id', $user_id)->where('empresa_id', $empresa_id)->delete();

                        //gravar transacao
                        Transacoes::transacaoRecord(2, 3, 'users', $dadosAtual, $dadosAtual);
                    }
                }
            }
        }
    }

    /*
     * Editar dados na tabela clientes_seguranca_medidas
     *
     * @PARAM op=1 : Edição (verifica se é para Incluir, Alterar ou Excluir de acordo com os dados da Edificação)
     * @PARAM op=3 : Excluir (vai direto para Excluir todos os registros pertencentes ao Cliente)
     */
    public function editClienteSegurancaMedida($op, $cliente_id, $request)
    {
        //Editar
        if ($op == 1) {
            //Número de Pavimentos da Edificação (Colocar um valor hard code para poder executar a função corretamente)
            $numero_pavimentos = 50;

            //Buscar Segurança Medidas para percorrer
            $seguranca_medidas = SegurancaMedida::all();

            //Varrer os Pavimentos
            for($pavimento=1; $pavimento<=$numero_pavimentos; $pavimento++) {
                foreach ($seguranca_medidas as $seguranca_medida) {
                    //Segurança Medida Id
                    $seguranca_medida_id = $seguranca_medida['id'];

                    //Verificar se o Cliente já tem essa segurança medida para o Pavimento gravado no banco de dados
                    $clienteSegurancaMedida = ClienteSegurancaMedida::where('pavimento', $pavimento)->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $seguranca_medida_id)->get();

                    //Se tem no banco (Copiar como dados anterior)
                    if ($clienteSegurancaMedida->count() == 1) {
                        //Dados anterior (que está no banco de dados)
                        $dadosAnterior = $clienteSegurancaMedida[0];
                    }

                    //Verificando se existe dados para a empresa (testando um campo qualquer. Ex.: seguranca_medida_id)
                    if (isset($request['seguranca_medida_' . $pavimento . '_' . $seguranca_medida_id])) {
                        //Dados Atual
                        $dadosAtual = array();
                        $dadosAtual['pavimento'] = $pavimento;
                        $dadosAtual['cliente_id'] = $cliente_id;
                        $dadosAtual['seguranca_medida_id'] = $seguranca_medida_id;
                        $dadosAtual['quantidade'] = $request['quantidade_' . $pavimento . '_' . $seguranca_medida_id];
                        $dadosAtual['tipo'] = $request['tipo_' . $pavimento . '_' . $seguranca_medida_id];
                        $dadosAtual['observacao'] = $request['observacao_' . $pavimento . '_' . $seguranca_medida_id];

                        //Variavel para controle de operação $operacao (1: incluir / 2: alterar / 3: excluir)
                        $operacao = 0;

                        //Se não tem no banco (Mudar operação para inclusão)
                        if ($clienteSegurancaMedida->count() == 0) {$operacao = 1;}

                        //Se tem no banco (Mudar operação para alteração)
                        if ($clienteSegurancaMedida->count() == 1) {$operacao = 2;}

                        //Verificar se dados recebidos estão ok
                        if ($dadosAtual['pavimento'] == '') {$operacao = 0;}
                        if ($dadosAtual['cliente_id'] == '') {$operacao = 0;}
                        if ($dadosAtual['seguranca_medida_id'] == '') {$operacao = 0;}
                        if ($dadosAtual['quantidade'] == '') {$operacao = 0;}
                        if ($dadosAtual['tipo'] == '') {}
                        if ($dadosAtual['observacao'] == '') {}

                        //Se $operacao = 1
                        if ($operacao == 1) {
                            ClienteSegurancaMedida::create($dadosAtual);

                            //gravar transacao
                            Transacoes::transacaoRecord(2, 1, 'clientes', $dadosAtual, $dadosAtual);
                        }

                        //Se $operacao = 2
                        if ($operacao == 2) {
                            ClienteSegurancaMedida::where('pavimento', $pavimento)->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $seguranca_medida_id)->update($dadosAtual);

                            //gravar transacao
                            Transacoes::transacaoRecord(2, 2, 'clientes', $dadosAnterior, $dadosAtual);
                        }
                    } else {
                        //Se tem no banco e não tem no request (Mudar operação para exclusão)
                        if ($clienteSegurancaMedida->count() == 1) {
                            $operacao = 3;

                            //Se $operacao = 3
                            if ($operacao == 3) {
                                ClienteSegurancaMedida::where('pavimento', $pavimento)->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $seguranca_medida_id)->delete();

                                //gravar transacao
                                Transacoes::transacaoRecord(2, 3, 'clientes', $dadosAnterior, $dadosAnterior);
                            }
                        }
                    }
                }
            }
        }

        //Excluir
        if ($op == 3) {
            //Verificar as segurança medidas do Cliente
            $clienteSegurancaMedidas = ClienteSegurancaMedida::where('cliente_id', $cliente_id)->get();

            foreach ($clienteSegurancaMedidas as $clienteSegurancaMedida) {
                //Dados
                $dadosAnterior = $clienteSegurancaMedida;

                //Excluir
                ClienteSegurancaMedida::where('pavimento', $clienteSegurancaMedida['pavimento'])->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $clienteSegurancaMedida['seguranca_medida_id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'clientes', $dadosAnterior, $dadosAnterior);
            }
        }
    }

    /*
     * Editar dados na tabela propostas_servicos
     *
     * @PARAM op=1 : Incluir Serviços na Proposta
     * @PARAM op=2 : Excluir Serviços da Proposta (Todos)
     * @PARAM op=3 : Excluir Serviços da Proposta (Todos) e Incluir Serviços na Proposta
     */
    public function editPropostaServico($op, $proposta_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os servicos da proposta
            $propostaServicos = PropostaServico::where('proposta_id', $proposta_id)->get();

            foreach ($propostaServicos as $propostaServico) {
                //Dados Anterior
                $dadosAnterior = $propostaServico;

                //Excluir
                PropostaServico::where('id', $propostaServico['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'propostas', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['servico_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['proposta_id'] = $proposta_id;
                    $dadosAtual['servico_id'] = $request['servico_id'][$i];
                    $dadosAtual['servico_item'] = $request['servico_item'][$i];
                    $dadosAtual['servico_nome'] = $request['servico_nome'][$i];
                    $dadosAtual['servico_valor'] = $request['servico_valor'][$i];
                    $dadosAtual['servico_quantidade'] = $request['servico_quantidade'][$i];
                    $dadosAtual['servico_valor_total'] = $request['servico_valor_total'][$i];

                    //Incluir
                    PropostaServico::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(2, 1, 'propostas', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_servicos
     *
     * @PARAM op=1 : Incluir Serviços na Ordens Servicos
     * @PARAM op=2 : Excluir Serviços da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Serviços da Ordens Servicos (Todos) e Incluir Serviços na Ordens Servicos
     */
    public function editOrdemServicoServico($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os servicos da ordem_servico
            $ordemServicoServicos = OrdemServicoServico::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoServicos as $ordemServicoServico) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoServico;

                //Excluir
                OrdemServicoServico::where('id', $ordemServicoServico['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['servico_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['servico_id'] = $request['servico_id'][$i];
                    $dadosAtual['servico_item'] = $request['servico_item'][$i];
                    $dadosAtual['servico_nome'] = $request['servico_nome'][$i];
                    $dadosAtual['responsavel_funcionario_id'] = $request['responsavel_funcionario_id'][$i];
                    $dadosAtual['responsavel_funcionario_nome'] = $request['responsavel_funcionario_nome'][$i];

                    //Verificar ordem_servico_tipo_id
                    if ($request['ordem_servico_tipo_id'] == 1 or $request['ordem_servico_tipo_id'] == 2) {
                        $dadosAtual['servico_valor'] = $request['servico_valor'][$i];
                        $dadosAtual['servico_quantidade'] = $request['servico_quantidade'][$i];
                        $dadosAtual['servico_valor_total'] = $request['servico_valor_total'][$i];
                    } else if ($request['ordem_servico_tipo_id'] == 3) {
                        $dadosAtual['servico_valor'] = null;
                        $dadosAtual['servico_quantidade'] = null;
                        $dadosAtual['servico_valor_total'] = null;
                    }

                    //Incluir
                    OrdemServicoServico::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(2, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_veiculos
     *
     * @PARAM op=1 : Incluir Veículos na Ordens Servicos
     * @PARAM op=2 : Excluir Veículos da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Veículos da Ordens Servicos (Todos) e Incluir Veículos na Ordens Servicos
     */
    public function editOrdemServicoVeiculo($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os veiculos da ordem_servico
            $ordemServicoVeiculos = OrdemServicoVeiculo::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoVeiculos as $ordemServicoVeiculo) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoVeiculo;

                //Excluir
                OrdemServicoVeiculo::where('id', $ordemServicoVeiculo['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(3, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['veiculo_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['veiculo_id'] = $request['veiculo_id'][$i];
                    $dadosAtual['veiculo_item'] = $request['veiculo_item'][$i];
                    $dadosAtual['veiculo_marca'] = $request['veiculo_marca'][$i];
                    $dadosAtual['veiculo_modelo'] = $request['veiculo_modelo'][$i];
                    $dadosAtual['veiculo_placa'] = $request['veiculo_placa'][$i];
                    $dadosAtual['veiculo_combustivel'] = $request['veiculo_combustivel'][$i];

                    //Incluir
                    OrdemServicoVeiculo::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(3, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_executivos
     *
     * @PARAM op=1 : Incluir Executivos na Ordens Servicos
     * @PARAM op=2 : Excluir Executivos da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Executivos da Ordens Servicos (Todos) e Incluir Executivos na Ordens Servicos
     */
    public function editOrdemServicoExecutivo($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os executivos da ordem_servico
            $ordemServicoExecutivos = OrdemServicoExecutivo::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoExecutivos as $ordemServicoExecutivo) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoExecutivo;

                //Excluir
                OrdemServicoExecutivo::where('id', $ordemServicoExecutivo['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(4, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['cliente_executivo_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['cliente_executivo_id'] = $request['cliente_executivo_id'][$i];
                    $dadosAtual['cliente_executivo_item'] = $request['cliente_executivo_item'][$i];
                    $dadosAtual['cliente_executivo_nome'] = $request['cliente_executivo_nome'][$i];
                    $dadosAtual['cliente_executivo_funcao'] = $request['cliente_executivo_funcao'][$i];
                    $dadosAtual['cliente_executivo_veiculo_id'] = $request['cliente_executivo_veiculo_id'][$i];

                    //Incluir
                    OrdemServicoExecutivo::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(4, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }


    /*
     * Editar dados na tabela ordens_servicos_equipes
     *
     * @PARAM op=1 : Incluir Equipes na Ordens Servicos
     * @PARAM op=2 : Excluir Equipes da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Equipes da Ordens Servicos (Todos) e Incluir Equipes na Ordens Servicos
     */
    public function editOrdemServicoEquipe($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar as equipes da ordem_servico
            $ordemServicoEquipes = OrdemServicoEquipe::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoEquipes as $ordemServicoEquipe) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoEquipe;

                //Excluir
                OrdemServicoEquipe::where('id', $ordemServicoEquipe['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(6, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['equipe_funcionario_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['equipe_funcionario_id'] = $request['equipe_funcionario_id'][$i];
                    $dadosAtual['equipe_funcionario_item'] = $request['equipe_funcionario_item'][$i];
                    $dadosAtual['equipe_funcionario_nome'] = $request['equipe_funcionario_nome'][$i];
                    $dadosAtual['equipe_funcionario_funcao'] = $request['equipe_funcionario_funcao'][$i];
                    $dadosAtual['equipe_funcionario_veiculo_id'] = $request['equipe_funcionario_veiculo_id'][$i];

                    //Incluir
                    OrdemServicoEquipe::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(6, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_destinos
     *
     * @PARAM op=1 : Incluir Destinos na Ordens Servicos
     * @PARAM op=2 : Excluir Destinos da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Destinos da Ordens Servicos (Todos) e Incluir Destinos na Ordens Servicos
     */
    public function editOrdemServicoDestino($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os destinos da ordem_servico
            $ordemServicoDestinos = OrdemServicoDestino::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoDestinos as $ordemServicoDestino) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoDestino;

                //Excluir
                OrdemServicoDestino::where('id', $ordemServicoDestino['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(5, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['destino_ordem'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['destino_ordem'] = $request['destino_ordem'][$i];
                    $dadosAtual['destino_cep'] = $request['destino_cep'][$i];
                    $dadosAtual['destino_logradouro'] = $request['destino_logradouro'][$i];
                    $dadosAtual['destino_bairro'] = $request['destino_bairro'][$i];
                    $dadosAtual['destino_localidade'] = $request['destino_localidade'][$i];
                    $dadosAtual['destino_uf'] = $request['destino_uf'][$i];
                    $dadosAtual['destino_numero'] = $request['destino_numero'][$i];
                    $dadosAtual['destino_complemento'] = $request['destino_complemento'][$i];
                    $dadosAtual['destino_data_agendada'] = $request['destino_data_agendada_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_hora_agendada'] = $request['destino_hora_agendada_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_data_inicio'] = $request['destino_data_inicio_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_hora_inicio'] = $request['destino_hora_inicio_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_data_termino'] = $request['destino_data_termino_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_hora_termino'] = $request['destino_hora_termino_'.$request['destino_ordem'][$i]];

                    //Incluir
                    OrdemServicoDestino::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(5, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    //Brigadas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Brigadas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    /*
     * Criar Brigada ao criar um Serviço de Brigada para um cliente
     */
    public function createBrigada($cliente_servico_id, $empresa_id)
    {
        //Gravar Brigada
        $brigada = Brigada::create(
            [
                'empresa_id' => $empresa_id,
                'cliente_servico_id' => $cliente_servico_id
            ]
        );

        //Gravar Escalas
        $this->createBrigadaEscalas($brigada['id']);
    }

    /*
     * Alterar Brigada ao alterar um Serviço de Brigada para um cliente
     */
    public function updateBrigada($cliente_servico_id)
    {
        $brigada = Brigada::where('cliente_servico_id', $cliente_servico_id)->get();
        $brigada_id = $brigada[0]['id'];

        //Gravar Escalas
        $this->createBrigadaEscalas($brigada_id);
    }

    /*
     * Criar Escalas na tabela brigadas_escalas
    */
    public function createBrigadaEscalas($brigada_id)
    {
        $brigada = Brigada
            ::Join('clientes_servicos', 'brigadas.cliente_servico_id', '=', 'clientes_servicos.id')
            ->Join('servicos', 'clientes_servicos.servico_id', '=', 'servicos.id')
            ->Join('clientes', 'clientes_servicos.cliente_id', '=', 'clientes.id')
            ->Join('escala_tipos', 'clientes_servicos.bi_escala_tipo_id', '=', 'escala_tipos.id')
            ->select([
                'brigadas.cliente_servico_id',

                'clientes_servicos.cliente_id',
                'clientes_servicos.bi_escala_tipo_id',
                'clientes_servicos.bi_quantidade_alas_escala',
                'clientes_servicos.bi_quantidade_brigadistas_por_ala',
                'clientes_servicos.bi_quantidade_brigadistas_total',
                'clientes_servicos.bi_hora_inicio_ala',
                'clientes_servicos.data_inicio',
                'clientes_servicos.data_fim',

                'clientes.name as clienteName',
                'escala_tipos.quantidade_horas',
                'escala_tipos.name as escalaTipoName',
            ])
            ->where('brigadas.id', '=', $brigada_id)
            ->where('servicos.servico_tipo_id', '=', 1)
            ->where('clientes_servicos.servico_status_id', '!=', 1)
            ->get();

        if ($brigada->count() == 1) {
            //Array [0]
            $brigada = $brigada[0];

            //Dados da Brigada Incêndio
            $cliente_servico_id = $brigada['cliente_servico_id'];
            $cliente_id = $brigada['cliente_id'];
            $clienteName = $brigada['clienteName'];
            $escala_tipo_id = $brigada['bi_escala_tipo_id'];
            $escalaTipoName = $brigada['escalaTipoName'];
            $quantidade_alas = $brigada['bi_quantidade_alas_escala'];
            $quantidade_brigadistas_por_ala = $brigada['bi_quantidade_brigadistas_por_ala'];
            $quantidade_brigadistas_total = $brigada['bi_quantidade_brigadistas_total'];
            $hora_inicio_ala = $brigada['bi_hora_inicio_ala'];
            $data_inicio = $brigada['data_inicio'];
            $data_fim = $brigada['data_fim'];
            $quantidade_horas = $brigada['quantidade_horas'];

            //Datas / Horas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $data_chegada = $data_inicio;
            $hora_chegada = $hora_inicio_ala;

            $chegada = $data_chegada.' '.$hora_chegada;
            $saida = date('Y-m-d H:i:s', strtotime($chegada) + ($quantidade_horas *3600));

            $data_saida = substr($saida, 0,10);
            $hora_saida = substr($saida, 11);
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Apagando escalas''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $this->deleteBrigadaEscalas(2, $brigada_id);
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Criando escalas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            for($i=0; $i<=10000; $i++) {
                for ($ala = 1; $ala <= $quantidade_alas; $ala++) {
                    //Interromper fluxo de gravação
                    if ($data_fim < $data_chegada) {
                        $i = 999999999;
                        break;
                    }

                    //Brigadistas da Ala
                    $brigadistas = ClienteServicoBrigadista::where('cliente_servico_id', '=', $cliente_servico_id)->where('ala', '=', $ala)->get();

                    //Varrer Brigadistas da Ala e gravar na tabela
                    foreach ($brigadistas as $brigadista) {
                        //Dados Atual
                        $dadosAtual = array();
                        $dadosAtual['brigada_id'] = $brigada_id;
                        $dadosAtual['cliente_id'] = $cliente_id;
                        $dadosAtual['cliente_nome'] = $clienteName;
                        $dadosAtual['escala_tipo_id'] = $escala_tipo_id;
                        $dadosAtual['escala_tipo_nome'] = $escalaTipoName;
                        $dadosAtual['quantidade_alas'] = $quantidade_alas;
                        $dadosAtual['quantidade_brigadistas_por_ala'] = $quantidade_brigadistas_por_ala;
                        $dadosAtual['quantidade_brigadistas_total'] = $quantidade_brigadistas_total;
                        $dadosAtual['hora_inicio_ala'] = $hora_inicio_ala;
                        $dadosAtual['data_chegada'] = $data_chegada;
                        $dadosAtual['hora_chegada'] = $hora_chegada;
                        $dadosAtual['data_saida'] = $data_saida;
                        $dadosAtual['hora_saida'] = $hora_saida;
                        $dadosAtual['funcionario_id'] = $brigadista['funcionario_id'];
                        $dadosAtual['funcionario_nome'] = $brigadista['funcionario_nome'];
                        $dadosAtual['ala'] = $brigadista['ala'];
                        $dadosAtual['escala_frequencia_id'] = null;
                        $dadosAtual['data_chegada_real'] = null;
                        $dadosAtual['hora_chegada_real'] = null;
                        $dadosAtual['data_saida_real'] = null;
                        $dadosAtual['hora_saida_real'] = null;

                        //Gravar
                        BrigadaEscala::create($dadosAtual);

                        //gravar transacao
                        Transacoes::transacaoRecord(2, 1, 'brigadas', $dadosAtual, $dadosAtual);
                    }

                    //Datas / Horas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                    $data_chegada = $data_saida;
                    $hora_chegada = $hora_saida;

                    $chegada = $data_chegada.' '.$hora_chegada;
                    $saida = date('Y-m-d H:i:s', strtotime($chegada) + ($quantidade_horas *3600));

                    $data_saida = substr($saida, 0,10);
                    $hora_saida = substr($saida, 11);
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        }
    }

    /*
     * @PARAM op=1 e id=cliente_servico_id  :   Deletar registros nas tabelas: brigadas, brigadas_escalas, brigadas_rondas, brigadas_rondas_seguranca_medidas de acordo com o cliente_servico_id deletado
     * @PARAM op=2 e id=brigada_id          :   Deletar registros nas tabelas: brigadas_escalas, brigadas_rondas, brigadas_rondas_seguranca_medidas de acordo com o brigada_id deletado
     */
    public function deleteBrigadaEscalas($op, $id)
    {
        //Acerto conforme parametro recebido
        $cliente_servico_id = 0;
        $brigada_id = 0;

        if ($op == 1) {$cliente_servico_id = $id;}
        if ($op == 2) {$brigada_id = $id;}

        if ($cliente_servico_id != 0) {
            $brigada = Brigada::where('cliente_servico_id', $cliente_servico_id)->get();

            if ($brigada->count() == 1) {$brigada_id = $brigada[0]['id'];}
        }

        //Varrer Escalas
        $brigadaEscalas = BrigadaEscala::where('brigada_id', $brigada_id)->get();
        foreach ($brigadaEscalas as $brigadaEscala) {
            $brigada_escala_id = $brigadaEscala['id'];

            //Varrer Rondas
            $brigadaRondas = BrigadaRonda::where('brigada_escala_id', $brigada_escala_id)->get();
            foreach ($brigadaRondas as $brigadaRonda) {
                $brigada_ronda_id = $brigadaRonda['id'];

                //Deletar na tabela brigadas_rondas_seguranca_medidas
                BrigadaRondaSegurancaMedida::where('brigada_ronda_id', $brigada_ronda_id)->delete();

                //Deletar na tabela brigadas_rondas
                BrigadaRonda::find($brigada_ronda_id)->delete();

                //gravar transacao
                Transacoes::transacaoRecord(3, 3, 'brigadas', $brigadaRonda, $brigadaRonda);
            }

            //Deletar na tabela brigadas_escalas
            BrigadaEscala::find($brigada_escala_id)->delete();

            //gravar transacao
            Transacoes::transacaoRecord(2, 3, 'brigadas', $brigadaEscala, $brigadaEscala);
        }

        if ($op == 1) {
            if ($brigada_id != 0) {
                //Deletar na tabela brigadas
                Brigada::find($brigada_id)->delete();
            }
        }
    }

    /*
     * Incluir registros na tabela rondas_seguranca_medidas
     */
    public function createRondaSegurancaMedidas($brigada_ronda_id, $request)
    {
        $numero_pavimentos = 50;

        $seguranca_medidas = SegurancaMedida::all();

        for($i=1; $i<=$numero_pavimentos; $i++) {
            foreach ($seguranca_medidas as $seguranca_medida) {
                if (isset($request['seguranca_medida_id_' . $i . '_' . $seguranca_medida['id']])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['brigada_ronda_id'] = $brigada_ronda_id;
                    $dadosAtual['pavimento'] = $i;
                    $dadosAtual['seguranca_medida_id'] = $seguranca_medida['id'];
                    $dadosAtual['seguranca_medida_nome'] = $request['seguranca_medida_nome_' . $i . '_' . $seguranca_medida['id']];
                    $dadosAtual['seguranca_medida_quantidade'] = $request['seguranca_medida_quantidade_' . $i . '_' . $seguranca_medida['id']];
                    $dadosAtual['seguranca_medida_tipo'] = $request['seguranca_medida_tipo_' . $i . '_' . $seguranca_medida['id']];
                    //$dadosAtual['seguranca_medida_observacao'] = $request['seguranca_medida_observacao_' . $i . '_' . $seguranca_medida['id']];
                    $dadosAtual['status'] = $request['status_' . $i . '_' . $seguranca_medida['id']];
                    $dadosAtual['observacao'] = $request['observacao_' . $i . '_' . $seguranca_medida['id']];
                    $dadosAtual['foto'] = $request['foto_' . $i . '_' . $seguranca_medida['id']];

                    BrigadaRondaSegurancaMedida::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(4, 1, 'brigadas', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Varrer as Escalas para ver se existe ATRASO ou FALTA
     * Alterar campo escala_frequencia_id
    */
    public function updateEscalaFrequenciaId()
    {
        //Escalas com escala_frequencia_id NULL
        $escalas = BrigadaEscala::where('escala_frequencia_id', NULL)->orWhere('escala_frequencia_id', 2)->get();

        //Varrer Escalas
        foreach ($escalas as $escala) {
            $data_hora_atual = date('Y-m-d H:i:s');
            $data_hora_chegada_escala = Carbon::createFromFormat('d/m/Y', $escala['data_chegada'])->format('Y-m-d').' '.$escala['hora_chegada'];
            $data_hora_saida_escala = Carbon::createFromFormat('d/m/Y', $escala['data_saida'])->format('Y-m-d').' '.$escala['hora_saida'];

            $escala_frequencia_id = '';

            //ATRASO
            if (($data_hora_atual > $data_hora_chegada_escala) and ($data_hora_atual < $data_hora_saida_escala)) {
                $escala_frequencia_id = 2;
            }

            //FALTA
            if ($data_hora_atual > $data_hora_saida_escala) {
                $escala_frequencia_id = 3;
            }

            //Alterar o registro
            if ($escala_frequencia_id != '') {
                BrigadaEscala::where('id', $escala['id'])->update(['escala_frequencia_id' => $escala_frequencia_id]);
            }
        }
    }
    //Brigadas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Brigadas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    //Visitas Técnicas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Visitas Técnicas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''


//ESSE CODIGO COMENTADO ABAIXO É DA ANTIGA VISITA TECNICA DE INCENDIO

//    /*
//     * Criar Visita Técnica ao criar um Serviço de Visita Técnica para um cliente
//     */
//    public function createVisitaTecnica($cliente_servico_id, $empresa_id)
//    {
//        //Gravar Visita Técnica
//        $visita_tecnica = APAGARVT::create(
//            [
//                'empresa_id' => $empresa_id,
//                'cliente_servico_id' => $cliente_servico_id
//            ]
//        );
//
//        //Gravar dados vindos do Cliente
//        $this->updateVisitaTecnica($visita_tecnica['id']);
//    }
//
//    /*
//     * Atualizar registro na tabela visitas_tecnicas e visitas_tecnicas_seguranca_medidas com os dados vindos da tabela clientes
//     * Atualização não será feita em alguns Status do Serviço (id=1 : EXECUTADO)
//     */
//    public function updateVisitaTecnica($visita_tecnica_id)
//    {
//        $visita_tecnica = APAGARVT
//            ::Join('clientes_servicos', 'visitas_tecnicas.cliente_servico_id', '=', 'clientes_servicos.id')
//            ->select(['clientes_servicos.cliente_id'])
//            ->where('visitas_tecnicas.id', '=', $visita_tecnica_id)
//            ->where('clientes_servicos.servico_status_id', '!=', 1)
//            ->get();
//
//        if ($visita_tecnica->count() == 1) {
//            $cliente_id = $visita_tecnica[0]['cliente_id'];
//
//            //Buscando dados para incluir no registro de visita tecnica'''''''''''''''''''''''''''''''''''''''''''''''''
//            $dados = Cliente::find($cliente_id);
//
//            //Buscando Risco Incendio
//            if (isset($dados['incendio_risco_id']) and $dados['incendio_risco_id'] != '') {
//                $incendio_risco = IncendioRisco::where('id', '=', $dados['incendio_risco_id'])->get('name');
//                $dados['incendio_risco'] = $incendio_risco[0]['name'];
//            } else {
//                $dados['incendio_risco'] = '';
//            }
//
//            //Edificacao Classificacao
//            if (isset($dados['edificacao_classificacao_id']) and $dados['edificacao_classificacao_id'] != '') {
//                $edificacao_classificacao = EdificacaoClassificacao::where('id', '=', $dados['edificacao_classificacao_id'])->get();
//                $dados['grupo'] = $edificacao_classificacao[0]['grupo'];
//                $dados['ocupacao_uso'] = $edificacao_classificacao[0]['ocupacao_uso'];
//                $dados['divisao'] = $edificacao_classificacao[0]['divisao'];
//                $dados['descricao'] = $edificacao_classificacao[0]['descricao'];
//                $dados['definicao'] = $edificacao_classificacao[0]['definicao'];
//            } else {
//                $dados['grupo'] = '';
//                $dados['ocupacao_uso'] = '';
//                $dados['divisao'] = '';
//                $dados['descricao'] = '';
//                $dados['definicao'] = '';
//            }
//
//            //buscar dados das medidas de segurança
//            $cliente_seguranca_medidas = ClienteSegurancaMedida
//                ::leftJoin('seguranca_medidas', 'clientes_seguranca_medidas.seguranca_medida_id', '=', 'seguranca_medidas.id')
//                ->select(['clientes_seguranca_medidas.*', 'seguranca_medidas.name as seguranca_medida_nome'])
//                ->where('clientes_seguranca_medidas.cliente_id', '=', $cliente_id)
//                ->orderBy('clientes_seguranca_medidas.pavimento')
//                ->orderBy('seguranca_medidas.name')
//                ->get();
//            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//
//            //Salvando dados na tabela visitas_tecnicas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//            $data = array();
//
//            $data['id'] = $visita_tecnica_id;
//            $data['numero_pavimentos'] = $dados['numero_pavimentos'];
//            $data['altura'] = $dados['altura'];
//            $data['area_total_construida'] = $dados['area_total_construida'];
//            $data['lotacao'] = $dados['lotacao'];
//            $data['carga_incendio'] = $dados['carga_incendio'];
//            $data['incendio_risco'] = $dados['incendio_risco'];
//            $data['grupo'] = $dados['grupo'];
//            $data['divisao'] = $dados['divisao'];
//            $data['ocupacao_uso'] = $dados['ocupacao_uso'];
//            $data['descricao'] = $dados['descricao'];
//            $data['definicao'] = $dados['definicao'];
//            $data['projeto_scip'] = $dados['projeto_scip'];
//            $data['laudo_exigencias'] = $dados['laudo_exigencias'];
//            $data['certificado_aprovacao'] = $dados['certificado_aprovacao'];
//            $data['certificado_aprovacao_simplificado'] = $dados['certificado_aprovacao_simplificado'];
//            $data['certificado_aprovacao_assistido'] = $dados['certificado_aprovacao_assistido'];
//
//            APAGARVT::where('id', '=', $visita_tecnica_id)->update($data);
//            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//
//            //Salvando dados na tabela visitas_tecnicas_seguranca_medidas'''''''''''''''''''''''''''''''''''''''''''''''
//            //Deletando registros
//            APAGARVTControllerSegurancaMedida::where('visita_tecnica_id', $visita_tecnica_id)->delete();
//
//            foreach ($cliente_seguranca_medidas as $cliente_seguranca_medida) {
//                APAGARVTControllerSegurancaMedida::create(
//                    [
//                        'visita_tecnica_id' => $visita_tecnica_id,
//                        'pavimento' => $cliente_seguranca_medida['pavimento'],
//                        'seguranca_medida_id' => $cliente_seguranca_medida['seguranca_medida_id'],
//                        'seguranca_medida_nome' => $cliente_seguranca_medida['seguranca_medida_nome'],
//                        'seguranca_medida_quantidade' => $cliente_seguranca_medida['quantidade'],
//                        'seguranca_medida_tipo' => $cliente_seguranca_medida['tipo'],
//                        'seguranca_medida_observacao' => $cliente_seguranca_medida['observacao']
//                    ]
//                );
//            }
//            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//        }
//    }
//
//    /*
//     * Deletar registro na tabela visitas_tecnicas e visitas_tecnicas_seguranca_medidas de acordo com o cliente_servico_id deletado
//     */
//    public function deleteVisitaTecnica($cliente_servico_id)
//    {
//        //Buscar id da Visita Técnica
//        $visita_tecnica = APAGARVT::where('cliente_servico_id', $cliente_servico_id)->get()[0];
//        $visita_tecnica_id = $visita_tecnica['id'];
//
//        //Apagando registros na tabela visitas_tecnicas_seguranca_medidas
//        APAGARVTControllerSegurancaMedida::where('visita_tecnica_id', $visita_tecnica_id)->delete();
//
//        //Apagando registro na tabela visitas_tecnicas
//        APAGARVT::where('id', $visita_tecnica_id)->delete();
//    }
//
//    /*
//     * Atualizar visitas_tecnicas e visitas_tecnicas_seguranca_medidas de um determinado Cliente
//     * Atualização não será feita em alguns Status do Serviço (id=1 : EXECUTADO)
//     */
//    public function updateVisitaTecnicaCliente($cliente_id)
//    {
//        $visitas_tecnicas = APAGARVT
//            ::Join('clientes_servicos', 'visitas_tecnicas.cliente_servico_id', '=', 'clientes_servicos.id')
//            ->select(['visitas_tecnicas.id'])
//            ->where('clientes_servicos.cliente_id', '=', $cliente_id)
//            ->where('clientes_servicos.servico_status_id', '!=', 1)
//            ->get();
//
//        foreach ($visitas_tecnicas as $visita_tecnica) {
//            $visita_tecnica_id = $visita_tecnica['id'];
//
//            //Gravar dados vindos do Cliente
//            $this->updateVisitaTecnica($visita_tecnica_id);
//        }
//    }



    //Visitas Técnicas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Visitas Técnicas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    /*
     * Retornar data formatada
     * A) Recebe formatos de datas: 99/99/9999 ou 99-99-9999 ou 9999/99/99 ou 9999-99-99
     * B) Depois retorna essa data no formato pedido pelo usuário
     * @PARAM op=1 = recebe qualquer data e retorna 99/99/9999
     * @PARAM op=2 = recebe qualquer data e retorna 99-99-9999
     * @PARAM op=3 = recebe qualquer data e retorna 9999/99/99
     * @PARAM op=4 = recebe qualquer data e retorna 9999-99-99
     */
    public function getDataFormatada($op, $data)
    {
        //Variáveis para formatar o retorno
        $dia = '';
        $mes = '';
        $ano = '';

        //Verificando recebimento da data
        if ($data == '') {
            $data = null;
        } else {
            //Retirando espaços
            $data = trim($data);
            $data = str_replace(" ", "", $data);

            //Formato: 9999-99-99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '-' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '-' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 9999/99/99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '/' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '/' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 99-99-9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '-' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '-' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }

            //Formato: 99/99/9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '/' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '/' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }
        }

        //Retorno
        if ($dia == '' or $mes == '' or $ano == '' or $dia == '00' or $mes == '00' or $ano == '0000') {
            $data = null;
        } else {
            //Retorna no formato (99/99/9999)
            if ($op == 1) {$data = $dia.'/'.$mes.'/'.$ano;}

            //Retorna no formato (99-99-9999)
            if ($op == 2) {$data = $dia.'-'.$mes.'-'.$ano;}

            //Retorna no formato (9999/99/99)
            if ($op == 3) {$data = $ano.'/'.$mes.'/'.$dia;}

            //Retorna no formato (9999-99-99)
            if ($op == 4) {$data = $ano.'-'.$mes.'-'.$dia;}
        }

        return $data;
    }
}
