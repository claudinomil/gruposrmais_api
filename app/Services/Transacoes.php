<?php

namespace App\Services;

use App\Models\Banco;
use App\Models\Brigada;
use App\Models\BrigadaEscala;
use App\Models\BrigadaRonda;
use App\Models\Cliente;
use App\Models\ClienteServico;
use App\Models\ContratacaoTipo;
use App\Models\Departamento;
use App\Models\EdificacaoClassificacao;
use App\Models\Empresa;
use App\Models\EscalaFrequencia;
use App\Models\EscalaTipo;
use App\Models\Funcionario;
use App\Models\Genero;
use App\Models\Grupo;
use App\Models\IdentidadeOrgao;
use App\Models\EstadoCivil;
use App\Models\IncendioRisco;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Funcao;
use App\Models\Escolaridade;
use App\Models\Proposta;
use App\Models\PropostaServico;
use App\Models\SegurancaMedida;
use App\Models\Servico;
use App\Models\ServicoStatus;
use App\Models\ServicoTipo;
use App\Models\SistemaAcesso;
use App\Models\Situacao;
use App\Models\Estado;
use App\Models\Transacao;
use App\Models\User;

use App\Models\VisitaTecnica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transacoes
{
    public $abreSpan = "";
    public $fechaSpan = "";
    public $gravarAlteracao = false;

    public function retornaDado($op, $dadoAnterior, $dadoAtual, $etiqueta, $model, $modelCampoRetorno) {
        $retorno = '';

        //Verificando se os dois estão vazios
        if (($dadoAnterior == '') and ($dadoAtual == '')) {return $retorno;}

        //Verificando se são indefinidos
        //if (!$dadoAnterior or !$dadoAtual) {return $retorno;}

        //Comparando
        if ($dadoAnterior != $dadoAtual) {
            $this->abreSpan = "<font class='text-danger'>";
            $this->fechaSpan = "</font>";

            $this->gravarAlteracao = true;
        } else {
            $this->abreSpan = "";
            $this->fechaSpan = "";
        }

        //Opção para campos sem id's simples, com apenas um retorno
        if ($op == 1) {
            //Verificar se é uma data e converter para d/m/Y
            if (strlen($dadoAtual) == 10 and substr($dadoAtual, 4, 1) == '-' and substr($dadoAtual, 7, 1) == '-') {
                $dadoAtual = Carbon::createFromFormat('Y-m-d', $dadoAtual)->format('d/m/Y');
            }

            //Return
            $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $dadoAtual . "<br>";
        }

        //Opção para campos id's simples, com apenas um retorno
        if ($op == 2) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $search = $model::where('id', $dadoAtual)->get([$modelCampoRetorno]);
                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search[0][$modelCampoRetorno] . "<br>";
            }
        }

        //Opção para o campo cliente_servico_id
        if ($op == 3) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $cliente_servico = ClienteServico::where('id', $dadoAtual)->get()[0];

                $search_cliente_id = $cliente_servico['cliente_id'];
                $cliente = Cliente::where('id', $search_cliente_id)->get(['name'])[0];
                $search_cliente = $cliente['name'];

                $search_servico_id = $cliente_servico['servico_id'];
                $servico = Servico::where('id', $search_servico_id)->get(['name'])[0];
                $search_servico = $servico['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_servico . "<br>";
            }
        }

        //Opção para o campo proposta_id
        if ($op == 4) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $proposta = Proposta::where('id', $dadoAtual)->get()[0];
                $search_data_proposta = $proposta['data_proposta'];
                $search_numero_proposta = $proposta['numero_proposta'];

                $cliente = Cliente::where('id', $proposta['cliente_id'])->get(['name'])[0];
                $search_cliente = $cliente['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_data_proposta . "/" . $search_numero_proposta . "<br>";
            }
        }

        //Opção para o campo brigada_id
        if ($op == 5) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $brigada = Brigada::where('id', $dadoAtual)->get()[0];
                $search_cliente_servico_id = $brigada['cliente_servico_id'];

                $cliente_servico = ClienteServico::where('id', $search_cliente_servico_id)->get()[0];

                $search_cliente_id = $cliente_servico['cliente_id'];
                $cliente = Cliente::where('id', $search_cliente_id)->get(['name'])[0];
                $search_cliente = $cliente['name'];

                $search_servico_id = $cliente_servico['servico_id'];
                $servico = Servico::where('id', $search_servico_id)->get(['name'])[0];
                $search_servico = $servico['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_servico . "<br>";
            }
        }

        //Opção para o campo brigada_escala_id
        if ($op == 6) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $brigada_escala = BrigadaEscala::where('id', $dadoAtual)->get()[0];
                $search_brigada_id = $brigada_escala['brigada_id'];

                $search_dados_escala = '<br>'.'&nbsp;&nbsp;&nbsp;#Escala: '.$brigada_escala['escala_tipo_nome'].'<br>'.'&nbsp;&nbsp;&nbsp;#Chegada: '.$brigada_escala['data_chegada'].' '.$brigada_escala['hora_chegada'].'<br>'.'&nbsp;&nbsp;&nbsp;#Brigadista: '.$brigada_escala['funcionario_nome'].'<br>'.'&nbsp;&nbsp;&nbsp;#Ala '.$brigada_escala['ala'];

                $brigada = Brigada::where('id', $search_brigada_id)->get()[0];
                $search_cliente_servico_id = $brigada['cliente_servico_id'];

                $cliente_servico = ClienteServico::where('id', $search_cliente_servico_id)->get()[0];

                $search_cliente_id = $cliente_servico['cliente_id'];
                $cliente = Cliente::where('id', $search_cliente_id)->get(['name'])[0];
                $search_cliente = $cliente['name'];

                $search_servico_id = $cliente_servico['servico_id'];
                $servico = Servico::where('id', $search_servico_id)->get(['name'])[0];
                $search_servico = $servico['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_servico . "/" . $search_dados_escala . "<br>";
            }
        }

        //Opção para o campo brigada_ronda_id
        if ($op == 7) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $brigada_ronda = BrigadaRonda::where('id', $dadoAtual)->get()[0];
                $search_escala_id = $brigada_ronda['brigada_escala_id'];

                $brigada_escala = BrigadaEscala::where('id', $search_escala_id)->get()[0];
                $search_brigada_id = $brigada_escala['brigada_id'];

                $search_dados_escala = '##Escala: '.$brigada_escala['escala_tipo_nome'].' ##Chegada: '.$brigada_escala['data_chegada'].' '.$brigada_escala['hora_chegada'].' ##Brigadista: '.$brigada_escala['funcionario_nome'].' ##Ala '.$brigada_escala['ala'];

                $brigada = Brigada::where('id', $search_brigada_id)->get()[0];
                $search_cliente_servico_id = $brigada['cliente_servico_id'];

                $cliente_servico = ClienteServico::where('id', $search_cliente_servico_id)->get()[0];

                $search_cliente_id = $cliente_servico['cliente_id'];
                $cliente = Cliente::where('id', $search_cliente_id)->get(['name'])[0];
                $search_cliente = $cliente['name'];

                $search_servico_id = $cliente_servico['servico_id'];
                $servico = Servico::where('id', $search_servico_id)->get(['name'])[0];
                $search_servico = $servico['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_servico . "/" . $search_dados_escala . "<br>";
            }
        }

        //Opção para o campo visita_tecnica_id
        if ($op == 8) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $visita_tecnica = VisitaTecnica::where('id', $dadoAtual)->get()[0];
                $search_cliente_servico_id = $visita_tecnica['cliente_servico_id'];

                $cliente_servico = ClienteServico::where('id', $search_cliente_servico_id)->get()[0];

                $search_cliente_id = $cliente_servico['cliente_id'];
                $cliente = Cliente::where('id', $search_cliente_id)->get(['name'])[0];
                $search_cliente = $cliente['name'];

                $search_servico_id = $cliente_servico['servico_id'];
                $servico = Servico::where('id', $search_servico_id)->get(['name'])[0];
                $search_servico = $servico['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_servico . "<br>";
            }
        }

        return $retorno;
    }

    /*
     * Função para Gravar Transação
     *
     * @PARAM op=1 : Transação na tabela principal do Submódulo
     * @PARAM op=? : Transação em tabelas pivot ou outras tabelas referentes ao Submódulo
     */
    public function transacaoRecord($op=1, $operacao, $submodulo, $dadosAnterior, $dadosAtual, $userLoggedId='', $userLoggedEmpresaId='') {
        //Verificação do Usuário Logado
        $userVerificado = true;

        if ($userLoggedId == '' and $userLoggedEmpresaId == '') {
            if (Auth::check()) {
                $userLoggedId = Auth::user()->id;
                $userLoggedEmpresaId = Auth::user()->empresa_id;
            } else {
                $userVerificado = false;
            }
        }

        //Gravar transação
        if ($userVerificado) {
            //submodulo_id'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $data = DB::table('submodulos')->select(['id'])->where('prefix_route', $submodulo)->get()->toArray();

            $submodulo_id = $data[0]->id;
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //montar campo dados'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $dados = '';

            //grupos
            if ($submodulo_id == 1) {
                if ($op == 1) {
                    $dados .= '<b>:: Grupos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //users
            if ($submodulo_id == 2) {
                if ($op == 1) {
                    $dados .= '<b>:: Usuários</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['email'], $dadosAtual['email'], 'E-mail', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcionario_id'], $dadosAtual['funcionario_id'], 'Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['avatar'], $dadosAtual['avatar'], 'Avatar', '', '');
                }

                //Tabela users_configuracoes
                if ($op == 2) {
                    $dados .= '<b>:: Usuários Configurações</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['user_id'], $dadosAtual['user_id'], 'Usuário', User::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['grupo_id'], $dadosAtual['grupo_id'], 'Grupo', Grupo::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['situacao_id'], $dadosAtual['situacao_id'], 'Situação', Situacao::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['sistema_acesso_id'], $dadosAtual['sistema_acesso_id'], 'Sistema Acesso', SistemaAcesso::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['layout_mode'], $dadosAtual['layout_mode'], 'Layout Mode', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['layout_style'], $dadosAtual['layout_style'], 'Layout Style', '', '');
                }
            }

            //notificacoes
            if ($submodulo_id == 3) {
                if ($op == 1) {
                    $dados .= '<b>:: Notificações</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['date'], $dadosAtual['date'], 'Data', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['time'], $dadosAtual['time'], 'Hora', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['title'], $dadosAtual['title'], 'Título', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['notificacao'], $dadosAtual['notificacao'], 'Notificação', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['user_id'], $dadosAtual['user_id'], 'Usuário', User::class, 'name');
                }
            }

            //ferramentas
            if ($submodulo_id == 5) {
                if ($op == 1) {
                    $dados .= '<b>:: Ferramentas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao'], $dadosAtual['descricao'], 'Descrição', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['url'], $dadosAtual['url'], 'URL', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['icon'], $dadosAtual['icon'], 'Ícone', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['user_id'], $dadosAtual['user_id'], 'Usuário', User::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['viewing_order'], $dadosAtual['viewing_order'], 'Ordem Visualização', '', '');
                }
            }
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //bancos
            if ($submodulo_id == 6) {
                if ($op == 1) {
                    $dados .= '<b>:: Bancos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero'], $dadosAtual['numero'], 'Número', '', '');
                }
            }

            //departamentos
            if ($submodulo_id == 7) {
                if ($op == 1) {
                    $dados .= '<b>:: Departamentos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //estados_civis
            if ($submodulo_id == 8) {
                if ($op == 1) {
                    $dados .= '<b>:: Estados Civis</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //nacionalidades
            if ($submodulo_id == 9) {
                if ($op == 1) {
                    $dados .= '<b>:: Nacionalidades</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nation'], $dadosAtual['nation'], 'País', '', '');
                }
            }

            //escolaridades
            if ($submodulo_id == 10) {
                if ($op == 1) {
                    $dados .= '<b>:: Escolaridades</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //naturalidades
            if ($submodulo_id == 11) {
                if ($op == 1) {
                    $dados .= '<b>:: Naturalidades</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //generos
            if ($submodulo_id == 12) {
                if ($op == 1) {
                    $dados .= '<b>:: Gêneros</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //funcoes
            if ($submodulo_id == 13) {
                if ($op == 1) {
                    $dados .= '<b>:: Funções</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //funcionarios
            if ($submodulo_id == 14) {
                if ($op == 1) {
                    $dados .= '<b>:: Funcionários</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_nascimento'], $dadosAtual['data_nascimento'], 'Data Nascimento', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['contratacao_tipo_id'], $dadosAtual['contratacao_tipo_id'], 'Tipo Contratação', ContratacaoTipo::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['genero_id'], $dadosAtual['genero_id'], 'Gênero', Genero::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['estado_civil_id'], $dadosAtual['estado_civil_id'], 'Estado Civil', EstadoCivil::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['escolaridade_id'], $dadosAtual['escolaridade_id'], 'Escolaridade', Escolaridade::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['nacionalidade_id'], $dadosAtual['nacionalidade_id'], 'Nacionalidade', Nacionalidade::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['naturalidade_id'], $dadosAtual['naturalidade_id'], 'Naturalidade', Naturalidade::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pai'], $dadosAtual['pai'], 'Pai', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['mae'], $dadosAtual['mae'], 'Mãe', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['banco_id'], $dadosAtual['banco_id'], 'Banco', Banco::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['agencia'], $dadosAtual['agencia'], 'Agência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['conta'], $dadosAtual['conta'], 'Conta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['email'], $dadosAtual['email'], 'E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_1'], $dadosAtual['telefone_1'], 'Telefone 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_2'], $dadosAtual['telefone_2'], 'Telefone 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['celular_1'], $dadosAtual['celular_1'], 'Celular 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['celular_2'], $dadosAtual['celular_2'], 'Celular 2', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['departamento_id'], $dadosAtual['departamento_id'], 'Departamento', Departamento::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcao_id'], $dadosAtual['funcao_id'], 'Função', Funcao::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_admissao'], $dadosAtual['data_admissao'], 'Data Admissão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_demissao'], $dadosAtual['data_demissao'], 'Data Demissão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_cadastro'], $dadosAtual['data_cadastro'], 'Data Cadastro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_afastamento'], $dadosAtual['data_afastamento'], 'Data Afastamento', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['personal_identidade_orgao_id'], $dadosAtual['personal_identidade_orgao_id'], 'Identidade Pessoal (Órgão)', IdentidadeOrgao::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['personal_identidade_estado_id'], $dadosAtual['personal_identidade_estado_id'], 'Identidade Pessoal (Estado)', Estado::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['personal_identidade_numero'], $dadosAtual['personal_identidade_numero'], 'Identidade Pessoal (Número)', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['personal_identidade_data_emissao'], $dadosAtual['personal_identidade_data_emissao'], 'Identidade Pessoal (Emissão)', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['professional_identidade_orgao_id'], $dadosAtual['professional_identidade_orgao_id'], 'Identidade Profissional (Órgão)', IdentidadeOrgao::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['professional_identidade_estado_id'], $dadosAtual['professional_identidade_estado_id'], 'Identidade Profissional (Estado)', Estado::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['professional_identidade_numero'], $dadosAtual['professional_identidade_numero'], 'Identidade Profissional (Número)', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['professional_identidade_data_emissao'], $dadosAtual['professional_identidade_data_emissao'], 'Identidade Profissional (Emissão)', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cpf'], $dadosAtual['cpf'], 'CPF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pis'], $dadosAtual['pis'], 'PIS', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pasep'], $dadosAtual['pasep'], 'PASEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['carteira_trabalho'], $dadosAtual['carteira_trabalho'], 'Carteira Trabalho', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cep'], $dadosAtual['cep'], 'CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero'], $dadosAtual['numero'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['complemento'], $dadosAtual['complemento'], 'Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['logradouro'], $dadosAtual['logradouro'], 'Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bairro'], $dadosAtual['bairro'], 'Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['localidade'], $dadosAtual['localidade'], 'Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['uf'], $dadosAtual['uf'], 'UF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['foto'], $dadosAtual['foto'], 'Foto', '', '');
                }

                //Tabela funcionarios_documentos
                if ($op == 2) {
                    $dados .= '<b>:: Funcionários Documentos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcionario_id'], $dadosAtual['funcionario_id'], 'Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao'], $dadosAtual['descricao'], 'Descrição', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['caminho'], $dadosAtual['caminho'], 'Caminho', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_documento'], $dadosAtual['data_documento'], 'Data Documento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['aviso'], $dadosAtual['aviso'], 'Aviso', '', '');
                }

                //Tabela funcionarios (Upload Foto)
                if ($op == 3) {
                    $dados .= '<b>:: Funcionários</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['foto'], $dadosAtual['foto'], 'Foto', '', '');
                }
            }

            //identidade_orgaos
            if ($submodulo_id == 15) {
                if ($op == 1) {
                    $dados .= '<b>:: Identidade Órgãos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['sigla'], $dadosAtual['sigla'], 'Sigla', '', '');
                }
            }

            //clientes
            if ($submodulo_id == 16) {
                if ($op == 1) {
                    $dados .= '<b>:: Clientes</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['principal_cliente_id'], $dadosAtual['principal_cliente_id'], 'Cliente Principal', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['status'], $dadosAtual['status'], 'Status', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['tipo'], $dadosAtual['tipo'], 'Tipo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nome_fantasia'], $dadosAtual['nome_fantasia'], 'Nome Fantasia', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['inscricao_estadual'], $dadosAtual['inscricao_estadual'], 'Inscrição Estadual', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['inscricao_municipal'], $dadosAtual['inscricao_municipal'], 'Inscrição Municipal', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cpf'], $dadosAtual['cpf'], 'CPF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cnpj'], $dadosAtual['cnpj'], 'CNPJ', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['identidade_orgao_id'], $dadosAtual['identidade_orgao_id'], 'Identidade (Órgão)', IdentidadeOrgao::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['identidade_estado_id'], $dadosAtual['identidade_estado_id'], 'Identidade (Estado)', Estado::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['identidade_numero'], $dadosAtual['identidade_numero'], 'Identidade (Número)', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['identidade_data_emissao'], $dadosAtual['identidade_data_emissao'], 'Identidade (Emissão)', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['genero_id'], $dadosAtual['genero_id'], 'Gênero', Genero::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_nascimento'], $dadosAtual['data_nascimento'], 'Data Nascimento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cep'], $dadosAtual['cep'], 'CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero'], $dadosAtual['numero'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['complemento'], $dadosAtual['complemento'], 'Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['logradouro'], $dadosAtual['logradouro'], 'Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bairro'], $dadosAtual['bairro'], 'Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['localidade'], $dadosAtual['localidade'], 'Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['uf'], $dadosAtual['uf'], 'UF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cep_cobranca'], $dadosAtual['cep_cobranca'], 'CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_cobranca'], $dadosAtual['numero_cobranca'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['complemento_cobranca'], $dadosAtual['complemento_cobranca'], 'Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['logradouro_cobranca'], $dadosAtual['logradouro_cobranca'], 'Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bairro_cobranca'], $dadosAtual['bairro_cobranca'], 'Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['localidade_cobranca'], $dadosAtual['localidade_cobranca'], 'Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['uf_cobranca'], $dadosAtual['uf_cobranca'], 'UF', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['banco_id'], $dadosAtual['banco_id'], 'Banco', Banco::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['agencia'], $dadosAtual['agencia'], 'Agência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['conta'], $dadosAtual['conta'], 'Conta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['email'], $dadosAtual['email'], 'E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['site'], $dadosAtual['site'], 'Site', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_1'], $dadosAtual['telefone_1'], 'Telefone 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_2'], $dadosAtual['telefone_2'], 'Telefone 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['celular_1'], $dadosAtual['celular_1'], 'Celular 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['celular_2'], $dadosAtual['celular_2'], 'Celular 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_pavimentos'], $dadosAtual['numero_pavimentos'], 'Número Pavimentos', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['altura'], $dadosAtual['altura'], 'Altura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['area_total_construida'], $dadosAtual['area_total_construida'], 'Área Total Construida', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['lotacao'], $dadosAtual['lotacao'], 'Lotação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['carga_incendio'], $dadosAtual['carga_incendio'], 'Carga Incêndio', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['incendio_risco_id'], $dadosAtual['incendio_risco_id'], 'Incêndio Risco', IncendioRisco::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['edificacao_classificacao_id'], $dadosAtual['edificacao_classificacao_id'], 'Edificação Classificação', EdificacaoClassificacao::class, 'divisao');
                    $dados .= $this->retornaDado(1, $dadosAnterior['projeto_scip'], $dadosAtual['projeto_scip'], 'Projeto SCIP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['laudo_exigencias'], $dadosAtual['laudo_exigencias'], 'Laudo Exigências', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao'], $dadosAtual['certificado_aprovacao'], 'Certificado Aprovação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_simplificado'], $dadosAtual['certificado_aprovacao_simplificado'], 'Certificado Aprovação Simplificado', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_assistido'], $dadosAtual['certificado_aprovacao_assistido'], 'Certificado Aprovação Assistido', '', '');
                }

                //Tabela clientes_seguranca_medidas
                if ($op == 2) {
                    $dados .= '<b>:: Clientes Segurança Medidas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['pavimento'], $dadosAtual['pavimento'], 'Pavimento', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['seguranca_medida_id'], $dadosAtual['seguranca_medida_id'], 'Segurança Medida', SegurancaMedida::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade'], $dadosAtual['quantidade'], 'Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['tipo'], $dadosAtual['tipo'], 'Tipo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacao'], $dadosAtual['observacao'], 'Observação', '', '');
                }
            }

            //fornecedores
            if ($submodulo_id == 18) {
                if ($op == 1) {
                    $dados .= '<b>:: Fornecedores</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['status'], $dadosAtual['status'], 'Status', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['tipo'], $dadosAtual['tipo'], 'Tipo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nome_fantasia'], $dadosAtual['nome_fantasia'], 'Nome Fantasia', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['inscricao_estadual'], $dadosAtual['inscricao_estadual'], 'Inscrição Estadual', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['inscricao_municipal'], $dadosAtual['inscricao_municipal'], 'Inscrição Municipal', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cpf'], $dadosAtual['cpf'], 'CPF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cnpj'], $dadosAtual['cnpj'], 'CNPJ', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['identidade_orgao_id'], $dadosAtual['identidade_orgao_id'], 'Identidade (Órgão)', IdentidadeOrgao::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['identidade_estado_id'], $dadosAtual['identidade_estado_id'], 'Identidade (Estado)', Estado::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['identidade_numero'], $dadosAtual['identidade_numero'], 'Identidade (Número)', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['identidade_data_emissao'], $dadosAtual['identidade_data_emissao'], 'Identidade (Emissão)', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['genero_id'], $dadosAtual['genero_id'], 'Gênero', Genero::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_nascimento'], $dadosAtual['data_nascimento'], 'Data Nascimento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cep'], $dadosAtual['cep'], 'CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero'], $dadosAtual['numero'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['complemento'], $dadosAtual['complemento'], 'Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['logradouro'], $dadosAtual['logradouro'], 'Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bairro'], $dadosAtual['bairro'], 'Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['localidade'], $dadosAtual['localidade'], 'Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['uf'], $dadosAtual['uf'], 'UF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cep_cobranca'], $dadosAtual['cep_cobranca'], 'CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_cobranca'], $dadosAtual['numero_cobranca'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['complemento_cobranca'], $dadosAtual['complemento_cobranca'], 'Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['logradouro_cobranca'], $dadosAtual['logradouro_cobranca'], 'Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bairro_cobranca'], $dadosAtual['bairro_cobranca'], 'Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['localidade_cobranca'], $dadosAtual['localidade_cobranca'], 'Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['uf_cobranca'], $dadosAtual['uf_cobranca'], 'UF', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['banco_id'], $dadosAtual['banco_id'], 'Banco', Banco::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['agencia'], $dadosAtual['agencia'], 'Agência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['conta'], $dadosAtual['conta'], 'Conta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['email'], $dadosAtual['email'], 'E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['site'], $dadosAtual['site'], 'Site', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_1'], $dadosAtual['telefone_1'], 'Telefone 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_2'], $dadosAtual['telefone_2'], 'Telefone 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['celular_1'], $dadosAtual['celular_1'], 'Celular 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['celular_2'], $dadosAtual['celular_2'], 'Celular 2', '', '');
                }
            }

            //Serviços
            if ($submodulo_id == 20) {
                if ($op == 1) {
                    $dados .= '<b>:: Serviços</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['servico_tipo_id'], $dadosAtual['servico_tipo_id'], 'Serviço Tipo', ServicoTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor'], $dadosAtual['valor'], 'Valor', '', '');
                }
            }

            //Propostas
            if ($submodulo_id == 21) {
                if ($op == 1) {
                    $dados .= '<b>:: Propostas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_proposta'], $dadosAtual['data_proposta'], 'Data Proposta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_proposta'], $dadosAtual['numero_proposta'], 'Número Proposta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano_proposta'], $dadosAtual['ano_proposta'], 'Ano Proposta', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_nome'], $dadosAtual['cliente_nome'], 'Cliente Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['aos_cuidados'], $dadosAtual['aos_cuidados'], 'Aos Cuidados', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['texto_acima_tabela_servico'], $dadosAtual['texto_acima_tabela_servico'], 'Texto Acima Tabela Serviço', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['porcentagem_desconto'], $dadosAtual['porcentagem_desconto'], 'Porcentagem Desconto', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor_desconto'], $dadosAtual['valor_desconto'], 'Valor Desconto', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor_total'], $dadosAtual['valor_total'], 'Valor Total', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['forma_pagamento'], $dadosAtual['forma_pagamento'], 'Forma Pagamento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_1'], $dadosAtual['paragrafo_1'], 'Generalidade 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_2'], $dadosAtual['paragrafo_2'], 'Generalidade 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_3'], $dadosAtual['paragrafo_3'], 'Generalidade 3', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_4'], $dadosAtual['paragrafo_4'], 'Generalidade 4', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_5'], $dadosAtual['paragrafo_5'], 'Generalidade 5', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_6'], $dadosAtual['paragrafo_6'], 'Generalidade 6', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_7'], $dadosAtual['paragrafo_7'], 'Generalidade 7', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_8'], $dadosAtual['paragrafo_8'], 'Generalidade 8', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_9'], $dadosAtual['paragrafo_9'], 'Generalidade 9', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['paragrafo_10'], $dadosAtual['paragrafo_10'], 'Generalidade 10', '', '');
                }

                //Tabela propostas_servicos
                if ($op == 2) {
                    $dados .= '<b>:: Propostas Serviços</b>'.'<br><br>';
                    $dados .= $this->retornaDado(4, $dadosAnterior['proposta_id'], $dadosAtual['proposta_id'], 'Cliente/Data/Número', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['servico_id'], $dadosAtual['servico_id'], 'Serviço', Servico::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_item'], $dadosAtual['servico_item'], 'Serviço Item', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_nome'], $dadosAtual['servico_nome'], 'Serviço Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_valor'], $dadosAtual['servico_valor'], 'Serviço Valor', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_quantidade'], $dadosAtual['servico_quantidade'], 'Serviço Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_valor_total'], $dadosAtual['servico_valor_total'], 'Serviço Valor Total', '', '');
                }
            }

            //Visitas Técnicas
            if ($submodulo_id == 22) {
                if ($op == 1) {
                    $dados .= '<b>:: Visitas Técnicas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(3, $dadosAnterior['cliente_servico_id'], $dadosAtual['cliente_servico_id'], 'Cliente/Serviço', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_pavimentos'], $dadosAtual['numero_pavimentos'], 'Número Pavimentos', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['altura'], $dadosAtual['altura'], 'Altura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['area_total_construida'], $dadosAtual['area_total_construida'], 'Área Total Construida', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['lotacao'], $dadosAtual['lotacao'], 'Lotação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['carga_incendio'], $dadosAtual['carga_incendio'], 'Carga Incêndio', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['incendio_risco'], $dadosAtual['incendio_risco'], 'Incêndio Risco', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['grupo'], $dadosAtual['grupo'], 'Grupo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ocupacao_uso'], $dadosAtual['ocupacao_uso'], 'Ocupação Uso', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['divisao'], $dadosAtual['divisao'], 'Divisão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao'], $dadosAtual['descricao'], 'Descrição', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['definicao'], $dadosAtual['definicao'], 'Definição', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['projeto_scip'], $dadosAtual['projeto_scip'], 'Projeto SCIP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['projeto_scip_numero'], $dadosAtual['projeto_scip_numero'], 'Projeto SCIP Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['laudo_exigencias'], $dadosAtual['laudo_exigencias'], 'Laudo Exigências', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['laudo_exigencias_numero'], $dadosAtual['laudo_exigencias_numero'], 'Laudo Exigências Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['laudo_exigencias_data_emissao'], $dadosAtual['laudo_exigencias_data_emissao'], 'Laudo Exig~encias Data Emissão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['laudo_exigencias_data_vencimento'], $dadosAtual['laudo_exigencias_data_vencimento'], 'Laudo Exigências Data Vencimento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao'], $dadosAtual['certificado_aprovacao'], 'Certificado Aprovação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_numero'], $dadosAtual['certificado_aprovacao_numero'], 'Certificado Aprovação Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_simplificado'], $dadosAtual['certificado_aprovacao_simplificado'], 'Certificado Aprovação Simplificado', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_simplificado_numero'], $dadosAtual['certificado_aprovacao_simplificado_numero'], 'Certificado Aprovação Simplificado Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_assistido'], $dadosAtual['certificado_aprovacao_assistido'], 'Certificado Aprovação Assistido', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['certificado_aprovacao_assistido_numero'], $dadosAtual['certificado_aprovacao_assistido_numero'], 'Certificado Aprovação Assistido Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['executado_data'], $dadosAtual['executado_data'], 'Executado Data', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['executado_user_id'], $dadosAtual['executado_user_id'], 'Usuário', User::class, 'name');
                }

                //Tabela visitas_tecnicas_seguranca_medidas
                if ($op == 2) {
                    $dados .= '<b>:: Visitas Técnicas Segurança Medidas</b>' . '<br><br>';
                    $dados .= $this->retornaDado(8, $dadosAnterior['visita_tecnica_id'], $dadosAtual['visita_tecnica_id'], 'Visita Técnica', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pavimento'], $dadosAtual['pavimento'], 'Pavimento', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['seguranca_medida_id'], $dadosAtual['seguranca_medida_id'], 'Segurança Medida', SegurancaMedida::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_nome'], $dadosAtual['seguranca_medida_nome'], 'Segurança Medida Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_quantidade'], $dadosAtual['seguranca_medida_quantidade'], 'Segurança Medida Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_tipo'], $dadosAtual['seguranca_medida_tipo'], 'Segurança Medida Tipo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_observacao'], $dadosAtual['seguranca_medida_observacao'], 'Segurança Medida Observação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['status'], $dadosAtual['status'], 'Status', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacao'], $dadosAtual['observacao'], 'Observação', '', '');
                }
            }

            //Brigadas Incêndios
            if ($submodulo_id == 23) {
                if ($op == 1) {
                    $dados .= '<b>:: Brigadas Incêndios</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(3, $dadosAnterior['cliente_servico_id'], $dadosAtual['cliente_servico_id'], 'Cliente/Serviço', '', '');
                }

                //Tabela brigadas_escalas
                if ($op == 2) {
                    $dados .= '<b>:: Brigadas Incêndios Escalas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(5, $dadosAnterior['brigada_id'], $dadosAtual['brigada_id'], 'Brigada', Brigada::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_nome'], $dadosAtual['cliente_nome'], 'Cliente Nome', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['escala_tipo_id'], $dadosAtual['escala_tipo_id'], 'Escala Tipo', EscalaTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['escala_tipo_nome'], $dadosAtual['escala_tipo_nome'], 'Escala Tipo Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade_alas'], $dadosAtual['quantidade_alas'], 'Quantidade Alas', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade_brigadistas_por_ala'], $dadosAtual['quantidade_brigadistas_por_ala'], 'Quantidade Brigadistas por Ala', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade_brigadistas_total'], $dadosAtual['quantidade_brigadistas_total'], 'Quantidade Brigadistas Total', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_inicio_ala'], $dadosAtual['hora_inicio_ala'], 'Hora Inicio Ala', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_chegada'], $dadosAtual['data_chegada'], 'Data Chegada', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_chegada'], $dadosAtual['hora_chegada'], 'Hora Chegada', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_saida'], $dadosAtual['data_saida'], 'Data Saída', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_saida'], $dadosAtual['hora_saida'], 'Hora Saída', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcionario_id'], $dadosAtual['funcionario_id'], 'Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['funcionario_nome'], $dadosAtual['funcionario_nome'], 'Funcionário Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ala'], $dadosAtual['ala'], 'Ala', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['escala_frequencia_id'], $dadosAtual['escala_frequencia_id'], 'Escala Frequência', EscalaFrequencia::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_chegada_real'], $dadosAtual['data_chegada_real'], 'Data Chegada Real', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_chegada_real'], $dadosAtual['hora_chegada_real'], 'Hora Chegada Real', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_saida_real'], $dadosAtual['data_saida_real'], 'Data Saída Real', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_saida_real'], $dadosAtual['hora_saida_real'], 'Hora Saída Real', '', '');
                }

                //Tabela brigadas_rondas
                if ($op == 3) {
                    $dados .= '<b>:: Brigadas Incêndios Escalas (Ronda)</b>'.'<br><br>';
                    $dados .= $this->retornaDado(6, $dadosAnterior['brigada_escala_id'], $dadosAtual['brigada_escala_id'], 'Brigada', Brigada::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_inicio_ronda'], $dadosAtual['data_inicio_ronda'], 'Data Início Ronda', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_inicio_ronda'], $dadosAtual['hora_inicio_ronda'], 'Hora Início Ronda', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_encerramento_ronda'], $dadosAtual['data_encerramento_ronda'], 'Data Encerramento Ronda', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_encerramento_ronda'], $dadosAtual['hora_encerramento_ronda'], 'Hora Encerramento Ronda', '', '');
                }

                //Tabela brigadas_rondas_seguranca_medidas
                if ($op == 4) {
                    $dados .= '<b>:: Brigadas Incêndios Escalas (Ronda Segurança Medidas)</b>' . '<br><br>';
                    $dados .= $this->retornaDado(7, $dadosAnterior['brigada_ronda_id'], $dadosAtual['brigada_ronda_id'], 'Brigada', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pavimento'], $dadosAtual['pavimento'], 'Pavimento', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['seguranca_medida_id'], $dadosAtual['seguranca_medida_id'], 'Segurança Medida', SegurancaMedida::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_nome'], $dadosAtual['seguranca_medida_nome'], 'Segurança Medida Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_quantidade'], $dadosAtual['seguranca_medida_quantidade'], 'Segurança Medida Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_tipo'], $dadosAtual['seguranca_medida_tipo'], 'Segurança Medida Tipo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['seguranca_medida_observacao'], $dadosAtual['seguranca_medida_observacao'], 'Segurança Medida Observação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['status'], $dadosAtual['status'], 'Status', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacao'], $dadosAtual['observacao'], 'Observação', '', '');
                }

                //Tabela brigadas_escalas (frequencia)
                if ($op == 5) {
                    $dados .= '<b>:: Brigadas Incêndios Escalas (Frequência)</b>'.'<br><br>';
                    $dados .= $this->retornaDado(6, $dadosAnterior['brigada_escala_id'], $dadosAtual['brigada_escala_id'], 'Brigada', Brigada::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['escala_frequencia_id'], $dadosAtual['escala_frequencia_id'], 'Escala Frequência', EscalaFrequencia::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_chegada_real'], $dadosAtual['data_chegada_real'], 'Data Chegada Real', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_chegada_real'], $dadosAtual['hora_chegada_real'], 'Hora Chegada Real', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_saida_real'], $dadosAtual['data_saida_real'], 'Data Saída Real', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_saida_real'], $dadosAtual['hora_saida_real'], 'Hora Saída Real', '', '');
                }
            }

            //empresas
            if ($submodulo_id == 24) {
                if ($op == 1) {
                    $dados .= '<b>:: Empresas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //Clientes Servicos
            if ($submodulo_id == 25) {
                if ($op == 1) {
                    $dados .= '<b>:: Clientes Serviços</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['servico_id'], $dadosAtual['servico_id'], 'Serviço', Servico::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['servico_status_id'], $dadosAtual['servico_status_id'], 'Serviço Status', ServicoStatus::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['responsavel_funcionario_id'], $dadosAtual['responsavel_funcionario_id'], 'Responsável Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade'], $dadosAtual['quantidade'], 'Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_inicio'], $dadosAtual['data_inicio'], 'Data Início', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_fim'], $dadosAtual['data_fim'], 'Data Fim', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_vencimento'], $dadosAtual['data_vencimento'], 'Data Vencimento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor'], $dadosAtual['valor'], 'Valor', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['bi_escala_tipo_id'], $dadosAtual['bi_escala_tipo_id'], 'Escala Tipo', EscalaTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bi_quantidade_alas_escala'], $dadosAtual['bi_quantidade_alas_escala'], 'Quantidade Alas Escala', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bi_quantidade_brigadistas_por_ala'], $dadosAtual['bi_quantidade_brigadistas_por_ala'], 'Quantidade Brigadistas por Ala', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bi_quantidade_brigadistas_total'], $dadosAtual['bi_quantidade_brigadistas_total'], 'Quantidade Brigadistas Total', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bi_hora_inicio_ala'], $dadosAtual['bi_hora_inicio_ala'], 'Hora Início Ala', '', '');
                }

                //Tabela clientes_servicos_brigadistas
                if ($op == 2) {
                    $dados .= '<b>:: Clientes Serviços Brigadistas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(3, $dadosAnterior['cliente_servico_id'], $dadosAtual['cliente_servico_id'], 'Cliente/Serviço', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcionario_id'], $dadosAtual['funcionario_id'], 'Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['funcionario_nome'], $dadosAtual['funcionario_nome'], 'Funcionário Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ala'], $dadosAtual['ala'], 'Ala', '', '');
                }
            }

            //Verificando se é uma alteração e pode gravar (caso nenhum campo tenha sido alterado não deixar gravar)''''
            if ($operacao == 2 and $this->gravarAlteracao === false) {
                $dados = '';
            } else {
                $this->gravarAlteracao = false;
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //gravar transacao''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($dados != '') {
                $trasaction = Array();

                $trasaction['empresa_id'] = $userLoggedEmpresaId;
                $trasaction['date'] = date('Y-m-d');
                $trasaction['time'] = date('H:i:s');
                $trasaction['user_id'] = $userLoggedId;
                $trasaction['operacao_id'] = $operacao;
                $trasaction['submodulo_id'] = $submodulo_id;
                $trasaction['dados'] = $dados;

                Transacao::create($trasaction);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        }

        return true;
    }
}
