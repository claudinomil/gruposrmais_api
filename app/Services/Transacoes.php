<?php

namespace App\Services;

use App\Models\Banco;
use App\Models\BrigadaIncendio;
use App\Models\BrigadaIncendioEscala;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\ClienteServico;
use App\Models\ContratacaoTipo;
use App\Models\Cor;
use App\Models\Departamento;
use App\Models\EdificacaoClassificacao;
use App\Models\Empresa;
use App\Models\EscalaTipo;
use App\Models\FormaPagamento;
use App\Models\FormaPagamentoStatus;
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
use App\Models\OrdemServico;
use App\Models\OrdemServicoPrioridade;
use App\Models\OrdemServicoStatus;
use App\Models\OrdemServicoTipo;
use App\Models\PixTipo;
use App\Models\Proposta;
use App\Models\PropostaServico;
use App\Models\SegurancaMedida;
use App\Models\Servico;
use App\Models\ServicoStatus;
use App\Models\ServicoTipo;
use App\Models\SistemaAcesso;
use App\Models\Situacao;
use App\Models\Estado;
use App\Models\Estoque;
use App\Models\EstoqueLocal;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoEntrada;
use App\Models\ProdutoEntradaItem;
use App\Models\ProdutoTipo;
use App\Models\Transacao;
use App\Models\User;

