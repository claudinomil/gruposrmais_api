<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Models\Banco;
use App\Models\ClienteDocumento;
use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\EdificacaoClassificacao;
use App\Models\Genero;
use App\Models\IdentidadeOrgao;
use App\Models\Estado;
use App\Models\IncendioRisco;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\MedidaSeguranca;
use App\Models\Cliente;
use App\Facades\Transacoes;
use App\Models\BrigadaIncendio;
use App\Models\ClienteDocumentoExigido;
use App\Models\ClienteLoja;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Edificacao;
use App\Models\EdificacaoNivel;
use App\Models\GrupoPermissao;
use App\Models\VisitaTecnica;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            //Documentos
            $registros['documentos'] = Documento
                ::leftjoin('documento_submodulos', 'documento_submodulos.id', 'documentos.documento_submodulo_id')
                ->leftjoin('documento_fontes', 'documento_fontes.id', 'documentos.documento_fonte_id')
                ->select('documentos.*', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('documentos.documento_submodulo_id', 1)
                ->orderby('documento_fontes.ordem')
                ->orderby('documentos.ordem')
                ->get();

            // Edificações Níveis
            $registros['edificacoes_niveis'] = EdificacaoNivel
                ::Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
                ->select(['edificacoes_niveis.*', 'edificacoes.name as edificacaoName', 'clientes.id as clienteId', 'clientes.name as clienteName'])
                ->orderby('clientes.name')
                ->orderby('edificacoes.name')
                ->orderby('edificacoes_niveis.name')
                ->get();

            // Medidas Segurança
            $registros['medidas_seguranca'] = MedidaSeguranca::orderby('name')->get();

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

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
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
            ->where(
                function ($query) use ($filtros) {
                    //Variavel para controle
                    $qtdFiltros = count($filtros) / 4;
                    $indexCampo = 0;

                    for ($i = 1; $i <= $qtdFiltros; $i++) {
                        //Valores do Filtro
                        $condicao = $filtros[$indexCampo];
                        $campo = $filtros[$indexCampo + 1];
                        $operacao = $filtros[$indexCampo + 2];
                        $dado = $filtros[$indexCampo + 3];

                        //Operações
                        if ($operacao == 1) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', '%' . $dado . '%');
                            } else {
                                $query->orwhere($campo, 'like', '%' . $dado . '%');
                            }
                        }
                        if ($operacao == 2) {
                            if ($condicao == 1) {
                                $query->where($campo, '=', $dado);
                            } else {
                                $query->orwhere($campo, '=', $dado);
                            }
                        }
                        if ($operacao == 3) {
                            if ($condicao == 1) {
                                $query->where($campo, '>', $dado);
                            } else {
                                $query->orwhere($campo, '>', $dado);
                            }
                        }
                        if ($operacao == 4) {
                            if ($condicao == 1) {
                                $query->where($campo, '>=', $dado);
                            } else {
                                $query->orwhere($campo, '>=', $dado);
                            }
                        }
                        if ($operacao == 5) {
                            if ($condicao == 1) {
                                $query->where($campo, '<', $dado);
                            } else {
                                $query->orwhere($campo, '<', $dado);
                            }
                        }
                        if ($operacao == 6) {
                            if ($condicao == 1) {
                                $query->where($campo, '<=', $dado);
                            } else {
                                $query->orwhere($campo, '<=', $dado);
                            }
                        }
                        if ($operacao == 7) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', $dado . '%');
                            } else {
                                $query->orwhere($campo, 'like', $dado . '%');
                            }
                        }
                        if ($operacao == 8) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', '%' . $dado);
                            } else {
                                $query->orwhere($campo, 'like', '%' . $dado);
                            }
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

            // Documentos
            $documentos = ClienteDocumento
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['documentos'] = $documentos;

            // Visitas Técnicas
            $visitas_tecnicas = VisitaTecnica
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['visitas_tecnicas'] = $visitas_tecnicas;

            // Ordens Serviços
            $ordens_servicos = OrdemServico
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['ordens_servicos'] = $ordens_servicos;

            // Brigadas Incêndios
            $brigadas_incendios = BrigadaIncendio
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['brigadas_incendios'] = $brigadas_incendios;

            // Propostas
            $propostas = Proposta
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['propostas'] = $propostas;

            // Clientes Rede
            $clientes_rede = Cliente
                ::where('rede_cliente_id', '=', $id)
                ->count();

            $registro['clientes_rede'] = $clientes_rede;

            // Clientes Principal
            $clientes_principal = Cliente
                ::where('principal_cliente_id', '=', $id)
                ->count();

            $registro['clientes_principal'] = $clientes_principal;

            // Documentos Exigidos
            $documentos_exigidos = ClienteDocumentoExigido
                ::where('cliente_id', $id)
                ->count();

            $registro['documentos_exigidos'] = $documentos_exigidos;

            // Lojas
            $lojas = ClienteLoja
                ::Join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
                ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->where('edificacoes.cliente_id', '=', $id)
                ->count();

            $registro['lojas'] = $lojas;

            // Sistemas Preventivos
            $sistemas_preventivos = ClienteSistemaPreventivo
                ::where('cliente_id', '=', $id)
                ->count();

            $registro['sistemas_preventivos'] = $sistemas_preventivos;

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

    public function upload_logotipo_menu(Request $request)
    {
        try {
            $registro = $this->cliente->find($request['cliente_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->logotipo_menu = $request['logotipo_menu'];
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

    public function documentos_exigidos($cliente_id)
    {
        try {
            $registros = array();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['clientes_documentos_exigidos'] = ClienteDocumentoExigido
                ::join('documentos', 'documentos.id', '=', 'clientes_documentos_exigidos.documento_id')
                ->join('documento_submodulos', 'documento_submodulos.id', '=', 'documentos.documento_submodulo_id')
                ->join('documento_fontes', 'documento_fontes.id', '=', 'documentos.documento_fonte_id')
                ->leftJoin('clientes_documentos', function ($join) {
                    $join->on('clientes_documentos.documento_id', '=', 'clientes_documentos_exigidos.documento_id')
                        ->on('clientes_documentos.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id');
                })
                ->select(
                    'clientes_documentos_exigidos.*',
                    'documentos.documento_fonte_id',
                    'documentos.name as documentoName',
                    'documento_submodulos.name as documentoSubmoduloName',
                    'documento_fontes.name as documentoFonteName',
                    'clientes_documentos.caminho as clienteDocumentoCaminho'
                )
                ->where('clientes_documentos_exigidos.cliente_id', $cliente_id)
                ->orderBy('documento_fontes.ordem')
                ->orderBy('documentos.ordem')
                ->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, []);
        }
    }

    public function documentos_exigidos_save(Request $request)
    {
        try {
            $request->validate([
                'editar_documentos_exigidos_cliente_id' => 'required|integer',
                'editar_documentos_exigidos_documentos_exigidos' => 'required|array',
                'editar_documentos_exigidos_documentos_exigidos.*' => 'integer'
            ]);

            $clienteId = $request->input('editar_documentos_exigidos_cliente_id');
            $documentosIds = $request->input('editar_documentos_exigidos_documentos_exigidos');

            // IDs atualmente registrados
            $documentosExistentes = ClienteDocumentoExigido::where('cliente_id', $clienteId)->pluck('documento_id')->toArray();

            // Calcula diferenças
            $novos = array_diff($documentosIds, $documentosExistentes);
            $removidos = array_diff($documentosExistentes, $documentosIds);

            // Inserir novos
            if (!empty($novos)) {
                $dados = collect($novos)->map(fn($id) => [
                    'cliente_id' => $clienteId,
                    'documento_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ])->toArray();

                ClienteDocumentoExigido::insert($dados);
            }

            // Remover desmarcados
            if (!empty($removidos)) {
                ClienteDocumentoExigido::where('cliente_id', $clienteId)->whereIn('documento_id', $removidos)->delete();
            }

            return $this->sendResponse('Documentos exigidos sincronizados com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function editar_documento(Request $request)
    {
        try {
            if ($request['operacao'] == 'create') {
                // Incluir Registro
                ClienteDocumento::create($request->all());

                // Transação
                Transacoes::transacaoRecord(3, 1, 'clientes', $request, $request);
            } else if ($request['operacao'] == 'edit') {
                // Buscando Registro
                $registro = ClienteDocumento::find($request['cliente_documento_id']);

                // Dados Anterior
                $dadosAnterior = $registro;

                // Alterando registro
                $registro->update($request->all());

                // Transação
                Transacoes::transacaoRecord(3, 2, 'clientes', $dadosAnterior, $request);
            }

            // Return
            return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $request);
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

            $registros['permissoes'] = GrupoPermissao
                ::join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                ->select('permissoes.name as permissao')
                ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                ->where(function ($query) {
                    $query->where('permissoes.name', 'like', 'clientes_list%')
                        ->orWhere('permissoes.name', 'like', 'clientes_show%')
                        ->orWhere('permissoes.name', 'like', 'clientes_edit%')
                        ->orWhere('permissoes.name', 'like', 'clientes_destroy%');
                })
                ->get();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['clientes_documentos'] = ClienteDocumento
                ::join('documentos', 'clientes_documentos.documento_id', 'documentos.id')
                ->join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('clientes_documentos.*', 'documentos.documento_fonte_id', 'documentos.name as documentoName', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('clientes_documentos.cliente_id', $cliente_id)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->orderBy('clientes_documentos.data_emissao', 'DESC')
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

    public function editar_loja(Request $request)
    {
        try {
            if ($request['operacao'] == 'create') {

                // 🔍 Verifica se já existe o mesmo LUC para o mesmo cliente
                $existe = ClienteLoja
                    ::Join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
                    ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                    ->where('edificacoes.cliente_id', $request->cliente_id)
                    ->where('edificacoes_niveis.id', $request->edificacao_nivel_id)
                    ->where('clientes_lojas.luc', $request->luc)
                    ->exists();

                if ($existe) {
                    return $this->sendResponse('Já existe uma loja com esse LUC para este cliente (Nível).', 2020, null, $request);
                }

                // Incluir Registro
                ClienteLoja::create($request->all());

                // Transação
                Transacoes::transacaoRecord(5, 1, 'clientes', $request, $request);
            } else if ($request['operacao'] == 'edit') {

                // Buscando Registro
                $registro = ClienteLoja::find($request['cliente_loja_id']);

                // 🔍 Verifica duplicidade (ignorando o próprio registro)
                $existe = ClienteLoja
                    ::Join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
                    ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                    ->where('edificacoes.cliente_id', $request->cliente_id)
                    ->where('edificacoes_niveis.id', $request->edificacao_nivel_id)
                    ->where('clientes_lojas.luc', $request->luc)
                    ->where('clientes_lojas.id', '!=', $registro->id)
                    ->exists();

                if ($existe) {
                    return $this->sendResponse('Já existe uma loja com esse LUC para este cliente (Nível).', 2020, null, $request);
                }

                // Alterando registro
                ClienteLoja::find($request['cliente_loja_id'])->update($request->all());

                // Transação
                Transacoes::transacaoRecord(5, 2, 'clientes', $registro, $request);
            }

            // Return
            return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $request);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function lojas($cliente_id)
    {
        try {
            $registros = array();

            $registros['permissoes'] = GrupoPermissao
                ::join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                ->select('permissoes.name as permissao')
                ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                ->where(function ($query) {
                    $query->where('permissoes.name', 'like', 'clientes_list%')
                        ->orWhere('permissoes.name', 'like', 'clientes_show%')
                        ->orWhere('permissoes.name', 'like', 'clientes_edit%')
                        ->orWhere('permissoes.name', 'like', 'clientes_destroy%');
                })
                ->get();

            // $registros['loja_fontes'] = ClienteLoja
            //     ::Join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
            //     ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
            //     ->where('edificacoes.cliente_id', $cliente_id)
            //     ->select('edificacoes.id', 'edificacoes.name')
            //     ->orderby('edificacoes.name')
            //     ->get();

            $registros['loja_fontes'] = Edificacao
                ::where('edificacoes.cliente_id', $cliente_id)
                ->select('edificacoes.id', 'edificacoes.name')
                ->orderby('edificacoes.name')
                ->get();

                $registros['clientes_lojas'] = ClienteLoja
                ::Join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
                ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->leftJoin('clientes as subordinados_clientes', 'subordinados_clientes.id', '=', 'clientes_lojas.subordinado_cliente_id')
                ->where('edificacoes.cliente_id', $cliente_id)
                ->select('clientes_lojas.*', 'edificacoes.id as edificacaoId', 'edificacoes.name as edificacaoName', 'edificacoes_niveis.name as edificacaoNivelName', 'subordinados_clientes.name as subordinadoClienteName')
                ->orderby('edificacoes.name')
                ->orderby('edificacoes_niveis.ordem')
                ->orderby('clientes_lojas.ordem')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_loja($cliente_loja_id)
    {
        $registro = ClienteLoja::find($cliente_loja_id);

        if (!$registro) {
            return $this->sendResponse('Cliente Loja não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(5, 3, 'clientes', $registro, $registro);

            //Return
            return $this->sendResponse('Cliente Loja excluído com sucesso.', 2000, null, $registro['caminho']);
        }
    }

    public function editar_sistema_preventivo(Request $request)
    {
        try {
            if ($request['operacao'] == 'create') {
                // Incluir Registro
                ClienteSistemaPreventivo::create($request->all());

                // Transação
                Transacoes::transacaoRecord(6, 1, 'clientes', $request, $request);
            } else if ($request['operacao'] == 'edit') {
                // Buscando Registro
                $registro = ClienteSistemaPreventivo::find($request['cliente_sistema_preventivo_id']);

                // Dados Anterior
                $dadosAnterior = $registro;

                // Alterando registro
                $registro->update($request->all());

                // Transação
                Transacoes::transacaoRecord(6, 2, 'clientes', $dadosAnterior, $request);
            }

            // Return
            return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $request);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function sistemas_preventivos($cliente_id)
    {
        try {
            $registros = array();

            $registros['permissoes'] = GrupoPermissao
                ::join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                ->select('permissoes.name as permissao')
                ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                ->where(function ($query) {
                    $query->where('permissoes.name', 'like', 'clientes_list%')
                        ->orWhere('permissoes.name', 'like', 'clientes_show%')
                        ->orWhere('permissoes.name', 'like', 'clientes_edit%')
                        ->orWhere('permissoes.name', 'like', 'clientes_destroy%');
                })
                ->get();

            $registros['sistema_preventivo_fontes'] = MedidaSeguranca::orderby('ordem', 'ASC')->get();

            $registros['clientes_sistemas_preventivos'] = ClienteSistemaPreventivo
                ::join('medidas_seguranca', 'medidas_seguranca.id', 'clientes_sistemas_preventivos.medida_seguranca_id')
                ->select('clientes_sistemas_preventivos.*', 'medidas_seguranca.id as sistema_preventivo_fonte_id', 'medidas_seguranca.name as medidaSegurancaName')
                ->where('clientes_sistemas_preventivos.cliente_id', $cliente_id)
                ->orderby('medidas_seguranca.name')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_sistema_preventivo($cliente_sistema_preventivo_id)
    {
        $registro = ClienteSistemaPreventivo::find($cliente_sistema_preventivo_id);

        if (!$registro) {
            return $this->sendResponse('Sistema Preventivo não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(6, 3, 'clientes', $registro, $registro);

            //Return
            return $this->sendResponse('Sistema Preventivo excluído com sucesso.', 2000, null, $registro['fotografia']);
        }
    }

    public function propostas($cliente_id)
    {
        try {
            $registros = Proposta
                ::where('propostas.cliente_id', $cliente_id)
                ->orderby('propostas.data_proposta', 'DESC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, []);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, []);
        }
    }

    public function ordens_servicos($cliente_id)
    {
        try {
            $registros = OrdemServico
                ::leftJoin('ordem_servico_tipos', 'ordens_servicos.ordem_servico_tipo_id', '=', 'ordem_servico_tipos.id')
                ->leftJoin('clientes', 'ordens_servicos.cliente_id', '=', 'clientes.id')
                ->select(['ordens_servicos.*', 'ordem_servico_tipos.name as ordemServicoTipoName', 'clientes.name as clienteName'])
                ->where('ordens_servicos.cliente_id', $cliente_id)
                ->orderby('ordens_servicos.ano_ordem_servico', 'DESC')
                ->orderby('ordens_servicos.numero_ordem_servico', 'DESC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, []);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, []);
        }
    }

    public function visitas_tecnicas($cliente_id)
    {
        try {
            $registros = VisitaTecnica
                ::leftJoin('visita_tecnica_tipos', 'visitas_tecnicas.visita_tecnica_tipo_id', '=', 'visita_tecnica_tipos.id')
                ->leftJoin('clientes', 'visitas_tecnicas.cliente_id', '=', 'clientes.id')
                ->select(['visitas_tecnicas.*', 'visita_tecnica_tipos.name as visitaTecnicaTipoName', 'clientes.name as clienteName'])
                ->where('visitas_tecnicas.cliente_id', $cliente_id)
                ->orderby('visitas_tecnicas.ano_visita_tecnica', 'DESC')
                ->orderby('visitas_tecnicas.numero_visita_tecnica', 'DESC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, []);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, []);
        }
    }

    public function brigadas_incendios($cliente_id)
    {
        try {
            $registros = BrigadaIncendio
                ::join('clientes', 'clientes.id', 'brigadas_incendios.cliente_id')
                ->select('brigadas_incendios.*', 'clientes.name as clienteName')
                ->where('brigadas_incendios.cliente_id', $cliente_id)
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, []);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, []);
        }
    }

    public function clientes_rede($cliente_id)
    {
        try {
            $registros = Cliente
                ::select('clientes.id', 'clientes.name', 'clientes.cnpj')
                ->where('clientes.rede_cliente_id', $cliente_id)
                ->orderby('clientes.name', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, []);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, []);
        }
    }

    public function clientes_principal($cliente_id)
    {
        try {
            $registros = Cliente
                ::select('clientes.id', 'clientes.name', 'clientes.cnpj')
                ->where('clientes.principal_cliente_id', $cliente_id)
                ->orderby('clientes.name', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, []);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, []);
        }
    }

    public function sistema_preventivo_informacao($sistema_preventivo_numero)
    {
        $dados = array();

        $dados['sistema_preventivo'] = ClienteSistemaPreventivo
            ::join('clientes', 'clientes.id', 'clientes_sistemas_preventivos.cliente_id')
            ->join('medidas_seguranca', 'medidas_seguranca.id', 'clientes_sistemas_preventivos.medida_seguranca_id')
            ->select('clientes_sistemas_preventivos.*', 'clientes.name as clienteName', 'medidas_seguranca.name as medidaSegurancaName')
            ->where('clientes_sistemas_preventivos.sistema_preventivo_numero', $sistema_preventivo_numero)
            ->first();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }
}
