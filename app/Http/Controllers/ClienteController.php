<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Models\Banco;
use App\Models\ClienteDocumento;
use App\Models\ClienteSegurancaMedida;
use App\Models\ClienteServico;
use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\EdificacaoClassificacao;
use App\Models\Genero;
use App\Models\IdentidadeOrgao;
use App\Models\Estado;
use App\Models\IncendioRisco;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\SegurancaMedida;
use App\Models\Cliente;
use App\Facades\Transacoes;
use App\Models\VisitaTecnica;
use http\Client;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function index()
    {
        $registros = $this->cliente
            ->leftJoin('identidade_orgaos', 'clientes.identidade_orgao_id', '=', 'identidade_orgaos.id')
            ->leftJoin('estados', 'clientes.identidade_estado_id', '=', 'estados.id')
            ->leftJoin('generos', 'clientes.genero_id', '=', 'generos.id')
            ->leftJoin('clientes as principal_clientes', 'clientes.principal_cliente_id', '=', 'principal_clientes.id')
            ->leftJoin('clientes as rede_clientes', 'clientes.rede_cliente_id', '=', 'rede_clientes.id')
            ->leftJoin('bancos', 'clientes.banco_id', '=', 'bancos.id')
            ->select(['clientes.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'principal_clientes.name as principalClienteName', 'rede_clientes.name as redeClienteName', 'bancos.name as bancoName'])
            ->orderby('clientes.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->cliente->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //buscar dados das medidas de segurança
                $registro['cliente_seguranca_medidas'] = ClienteSegurancaMedida::where('cliente_id', '=', $id)->get();

                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function auxiliary()
    {
        try {
            $registros = array();

            //Gêneros
            $registros['generos'] = Genero::all();

            //Clientes
            $registros['clientes'] = Cliente::all();

            //Bancos
            $registros['bancos'] = Banco::all();

            //Órgãos Identidades
            $registros['identidade_orgaos'] = IdentidadeOrgao::all();

            //Estados para a Identidade
            $registros['identidade_estados'] = Estado::all();

            //Edificacao Classificacoes
            $registros['edificacao_classificacoes'] = EdificacaoClassificacao::all();

            //Incêndio Riscos
            $registros['incendio_riscos'] = IncendioRisco::all();

            //Segurança Medidas
            $registros['seguranca_medidas'] = SegurancaMedida::all();

            //Documentos
            $registros['documentos'] = Documento
                ::join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('documentos.*', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('documentos.documento_submodulo_id', 1)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(ClienteStoreRequest $request)
    {
        try {
            //Incluindo registro
            $registro = $this->cliente->create($request->all());

            //Editar dados na tabela clientes_seguranca_medidas
            SuporteFacade::editClienteSegurancaMedida(1, $registro['id'], $request);

            //Return
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(ClienteUpdateRequest $request, $id)
    {
        try {
            $registro = $this->cliente->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                //Editar dados na tabela clientes_seguranca_medidas
                SuporteFacade::editClienteSegurancaMedida(1, $id, $request);

                //Atualizar Visitas Técnicas para esse Cliente''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //SuporteFacade::updateVisitaTecnicaCliente($id);
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

    public function modal_info($id)
    {
        try {
            $registro = array();

            //Cliente
            $cliente = Cliente
                ::leftJoin('identidade_orgaos', 'clientes.identidade_orgao_id', '=', 'identidade_orgaos.id')
                ->leftJoin('estados', 'clientes.identidade_estado_id', '=', 'estados.id')
                ->leftJoin('generos', 'clientes.genero_id', '=', 'generos.id')
                ->leftJoin('clientes as principal_clientes', 'clientes.principal_cliente_id', '=', 'principal_clientes.id')
                ->leftJoin('clientes as rede_clientes', 'clientes.rede_cliente_id', '=', 'rede_clientes.id')
                ->leftJoin('bancos', 'clientes.banco_id', '=', 'bancos.id')
                ->select(['clientes.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'principal_clientes.name as principalClienteName', 'rede_clientes.name as redeClienteName', 'bancos.name as bancoName'])
                ->orderby('clientes.name')
                ->where('clientes.id', '=', $id)
                ->get();

            $registro['cliente'] = $cliente[0];
            
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function estatisticas($id)
    {
        try {
            $registro = array();

            //Documentos
            $documentos = ClienteDocumento
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['documentos'] = $documentos;

            //Visitas Técnicas
            $visitas_tecnicas = VisitaTecnica
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['visitas_tecnicas'] = $visitas_tecnicas;

            //Ordens Serviços
            $ordens_servicos = OrdemServico
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['ordens_servicos'] = $ordens_servicos;

            //Propostas
            $propostas = Proposta
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['propostas'] = $propostas;

            //Clientes Rede
            $clientes_rede = Cliente
                ::where('rede_cliente_id', '=', $id)
                ->count();

            $registro['clientes_rede'] = $clientes_rede;

            //Clientes Principal
            $clientes_principal = Cliente
                ::where('principal_cliente_id', '=', $id)
                ->count();

            $registro['clientes_principal'] = $clientes_principal;

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_logotipo_principal(Request $request)
    {
        try {
            $registro = $this->cliente->find($request['cliente_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->logotipo_principal = $request['logotipo_principal'];
                $registro->save();

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_logotipo_relatorios(Request $request)
    {
        try {
            $registro = $this->cliente->find($request['cliente_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->logotipo_relatorios = $request['logotipo_relatorios'];
                $registro->save();

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_logotipo_cartao_emergencial(Request $request)
    {
        try {
            $registro = $this->cliente->find($request['cliente_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->logotipo_cartao_emergencial = $request['logotipo_cartao_emergencial'];
                $registro->save();

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
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
            //Incluir Registro
            if ($request['acao'] == 1) {
                //Registro
                ClienteDocumento::create($request->all());

                //Transação
                Transacoes::transacaoRecord(3, 1, 'clientes', $request, $request);

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

    public function documentos($cliente_id)
    {
        try {
            $registros = array();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['clientes_documentos'] = ClienteDocumento
                ::join('documentos', 'clientes_documentos.documento_id', 'documentos.id')
                ->join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('clientes_documentos.*', 'documentos.documento_fonte_id', 'documentos.name as documentoName', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('clientes_documentos.cliente_id', $cliente_id)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_documento($cliente_documento_id)
    {
        $registro = ClienteDocumento::find($cliente_documento_id);

        if (!$registro) {
            return $this->sendResponse('Documento não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(3, 3, 'clientes', $registro, $registro);

            //Return
            return $this->sendResponse('Documento excluído com sucesso.', 2000, null, $registro['caminho']);
        }
    }

    public function servicos($cliente_id)
    {
        try {
            $registros = array();

            //Ordens de Serviços
            $registros['ordens_servicos'] = OrdemServico
                ::join('ordem_servico_tipos', 'ordens_servicos.ordem_servico_tipo_id', 'ordem_servico_tipos.id')
                ->select('ordens_servicos.id', 'ordens_servicos.data_abertura', 'ordem_servico_tipos.name as ordemServicoTipoName')
                ->where('ordens_servicos.cliente_id', $cliente_id)
                ->orderby('ordens_servicos.data_abertura', 'DESC')
                ->get();

            //Visitas Técnicas
            $registros['visitas_tecnicas'] = VisitaTecnica
                ::join('visita_tecnica_tipos', 'visitas_tecnicas.visita_tecnica_tipo_id', 'visita_tecnica_tipos.id')
                ->select('visitas_tecnicas.id', 'visitas_tecnicas.data_abertura', 'visita_tecnica_tipos.name as visitaTecnicaTipoName')
                ->where('visitas_tecnicas.cliente_id', $cliente_id)
                ->orderby('visitas_tecnicas.data_abertura', 'DESC')
                ->get();

            //Propostas
            $registros['propostas'] = Proposta
                ::select('propostas.id', 'propostas.data_proposta')
                ->where('propostas.cliente_id', $cliente_id)
                ->orderby('propostas.data_proposta', 'DESC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function clientes($cliente_id)
    {
        try {
            $registros = array();

            //Clientes Rede
            $registros['clientes_rede'] = Cliente
                ::select('clientes.id', 'clientes.name', 'clientes.cnpj')
                ->where('clientes.rede_cliente_id', $cliente_id)
                ->orderby('clientes.name', 'ASC')
                ->get();

            //Clientes Principal
            $registros['clientes_principal'] = Cliente
                ::select('clientes.id', 'clientes.name', 'clientes.cnpj')
                ->where('clientes.principal_cliente_id', $cliente_id)
                ->orderby('clientes.name', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function visita_tecnica($id)
    {
        try {
            $registro = $this->cliente->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Buscando Risco Incendio
                if (isset($registro['incendio_risco_id']) and $registro['incendio_risco_id'] != '') {
                    $incendio_risco = IncendioRisco::where('id', '=', $registro['incendio_risco_id'])->get('name');
                    $registro['incendio_risco'] = $incendio_risco[0]['name'];
                } else {
                    $registro['incendio_risco'] = [];
                }

                //Edificacao Classificacao
                if (isset($registro['edificacao_classificacao_id']) and $registro['edificacao_classificacao_id'] != '') {
                    $edificacao_classificacao = EdificacaoClassificacao::where('id', '=', $registro['edificacao_classificacao_id'])->get();
                    $registro['grupo'] = $edificacao_classificacao[0]['grupo'];
                    $registro['ocupacao_uso'] = $edificacao_classificacao[0]['ocupacao_uso'];
                    $registro['divisao'] = $edificacao_classificacao[0]['divisao'];
                    $registro['descricao'] = $edificacao_classificacao[0]['descricao'];
                    $registro['definicao'] = $edificacao_classificacao[0]['definicao'];
                } else {
                    $registro['grupo'] = '';
                    $registro['ocupacao_uso'] = '';
                    $registro['divisao'] = '';
                    $registro['descricao'] = '';
                    $registro['definicao'] = '';
                }

                //buscar dados das medidas de segurança
                $cliente_seguranca_medidas = ClienteSegurancaMedida
                    ::leftJoin('seguranca_medidas', 'clientes_seguranca_medidas.seguranca_medida_id', '=', 'seguranca_medidas.id')
                    ->select(['clientes_seguranca_medidas.*', 'seguranca_medidas.name as seguranca_medida_nome'])
                    ->where('clientes_seguranca_medidas.cliente_id', '=', $id)
                    ->orderBy('clientes_seguranca_medidas.pavimento')
                    ->orderBy('seguranca_medidas.name')
                    ->get();

                $registro['cliente_seguranca_medidas'] = $cliente_seguranca_medidas;

                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = $this->cliente->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela clientes
                if (SuporteFacade::verificarRelacionamento('clientes', 'principal_cliente_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Clientes.', 2040, null, null);
                }

                //Tabela clientes
                if (SuporteFacade::verificarRelacionamento('clientes', 'rede_cliente_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Clientes.', 2040, null, null);
                }

                //Tabela propostas
                if (SuporteFacade::verificarRelacionamento('propostas', 'cliente_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Propostas.', 2040, null, null);
                }
                
                //Tabela clientes_executivos
                if (SuporteFacade::verificarRelacionamento('clientes_executivos', 'cliente_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Clientes Executivos.', 2040, null, null);
                }

                //Tabela ordens_servicos
                if (SuporteFacade::verificarRelacionamento('ordens_servicos', 'cliente_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Ordem de Serviço.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Editar dados na tabela clientes_seguranca_medidas
                SuporteFacade::editClienteSegurancaMedida(3, $id, '');

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

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->cliente
            ->leftJoin('identidade_orgaos', 'clientes.identidade_orgao_id', '=', 'identidade_orgaos.id')
            ->leftJoin('estados', 'clientes.identidade_estado_id', '=', 'estados.id')
            ->leftJoin('generos', 'clientes.genero_id', '=', 'generos.id')
            ->leftJoin('clientes as principal_clientes', 'clientes.principal_cliente_id', '=', 'principal_clientes.id')
            ->leftJoin('clientes as rede_clientes', 'clientes.rede_cliente_id', '=', 'rede_clientes.id')
            ->leftJoin('bancos', 'clientes.banco_id', '=', 'bancos.id')
            ->select(['clientes.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'principal_clientes.name as principalClienteName', 'rede_clientes.name as redeClienteName', 'bancos.name as bancoName'])
            ->orderby('clientes.name')
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