use App\Models\Veiculo;
use App\Models\VeiculoCategoria;
use App\Models\VeiculoCombustivel;
use App\Models\VeiculoMarca;
use App\Models\VeiculoModelo;
use App\Models\VisitaTecnica;
use App\Models\VisitaTecnicaStatus;
use App\Models\VisitaTecnicaTipo;
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

        //Opção para o campo visita_tecnica_id
        if ($op == 8) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $visita_tecnica = VisitaTecnica::where('id', $dadoAtual)->get()[0];
                $search_numero_visita_tecnica = $visita_tecnica['numero_visita_tecnica'];
                $search_ano_visita_tecnica = $visita_tecnica['ano_visita_tecnica'];
                $search_visita_tecnica_tipo_id = $visita_tecnica['visita_tecnica_tipo_id'];

                $visita_tecnica_tipo = VisitaTecnicaTipo::where('id', $search_visita_tecnica_tipo_id)->get(['name'])[0];

                $search_tipo = $visita_tecnica_tipo['name'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_numero_visita_tecnica . "/" . $search_ano_visita_tecnica . "/" . $search_tipo . "<br>";
            }
        }

        //Opção para o campo ordem_servico_id
        if ($op == 9) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $ordem_servico = OrdemServico::where('id', $dadoAtual)->get()[0];
                $search_data_abertura_ordem_servico = $ordem_servico['data_abertura'];
                $search_numero_ordem_servico = $ordem_servico['numero_ordem_servico'];

                //Se não tiver cliente_id é porque foi escolhido ordem de serviço interna
                if ($ordem_servico['cliente_id'] == '') {
                    $cliente = Empresa::where('id', $ordem_servico['empresa_id'])->get(['name'])[0];
                    $search_cliente = $cliente['name'];
                } else {
                    $cliente = Cliente::where('id', $ordem_servico['cliente_id'])->get(['name'])[0];
                    $search_cliente = $cliente['name'];
                }

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_cliente . "/" . $search_data_abertura_ordem_servico . "/" . $search_numero_ordem_servico . "<br>";
            }
        }

        //Opção para o campo veiculo_id
        if ($op == 10) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $veiculo = Veiculo::where('id', $dadoAtual)->get()[0];

                $marca = VeiculoMarca::where('id', $veiculo['veiculo_marca_id'])->get(['name'])[0];
                $search_marca = $marca['name'];

                $modelo = VeiculoModelo::where('id', $veiculo['veiculo_modelo_id'])->get(['name'])[0];
                $search_modelo = $modelo['name'];

                $search_placa = $veiculo['placa'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_marca . "/" . $search_modelo . "/" . $search_placa . "<br>";
            }
        }

        //Opção para o campo brigada_incendio_id
        if ($op == 11) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $brigada_incendio = BrigadaIncendio::where('id', $dadoAtual)->get()[0];
                $search_numero_brigada_incendio = $brigada_incendio['numero_brigada_incendio'];
                $search_ano_brigada_incendio = $brigada_incendio['ano_brigada_incendio'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_numero_brigada_incendio . "/" . $search_ano_brigada_incendio . "<br>";
            }
        }

        //Opção para o campo brigada_incendio_escala_id
        if ($op == 12) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $brigada_incendio_escala = BrigadaIncendioEscala::where('id', $dadoAtual)->get()[0];
                $search_escala_tipo_name = $brigada_incendio_escala['escala_tipo_name'];
                $search_posto = $brigada_incendio_escala['posto'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_escala_tipo_name . " - " . $search_posto . "<br>";
            }
        }

        //Opção para o campo produto_entrada_id
        if ($op == 13) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $produto_entrada = ProdutoEntrada::where('id', $dadoAtual)->get()[0];
                $search_nf_numero_produto_entrada = $produto_entrada['nf_numero'];
                $search_nf_serie_produto_entrada = $produto_entrada['nf_serie'];

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search_nf_numero_produto_entrada . "/" . $search_nf_serie_produto_entrada . "<br>";
            }
        }

        // Opção para o campo origem_estoque_local_id
        if ($op == 14) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $estoque_local = EstoqueLocal::where('id', $dadoAtual)->get()[0];

                $estoque = Estoque::where('id', $estoque_local->estoque_id)->get()[0];

                $val_retorno = '';

                if ($estoque_local->estoque_id == 1) {
                    $empresa = Empresa::where('id', $estoque_local->empresa_id)->get()[0];

                    $val_retorno = $estoque_local->name.' - '.$estoque->name.' - '.$empresa->name;
                }

                if ($estoque_local->estoque_id == 2) {
                    $cliente = Cliente::where('id', $estoque_local->cliente_id)->get()[0];

                    $val_retorno = $estoque_local->name.' - '.$estoque->name.' - '.$cliente->name;
                }

                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $val_retorno . "<br>";
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
    public function transacaoRecord($op=1, $operacao, $submodulo, $dadosAnterior, $dadosAtual, $userLoggedId='') {
        //Verificação do Usuário Logado
        $userVerificado = true;

        if ($userLoggedId == '') {
            if (Auth::check()) {
                $userLoggedId = Auth::user()->id;
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
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //funcionarios
            if ($submodulo_id == 14) {
                if ($op == 1) {
                    $dados .= '<b>:: Funcionários</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['tomador_servico_cliente_id'], $dadosAtual['tomador_servico_cliente_id'], 'Tomador Serviço', Cliente::class, 'name');
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
                    $dados .= $this->retornaDado(2, $dadosAnterior['pix_tipo_id'], $dadosAtual['pix_tipo_id'], 'PIX Tipo', PixTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pix_chave'], $dadosAtual['pix_chave'], 'PIX Chave', '', '');
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
                    $dados .= $this->retornaDado(2, $dadosAnterior['carteira_nacional_orgao_id'], $dadosAtual['carteira_nacional_orgao_id'], 'Carteira Nacional (Órgão)', IdentidadeOrgao::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['carteira_nacional_estado_id'], $dadosAtual['carteira_nacional_estado_id'], 'Carteira Nacional (Estado)', Estado::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['carteira_nacional_numero'], $dadosAtual['carteira_nacional_numero'], 'Carteira Nacional (Número)', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['carteira_nacional_data_emissao'], $dadosAtual['carteira_nacional_data_emissao'], 'Carteira Nacional (Emissão)', '', '');
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
                    $dados .= $this->retornaDado(1, $dadosAnterior['fotografia_documento'], $dadosAtual['fotografia_documento'], 'Fotografia Documento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fotografia_cartao_emergencial'], $dadosAtual['fotografia_cartao_emergencial'], 'Fotografia Cartão Emergencial', '', '');
                }

                //Tabela funcionarios_documentos_mensais
                if ($op == 4) {
                    $dados .= '<b>:: Funcionários Documentos Mensais</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcionario_id'], $dadosAtual['funcionario_id'], 'Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['mes'], $dadosAtual['mes'], 'Mês', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano'], $dadosAtual['ano'], 'Ano', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['caminho'], $dadosAtual['caminho'], 'Caminho', '', '');
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
                    $dados .= $this->retornaDado(2, $dadosAnterior['principal_cliente_id'], $dadosAtual['principal_cliente_id'], 'Cliente Principal', Cliente::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['rede_cliente_id'], $dadosAtual['rede_cliente_id'], 'Cliente Rede', Cliente::class, 'name');
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

                //Tabela clientes_documentos
                if ($op == 3) {
                    $dados .= '<b>:: Funcionários Documentos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Funcionário', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['caminho'], $dadosAtual['caminho'], 'Caminho', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_documento'], $dadosAtual['data_documento'], 'Data Documento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['aviso'], $dadosAtual['aviso'], 'Aviso', '', '');
                }
            }

            //fornecedores
            if ($submodulo_id == 18) {
                if ($op == 1) {
                    $dados .= '<b>:: Fornecedores</b>'.'<br><br>';
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
                    $dados .= $this->retornaDado(2, $dadosAnterior['visita_tecnica_tipo_id'], $dadosAtual['visita_tecnica_tipo_id'], 'Tipo', VisitaTecnicaTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_visita_tecnica'], $dadosAtual['numero_visita_tecnica'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano_visita_tecnica'], $dadosAtual['ano_visita_tecnica'], 'Ano', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_abertura'], $dadosAtual['data_abertura'], 'Data Abertura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_abertura'], $dadosAtual['hora_abertura'], 'Hora Abertura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_prevista'], $dadosAtual['data_prevista'], 'Data Prevista', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_prevista'], $dadosAtual['hora_prevista'], 'Hora Prevista', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_conclusao'], $dadosAtual['data_conclusao'], 'Data Conclusão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_conclusao'], $dadosAtual['hora_conclusao'], 'Hora Conclusão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_finalizacao'], $dadosAtual['data_finalizacao'], 'Data Finalização', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_finalizacao'], $dadosAtual['hora_finalizacao'], 'Hora Finalização', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['visita_tecnica_status_id'], $dadosAtual['visita_tecnica_status_id'], 'Status', VisitaTecnicaStatus::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_nome'], $dadosAtual['cliente_nome'], 'Cliente Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_cnpj'], $dadosAtual['cliente_cnpj'], 'Cliente CNPJ', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_telefone'], $dadosAtual['cliente_telefone'], 'Cliente Telefone', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_celular'], $dadosAtual['cliente_celular'], 'Cliente Celular', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_email'], $dadosAtual['cliente_email'], 'Cliente E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_logradouro'], $dadosAtual['cliente_logradouro'], 'Cliente Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_logradouro_numero'], $dadosAtual['cliente_logradouro_numero'], 'Cliente Logradouro Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_logradouro_complemento'], $dadosAtual['cliente_logradouro_complemento'], 'Cliente Logradouro Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_bairro'], $dadosAtual['cliente_bairro'], 'Cliente Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_cidade'], $dadosAtual['cliente_cidade'], 'Cliente Cidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_uf'], $dadosAtual['cliente_uf'], 'Cliente UF', '', '');
                }

                //Tabela visitas_tecnicas_dados
                if ($op == 2) {
                    $dados .= '<b>:: Visitas Técnicas Dados</b>' . '<br><br>';
                    $dados .= $this->retornaDado(8, $dadosAnterior['visita_tecnica_id'], $dadosAtual['visita_tecnica_id'], 'Visita Técnica', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['titulo'], $dadosAtual['titulo'], 'Título', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['subtitulo'], $dadosAtual['subtitulo'], 'Subtítulo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pergunta'], $dadosAtual['pergunta'], 'Pergunta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['resposta'], $dadosAtual['resposta'], 'Resposta', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacao'], $dadosAtual['observacao'], 'Observação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade'], $dadosAtual['quantidade'], 'Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fotografia_1'], $dadosAtual['fotografia_1'], 'Fotografia 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fotografia_2'], $dadosAtual['fotografia_2'], 'Fotografia 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fotografia_3'], $dadosAtual['fotografia_3'], 'Fotografia 3', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pdf_1'], $dadosAtual['pdf_1'], 'PDF 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pdf_2'], $dadosAtual['pdf_2'], 'PDF 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pdf_3'], $dadosAtual['pdf_3'], 'PDF 3', '', '');
                }
            }

            //empresas
            if ($submodulo_id == 24) {
                if ($op == 1) {
                    $dados .= '<b>:: Empresas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //Ordens Serviço
            if ($submodulo_id == 26) {
                if ($op == 1) {
                    $dados .= '<b>:: Ordens Serviços</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_ordem_servico'], $dadosAtual['numero_ordem_servico'], 'Número Ordem Serviço', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano_ordem_servico'], $dadosAtual['ano_ordem_servico'], 'Ano Ordem Serviço', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['ordem_servico_tipo_id'], $dadosAtual['ordem_servico_tipo_id'], 'Tipo', OrdemServicoTipo::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['ordem_servico_status_id'], $dadosAtual['ordem_servico_status_id'], 'Status', OrdemServicoStatus::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_abertura'], $dadosAtual['data_abertura'], 'Data abertura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_abertura'], $dadosAtual['hora_abertura'], 'Hora abertura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_prevista'], $dadosAtual['data_prevista'], 'Data prevista', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_prevista'], $dadosAtual['hora_prevista'], 'Hora prevista', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_conclusao'], $dadosAtual['data_conclusao'], 'Data conclusão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_conclusao'], $dadosAtual['hora_conclusao'], 'Hora conclusão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_finalizacao'], $dadosAtual['data_finalizacao'], 'Data finalização', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_finalizacao'], $dadosAtual['hora_finalizacao'], 'Hora finalização', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_nome'], $dadosAtual['cliente_nome'], 'Cliente nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_telefone'], $dadosAtual['cliente_telefone'], 'Cliente telefone', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_celular'], $dadosAtual['cliente_celular'], 'Cliente celular', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_email'], $dadosAtual['cliente_email'], 'Cliente email', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_logradouro'], $dadosAtual['cliente_logradouro'], 'Cliente logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_bairro'], $dadosAtual['cliente_bairro'], 'Cliente bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_cidade'], $dadosAtual['cliente_cidade'], 'Cliente cidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao_servico'], $dadosAtual['descricao_servico'], 'Descrição serviço', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['ordem_servico_prioridade_id'], $dadosAtual['ordem_servico_prioridade_id'], 'Prioridade', OrdemServicoPrioridade::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacao'], $dadosAtual['observacao'], 'Observação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor_total'], $dadosAtual['valor_total'], 'Valor Total', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['porcentagem_desconto'], $dadosAtual['porcentagem_desconto'], 'Porcentagem Desconto', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor_desconto'], $dadosAtual['valor_desconto'], 'Valor Desconto', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['forma_pagamento_id'], $dadosAtual['forma_pagamento_id'], 'Forma pagamento', FormaPagamento::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['forma_pagamento_status_id'], $dadosAtual['forma_pagamento_status_id'], 'Forma pagamento status', FormaPagamentoStatus::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['forma_pagamento_observacao'], $dadosAtual['forma_pagamento_observacao'], 'Forma Pagamento Observação', '', '');
                }

                //Tabela ordens_servicos_servicos
                if ($op == 2) {
                    $dados .= '<b>:: Ordens Serviços Serviços</b>'.'<br><br>';
                    $dados .= $this->retornaDado(9, $dadosAnterior['ordem_servico_id'], $dadosAtual['ordem_servico_id'], 'Cliente/Data/Número', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['servico_id'], $dadosAtual['servico_id'], 'Serviço', Servico::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_nome'], $dadosAtual['servico_nome'], 'Serviço Nome', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['responsavel_funcionario_id'], $dadosAtual['responsavel_funcionario_id'], 'Responsável', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['responsavel_funcionario_nome'], $dadosAtual['responsavel_funcionario_nome'], 'Responsável nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_item'], $dadosAtual['servico_item'], 'Serviço Item', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_valor'], $dadosAtual['servico_valor'], 'Serviço Valor', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_quantidade'], $dadosAtual['servico_quantidade'], 'Serviço Quantidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['servico_valor_total'], $dadosAtual['servico_valor_total'], 'Serviço Valor Total', '', '');
                }

                //Tabela ordens_servicos_veiculos
                if ($op == 3) {
                    $dados .= '<b>:: Ordens Serviços Veículos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(9, $dadosAnterior['ordem_servico_id'], $dadosAtual['ordem_servico_id'], 'Cliente/Data/Número', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['veiculo_id'], $dadosAtual['veiculo_id'], 'Veículo', Veiculo::class, 'placa');
                    $dados .= $this->retornaDado(1, $dadosAnterior['veiculo_item'], $dadosAtual['veiculo_item'], 'Veículo Item', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['veiculo_marca'], $dadosAtual['veiculo_marca'], 'Veículo Marca', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['veiculo_modelo'], $dadosAtual['veiculo_modelo'], 'Veículo Modelo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['veiculo_placa'], $dadosAtual['veiculo_placa'], 'Veículo Placa', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['veiculo_combustivel'], $dadosAtual['veiculo_combustivel'], 'Veículo Combustível', '', '');
                }

                //Tabela ordens_servicos_executivos
                if ($op == 4) {
                    $dados .= '<b>:: Ordens Serviços Executivos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(9, $dadosAnterior['ordem_servico_id'], $dadosAtual['ordem_servico_id'], 'Cliente/Data/Número', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_executivo_id'], $dadosAtual['cliente_executivo_id'], 'Cliente Executivo', ClienteExecutivo::class, 'executivo_nome');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_executivo_item'], $dadosAtual['cliente_executivo_item'], 'Executivo Item', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_executivo_nome'], $dadosAtual['cliente_executivo_nome'], 'Executivo Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_executivo_funcao'], $dadosAtual['cliente_executivo_funcao'], 'Executivo Função', '', '');
                    $dados .= $this->retornaDado(10, $dadosAnterior['cliente_executivo_veiculo_id'], $dadosAtual['cliente_executivo_veiculo_id'], 'Veículo', '', '');
                }

                //Tabela ordens_servicos_destinos
                if ($op == 5) {
                    $dados .= '<b>:: Ordens Serviços Destinos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(9, $dadosAnterior['ordem_servico_id'], $dadosAtual['ordem_servico_id'], 'Cliente/Data/Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_ordem'], $dadosAtual['destino_ordem'], 'Destino Ordem', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_cep'], $dadosAtual['destino_cep'], 'Destino CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_logradouro'], $dadosAtual['destino_logradouro'], 'Destino Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_bairro'], $dadosAtual['destino_bairro'], 'Destino Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_localidade'], $dadosAtual['destino_localidade'], 'Destino Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_uf'], $dadosAtual['destino_uf'], 'Destino UF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_numero'], $dadosAtual['destino_numero'], 'Destino Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['destino_complemento'], $dadosAtual['destino_complemento'], 'Destino Complemento', '', '');
                }

                //Tabela ordens_servicos_equipes
                if ($op == 6) {
                    $dados .= '<b>:: Ordens Serviços Equipes</b>'.'<br><br>';
                    $dados .= $this->retornaDado(9, $dadosAnterior['ordem_servico_id'], $dadosAtual['ordem_servico_id'], 'Cliente/Data/Número', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['equipe_funcionario_id'], $dadosAtual['equipe_funcionario_id'], 'Equipe Funcionário', Funcionario::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['equipe_funcionario_item'], $dadosAtual['equipe_funcionario_item'], 'Equipe Funcionário Item', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['equipe_funcionario_nome'], $dadosAtual['equipe_funcionario_nome'], 'Equipe Funcionário Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['equipe_funcionario_funcao'], $dadosAtual['equipe_funcionario_funcao'], 'Equipe Funcionário Função', '', '');
                    $dados .= $this->retornaDado(10, $dadosAnterior['equipe_funcionario_veiculo_id'], $dadosAtual['equipe_funcionario_veiculo_id'], 'Veículo', '', '');
                }
            }

            //veiculos
            if ($submodulo_id == 27) {
                if ($op == 1) {
                    $dados .= '<b>:: Veículos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['veiculo_marca_id'], $dadosAtual['veiculo_marca_id'], 'Veículo Marca', VeiculoMarca::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['veiculo_modelo_id'], $dadosAtual['veiculo_modelo_id'], 'Veículo Modelo', VeiculoModelo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['placa'], $dadosAtual['placa'], 'Placa', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['renavam'], $dadosAtual['renavam'], 'Renavam', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['chassi'], $dadosAtual['chassi'], 'Chassi', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano_modelo'], $dadosAtual['ano_modelo'], 'Ano Modelo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano_fabricacao'], $dadosAtual['ano_fabricacao'], 'Ano Fabricação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cor'], $dadosAtual['cor'], 'Cor', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['veiculo_combustivel_id'], $dadosAtual['veiculo_combustivel_id'], 'Veículo Combustível', VeiculoCombustivel::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['veiculo_categoria_id'], $dadosAtual['veiculo_categoria_id'], 'Veículo Categoria', VeiculoCategoria::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['gnv'], $dadosAtual['gnv'], 'GNV', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['blindado'], $dadosAtual['blindado'], 'Blindado', '', '');
                }
            }

            //clientes_executivos
            if ($submodulo_id == 28) {
                if ($op == 1) {
                    $dados .= '<b>:: Clientes Executivos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['executivo_nome'], $dadosAtual['executivo_nome'], 'Executivo Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['executivo_funcao'], $dadosAtual['executivo_funcao'], 'Executivo Função', '', '');
                }
            }

            //estoques_locais
            if ($submodulo_id == 36) {
                if ($op == 1) {
                    $dados .= '<b>:: Estoques Locais</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['estoque_id'], $dadosAtual['estoque_id'], 'Estoque', Estoque::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao'], $dadosAtual['descricao'], 'Descrição', '', '');
                }
            }

            //produtos
            if ($submodulo_id == 32) {
                if ($op == 1) {
                    $dados .= '<b>:: Materiais</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['produto_categoria_id'], $dadosAtual['produto_categoria_id'], 'Categoria', ProdutoCategoria::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao'], $dadosAtual['descricao'], 'Descrição', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cor_id'], $dadosAtual['cor_id'], 'Cor', Cor::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ca'], $dadosAtual['ca'], 'CA', '', '');
                }
            }

            //Brigadas Incendios
            if ($submodulo_id == 33) {
                if ($op == 1) {
                    $dados .= '<b>:: Brigadas Incêndios</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_brigada_incendio'], $dadosAtual['numero_brigada_incendio'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano_brigada_incendio'], $dadosAtual['ano_brigada_incendio'], 'Ano', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_abertura'], $dadosAtual['data_abertura'], 'Data Abertura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_abertura'], $dadosAtual['hora_abertura'], 'Hora Abertura', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_prevista'], $dadosAtual['data_prevista'], 'Data Prevista', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_prevista'], $dadosAtual['hora_prevista'], 'Hora Prevista', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_conclusao'], $dadosAtual['data_conclusao'], 'Data Conclusão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_conclusao'], $dadosAtual['hora_conclusao'], 'Hora Conclusão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_finalizacao'], $dadosAtual['data_finalizacao'], 'Data Finalização', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_finalizacao'], $dadosAtual['hora_finalizacao'], 'Hora Finalização', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['cliente_id'], $dadosAtual['cliente_id'], 'Cliente', Cliente::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_nome'], $dadosAtual['cliente_nome'], 'Cliente Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_cnpj'], $dadosAtual['cliente_cnpj'], 'Cliente CNPJ', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cliente_email'], $dadosAtual['cliente_email'], 'Cliente E-mail', '', '');
                }

                //Tabela brigadas_incendios_produtos
                if ($op == 2) {
                    $dados .= '<b>:: Brigadas Incêndios Materiais</b>'.'<br><br>';
                    $dados .= $this->retornaDado(11, $dadosAnterior['brigada_incendio_id'], $dadosAtual['brigada_incendio_id'], 'Brigada Incêndio', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['produto_id'], $dadosAtual['produto_id'], 'Produto', Produto::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_categoria_name'], $dadosAtual['produto_categoria_name'], 'Produto Categoria Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_name'], $dadosAtual['produto_name'], 'Produto Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_quantidade'], $dadosAtual['produto_quantidade'], 'Produto Quantidade', '', '');
                }

                //Tabela brigadas_incendios_escalas
                if ($op == 3) {
                    $dados .= '<b>:: Brigadas Incêndios Escalas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(11, $dadosAnterior['brigada_incendio_id'], $dadosAtual['brigada_incendio_id'], 'Brigada Incêndio', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['escala_tipo_id'], $dadosAtual['escala_tipo_id'], 'Tipo', EscalaTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['escala_tipo_name'], $dadosAtual['escala_tipo_name'], 'Tipo Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['escala_tipo_quantidade_alas'], $dadosAtual['escala_tipo_quantidade_alas'], 'Qtd. Alas', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['escala_tipo_quantidade_horas_trabalhadas'], $dadosAtual['escala_tipo_quantidade_horas_trabalhadas'], 'Qtd. Horas Trabalhadas', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['escala_tipo_quantidade_horas_descanso'], $dadosAtual['escala_tipo_quantidade_horas_descanso'], 'Qtd. Horas Descanso', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade_brigadistas_por_ala'], $dadosAtual['quantidade_brigadistas_por_ala'], 'Qtd. Brig/Ala', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quantidade_brigadistas_total'], $dadosAtual['quantidade_brigadistas_total'], 'Qtd. Brig/Total', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['posto'], $dadosAtual['posto'], 'Posto', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_inicio_ala_1'], $dadosAtual['hora_inicio_ala_1'], 'Hr. início Ala 1', '', '');
                }

                //Tabela brigadas_incendios_escalas_brigadistas
                if ($op == 4) {
                    $dados .= '<b>:: Brigadas Incêndios Escalas Brigadistas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(11, $dadosAnterior['brigada_incendio_id'], $dadosAtual['brigada_incendio_id'], 'Brigada Incêndio', '', '');
                    $dados .= $this->retornaDado(12, $dadosAnterior['brigada_incendio_escala_id'], $dadosAtual['brigada_incendio_escala_id'], 'Brigada Incêndio Escala', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['funcionario_name'], $dadosAtual['funcionario_name'], 'Brigadista Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ala'], $dadosAtual['ala'], 'Ala', '', '');
                }
            }

            // Materiais Entradas
            if ($submodulo_id == 37) {
                if ($op == 1) {
                    $dados .= '<b>:: Materiais Entradas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['empresa_id'], $dadosAtual['empresa_id'], 'Empresa', Empresa::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nf_numero'], $dadosAtual['nf_numero'], 'NF Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nf_serie'], $dadosAtual['nf_serie'], 'NF Série', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nf_chave_acesso'], $dadosAtual['nf_chave_acesso'], 'NF Chave Acesso', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_emissao'], $dadosAtual['data_emissao'], 'Data Emissão', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor_total'], $dadosAtual['valor_total'], 'Valor Total', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['valor_desconto'], $dadosAtual['valor_desconto'], 'Valor Desconto', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['fornecedor_id'], $dadosAtual['fornecedor_id'], 'Fornecedor', Fornecedor::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_nome'], $dadosAtual['fornecedor_nome'], 'Fornecedor Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_cnpj'], $dadosAtual['fornecedor_cnpj'], 'Fornecedor CNPJ', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_telefone'], $dadosAtual['fornecedor_telefone'], 'Fornecedor Telefone', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_celular'], $dadosAtual['fornecedor_celular'], 'Fornecedor Celular', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_email'], $dadosAtual['fornecedor_email'], 'Fornecedor E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_logradouro'], $dadosAtual['fornecedor_logradouro'], 'Fornecedor Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_logradouro_numero'], $dadosAtual['fornecedor_logradouro_numero'], 'Fornecedor Logradouro Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_logradouro_complemento'], $dadosAtual['fornecedor_logradouro_complemento'], 'Fornecedor Logradouro Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_bairro'], $dadosAtual['fornecedor_bairro'], 'Fornecedor Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_cidade'], $dadosAtual['fornecedor_cidade'], 'Fornecedor Cidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['fornecedor_uf'], $dadosAtual['fornecedor_uf'], 'Fornecedor UF', '', '');
                }

                //Tabela produtos_entradas_itens
                if ($op == 2) {
                    $dados .= '<b>:: Materiais Entradas Itens</b>'.'<br><br>';
                    $dados .= $this->retornaDado(13, $dadosAnterior['produto_entrada_id'], $dadosAtual['produto_entrada_id'], 'Produto Entrada', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['produto_id'], $dadosAtual['produto_id'], 'Produto', Produto::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_categoria_name'], $dadosAtual['produto_categoria_name'], 'Categoria', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_name'], $dadosAtual['produto_name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['produto_tipo_id'], $dadosAtual['produto_tipo_id'], 'Produto Tipo', ProdutoTipo::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_tipo_name'], $dadosAtual['produto_tipo_name'], 'Tipo Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_numero_patrimonio'], $dadosAtual['produto_numero_patrimonio'], 'Número Patrimônio', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['produto_valor_unitario'], $dadosAtual['produto_valor_unitario'], 'Valor Unitário', '', '');
                }
            }

            // Materiais Movimentações
            if ($submodulo_id == 38) {
                if ($op == 1) {
                    $dados .= '<b>:: Materiais Movimentações</b>'.'<br><br>';
                    $dados .= $this->retornaDado(14, $dadosAnterior['origem_estoque_local_id'], $dadosAtual['origem_estoque_local_id'], 'Origem Local', '', '');
                    $dados .= $this->retornaDado(14, $dadosAnterior['destino_estoque_local_id'], $dadosAtual['destino_estoque_local_id'], 'Destino Local', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_movimentacao'], $dadosAtual['data_movimentacao'], 'Data Movimentação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['hora_movimentacao'], $dadosAtual['hora_movimentacao'], 'Hora Movimentação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacoes'], $dadosAtual['observacoes'], 'Observações', '', '');
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
