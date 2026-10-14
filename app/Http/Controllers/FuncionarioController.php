<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Http\Requests\EntregaUniformeStoreRequest;
use App\Http\Requests\EntregaUniformeUpdateRequest;
use App\Http\Requests\FuncionarioStoreRequest;
use App\Http\Requests\FuncionarioUpdateRequest;
use App\Models\AtestadoSaudeOcupacionalTipo;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Empresa;
use App\Models\Genero;
use App\Models\ContratacaoTipo;
use App\Models\IdentidadeOrgao;
use App\Models\EstadoCivil;
use App\Models\MotivoAfastamento;
use App\Models\MotivoDemissao;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Funcao;
use App\Models\Banco;
use App\Models\DocumentoMensalFuncionario;
use App\Models\Escolaridade;
use App\Models\Estado;
use App\Models\PixTipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use App\Models\FuncionarioDocumento;
use App\Models\FuncionarioDocumentoExigido;
use App\Models\FuncionarioDocumentoMensal;
use App\Models\EntregaUniforme;
use App\Models\EntregaUniformeDado;
use App\Models\GrupoPermissao;
use App\Models\Uniforme;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FuncionarioController extends Controller
{
    private $funcionario;

    public function __construct(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    public function index()
    {
        $registros = DB::table('funcionarios')
            ->leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
            ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
            ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
            ->leftJoin('contratacao_tipos', 'funcionarios.contratacao_tipo_id', '=', 'contratacao_tipos.id')
            ->leftJoin('departamentos', 'funcionarios.departamento_id', '=', 'departamentos.id')
            ->leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
            ->leftJoin('escolaridades', 'funcionarios.escolaridade_id', '=', 'escolaridades.id')
            ->leftJoin('estados_civis', 'funcionarios.estado_civil_id', '=', 'estados_civis.id')
            ->leftJoin('bancos', 'funcionarios.banco_id', '=', 'bancos.id')
            ->leftJoin('clientes as tomador_servico_clientes', 'funcionarios.tomador_servico_cliente_id', '=', 'tomador_servico_clientes.id')
            ->select(['funcionarios.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'contratacao_tipos.name as contratacaoTipoName', 'estados_civis.name as estado_civilName', 'bancos.name as bancoName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName', 'tomador_servico_clientes.name as tomadorServicoClienteName'])
            ->where(function ($query) {
                $query->where('funcionarios.data_demissao', '')
                    ->orWhereNull('funcionarios.data_demissao');
            })
            ->where(function ($query) {
                $query->where('funcionarios.data_afastamento', '')
                    ->orWhereNull('funcionarios.data_afastamento');
            })
            ->orderby('funcionarios.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = Funcionario
                ::leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->select(['funcionarios.*', 'funcoes.name as funcaoName'])
                ->where('funcionarios.id', '=', $id)
                ->get()[0];

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

            //Contratação Tipos
            $registros['contratacao_tipos'] = ContratacaoTipo::all();

            //Bancos
            $registros['bancos'] = Banco::all();

            //Estados Civis
            $registros['estados_civis'] = EstadoCivil::all();

            //Escolaridades
            $registros['escolaridades'] = Escolaridade::all();

            //Nacionalidades
            $registros['nacionalidades'] = Nacionalidade::all();

            //Naturalidades
            $registros['naturalidades'] = Naturalidade::all();

            //Órgãos Identidades
            $registros['identidade_orgaos'] = IdentidadeOrgao::all();

            //Estados para a Identidade
            $registros['identidade_estados'] = Estado::all();

            //Departamentos
            $registros['departamentos'] = Departamento::all();

            //Funções
            $registros['funcoes'] = Funcao::orderby('name')->get();

            // Tomadores de Serviços
            $registros['tomadores_servicos'] = Cliente::join('funcionarios', 'funcionarios.tomador_servico_cliente_id', 'clientes.id')
                ->select('clientes.*')
                ->distinct('clientes.*')
                ->orderby('clientes.name')
                ->get();

            //Clientes
            $registros['clientes'] = Cliente::orderby('name')->get();

            // Funcionários
            $registros['funcionarios'] = Funcionario::orderby('name')->get();

            // Uniformes
            $registros['uniformes'] = Uniforme::orderby('name')->get();

            //PIX Tipos
            $registros['pix_tipos'] = PixTipo::all();

            //aTESTADO sAÚDE oCUPACIONAL tIPOS
            $registros['atestado_saude_ocupacional_tipos'] = AtestadoSaudeOcupacionalTipo::all();

            //Empresas
            $registros['empresas'] = Empresa::all();

            //Documentos
            $registros['documentos'] = Documento::join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('documentos.*', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('documentos.documento_submodulo_id', 2)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->get();

            //Motivos Demissoes
            $registros['motivos_demissoes'] = MotivoDemissao::all();

            //Motivos Afastamentos
            $registros['motivos_afastamentos'] = MotivoAfastamento::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(FuncionarioStoreRequest $request)
    {
        try {
            //Incluindo registro
            $this->funcionario->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(FuncionarioUpdateRequest $request, $id)
    {
        try {
            $registro = $this->funcionario->find($id);

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
            $registro = $this->funcionario->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela users
                if (SuporteFacade::verificarRelacionamento('users', 'funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Usuários.', 2040, null, null);
                }

                //Tabela funcionarios_documentos
                if (SuporteFacade::verificarRelacionamento('funcionarios_documentos', 'funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Funcionários Documentos.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Apagar dados na tabela funcionarios_documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                FuncionarioDocumento::where('funcionario_id', '=', $id)->delete();
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
        $registros = $this->funcionario
            ->leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
            ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
            ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
            ->leftJoin('contratacao_tipos', 'funcionarios.contratacao_tipo_id', '=', 'contratacao_tipos.id')
            ->leftJoin('departamentos', 'funcionarios.departamento_id', '=', 'departamentos.id')
            ->leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
            ->leftJoin('escolaridades', 'funcionarios.escolaridade_id', '=', 'escolaridades.id')
            ->leftJoin('estados_civis', 'funcionarios.estado_civil_id', '=', 'estados_civis.id')
            ->leftJoin('bancos', 'funcionarios.banco_id', '=', 'bancos.id')
            ->leftJoin('clientes as tomador_servico_clientes', 'funcionarios.tomador_servico_cliente_id', '=', 'tomador_servico_clientes.id')
            ->select(['funcionarios.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'contratacao_tipos.name as contratacaoTipoName', 'estados_civis.name as estado_civilName', 'bancos.name as bancoName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName', 'tomador_servico_clientes.name as tomadorServicoClienteName'])
            ->orderby('funcionarios.name')
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

    public function cartoes_emergenciais_registros()
    {
        $registros = $this->funcionario->orderby('id')->get(['id']);

        return response()->json($registros, 200);
    }

    public function cartoes_emergenciais_dados($ids)
    {
        try {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $registros = Funcionario
                ::leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                ->select(['funcionarios.*', 'generos.name as generoName'])
                ->wherein('funcionarios.id', $ids)
                ->get();

            if (!$registros) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $registros);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function modal_info(int $id)
    {
        try {
            $registro = array();

            //Funcionario
            $funcionario = Funcionario
                ::leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                ->leftJoin('empresas', 'funcionarios.empresa_id', '=', 'empresas.id')
                ->leftJoin('departamentos', 'funcionarios.departamento_id', '=', 'departamentos.id')
                ->leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->leftJoin('estados_civis', 'funcionarios.estado_civil_id', '=', 'estados_civis.id')
                ->leftJoin('clientes as tomador_servico_clientes', 'funcionarios.tomador_servico_cliente_id', '=', 'tomador_servico_clientes.id')
                ->leftJoin('contratacao_tipos', 'funcionarios.contratacao_tipo_id', '=', 'contratacao_tipos.id')
                ->select([
                    'funcionarios.*',
                    'generos.name as generoName',
                    'empresas.name as empresaName',
                    'departamentos.name as departamentoName',
                    'funcoes.name as funcaoName',
                    'tomador_servico_clientes.name as tomadorServicoName',
                    'contratacao_tipos.name as contratacaoTipoName',
                    'estados_civis.name as estado_civilName'
                ])
                ->where('funcionarios.id', '=', $id)
                ->get();

            $registro['funcionario'] = $funcionario[0];

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function estatisticas(int $id)
    {
        try {
            $registro = array();

            //Documentos
            $registro['documentos'] = FuncionarioDocumento::where('funcionario_id', '=', $id)->count();

            // Documentos Mensais
            $registro['documentos_mensais'] = FuncionarioDocumentoMensal::where('funcionario_id', '=', $id)->count();

            // Documentos Exigidos
            $registro['documentos_exigidos'] = FuncionarioDocumentoExigido::where('funcionario_id', $id)->count();

            // Entregas Uniformes
            $registro['entregas_uniformes'] = EntregaUniformeDado::where('funcionario_id', $id)->distinct('entrega_uniforme_id')->count();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_fotografia_documento(Request $request)
    {
        try {
            $registro = $this->funcionario->find($request['funcionario_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->fotografia_documento = $request['fotografia_documento'];
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

    public function upload_fotografia_cartao_emergencial(Request $request)
    {
        try {
            $registro = $this->funcionario->find($request['funcionario_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->fotografia_cartao_emergencial = $request['fotografia_cartao_emergencial'];
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

    public function editar_documento(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'operacao' => ['required'],
                'funcionario_id' => ['required'],
                'documento_id' => ['required'],
                'data_emissao' => ['nullable', 'date_format:d/m/Y'],
                'data_vencimento' => ['nullable', 'date_format:d/m/Y'],
            ], [
                'operacao.required' => 'A operação é obrigatória.',
                'funcionario_id.required' => 'O funcionario é obrigatório.',
                'documento_id.required' => 'O documento é obrigatório.',
                'data_emissao.date_format' => 'A data de emissão é inválida.',
                'data_vencimento.date_format' => 'A data de vencimento é inválida.',
            ]);

            // Se falhar retorna
            if ($validator->fails()) {
                $mensagens = implode("<br>", $validator->errors()->all());

                return $this->sendResponse($mensagens, 2020, null, $request);
            }

            if ($request['operacao'] == 'create') {
                // Incluir Registro
                FuncionarioDocumento::create($request->all());

                // Transação
                Transacoes::transacaoRecord(3, 1, 'funcionarios', $request, $request);
            } else if ($request['operacao'] == 'edit') {
                // Buscando Registro
                $registro = FuncionarioDocumento::find($request['funcionario_documento_id']);

                // Dados Anterior
                $dadosAnterior = $registro;

                // Alterando registro
                $registro->update($request->all());

                // Transação
                Transacoes::transacaoRecord(3, 2, 'funcionarios', $dadosAnterior, $request);
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

    public function documentos(int $funcionario_id)
    {
        try {
            $registros = array();

            $registros['permissoes'] = GrupoPermissao::join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                ->select('permissoes.name as permissao')
                ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                ->where(function ($query) {
                    $query->where('permissoes.name', 'like', 'funcionarios_list%')
                        ->orWhere('permissoes.name', 'like', 'funcionarios_show%')
                        ->orWhere('permissoes.name', 'like', 'funcionarios_edit%')
                        ->orWhere('permissoes.name', 'like', 'funcionarios_destroy%');
                })
                ->get();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['funcionarios_documentos'] = FuncionarioDocumento::join('documentos', 'funcionarios_documentos.documento_id', 'documentos.id')
                ->join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('funcionarios_documentos.*', 'documentos.documento_fonte_id', 'documentos.name as documentoName', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('funcionarios_documentos.funcionario_id', $funcionario_id)
                ->orderby('documento_fontes.ordem', 'ASC')
                ->orderby('documentos.ordem', 'ASC')
                ->orderBy('funcionarios_documentos.data_emissao', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function entregas_uniformes(int $funcionario_id)
    {
        try {
            $data = array();

            $data['entregas'] = EntregaUniforme::join('entregas_uniformes_dados', 'entregas_uniformes_dados.entrega_uniforme_id', 'entregas_uniformes.id')
                ->select('entregas_uniformes.*')
                ->where('entregas_uniformes_dados.funcionario_id', $funcionario_id)
                ->distinct('entregas_uniformes.id')
                ->orderby('entregas_uniformes.numero_entrega', 'ASC')
                ->get();

            $data['entregas_dados'] = EntregaUniformeDado::join('uniformes', 'uniformes.id', 'entregas_uniformes_dados.uniforme_id')
                ->select('entregas_uniformes_dados.*', 'uniformes.name as uniformeName')
                ->where('entregas_uniformes_dados.funcionario_id', $funcionario_id)
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $data);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_documento(int $funcionario_documento_id)
    {
        $registro = FuncionarioDocumento::find($funcionario_documento_id);

        if (!$registro) {
            return $this->sendResponse('Documento não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(2, 3, 'funcionarios', $registro, $registro);

            //Return
            return $this->sendResponse('Documento excluído com sucesso.', 2000, null, $registro['caminho']);
        }
    }

    public function upload_documento_mensal(Request $request)
    {
        try {
            // Campos para identificar o registro
            $where = [
                'funcionario_id' => $request['funcionario_id'],
                'mes' => $request['mes'],
                'ano' => $request['ano'],
                'documento_mensal_funcionario_id' => $request['documento_mensal_funcionario_id'],
            ];

            // Tenta encontrar registro existente
            $registro = FuncionarioDocumentoMensal::where($where)->first();

            if ($registro) {
                // Atualiza o registro existente
                $registro->update($request->all());
            } else {
                // Cria novo registro
                FuncionarioDocumentoMensal::create($request->all());
            }

            // Transação
            Transacoes::transacaoRecord(4, 1, 'funcionarios', $request, $request);

            // Return
            return $this->sendResponse('Documento Mensal enviado com sucesso.', 2000, null, $request);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function verificar_documentos_mensais(int $funcionario_id, string $mes, string $ano)
    {
        try {
            $registros = array();

            $registros['documentos_mensais'] = DocumentoMensalFuncionario::orderby('ordem', 'ASC')->get();

            $registros['verificar_documentos_mensais'] = FuncionarioDocumentoMensal
                ::join('documentos_mensais_funcionarios', 'funcionarios_documentos_mensais.documento_mensal_funcionario_id', 'documentos_mensais_funcionarios.id')
                ->select('funcionarios_documentos_mensais.*', 'documentos_mensais_funcionarios.name as documentoMensalName')
                ->where('funcionarios_documentos_mensais.funcionario_id', $funcionario_id)
                ->where('funcionarios_documentos_mensais.mes', $mes)
                ->where('funcionarios_documentos_mensais.ano', $ano)
                ->orderby('documentos_mensais_funcionarios.ordem', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function documentos_mensais($funcionario_id)
    {
        try {
            $registros = array();

            $registros['permissoes'] = GrupoPermissao
                ::join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                ->select('permissoes.name as permissao')
                ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                ->where('permissoes.name', 'like', 'funcionarios_%')
                ->get();

            $registros['funcionarios_documentos_mensais'] = FuncionarioDocumentoMensal
                ::join('documentos_mensais_funcionarios', 'funcionarios_documentos_mensais.documento_mensal_funcionario_id', 'documentos_mensais_funcionarios.id')
                ->select(
                    'funcionarios_documentos_mensais.*',
                    'documentos_mensais_funcionarios.name as documentoMensalName'
                )
                ->where('funcionarios_documentos_mensais.funcionario_id', $funcionario_id)
                ->orderby('funcionarios_documentos_mensais.ano', 'DESC')
                ->orderby('funcionarios_documentos_mensais.mes', 'DESC')
                ->orderby('documentos_mensais_funcionarios.ordem', 'ASC')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_documento_mensal($funcionario_documento_mensal_id)
    {
        $registro = FuncionarioDocumentoMensal::find($funcionario_documento_mensal_id);

        if (!$registro) {
            return $this->sendResponse('Documento Mensal não encontrado.', 4040, null, $registro);
        } else {
            //Deletar
            $registro->delete();

            //gravar transacao
            Transacoes::transacaoRecord(4, 3, 'funcionarios', $registro, $registro);

            //Return
            return $this->sendResponse('Documento Mensal excluído com sucesso.', 2000, null, $registro['caminho']);
        }
    }

    public function documentos_exigidos(int $funcionario_id)
    {
        try {
            $registros = array();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['funcionarios_documentos_exigidos'] = FuncionarioDocumentoExigido::join('documentos', 'documentos.id', '=', 'funcionarios_documentos_exigidos.documento_id')
                ->join('documento_submodulos', 'documento_submodulos.id', '=', 'documentos.documento_submodulo_id')
                ->join('documento_fontes', 'documento_fontes.id', '=', 'documentos.documento_fonte_id')
                ->leftJoin('funcionarios_documentos', function ($join) {
                    $join->on('funcionarios_documentos.documento_id', '=', 'funcionarios_documentos_exigidos.documento_id')
                        ->on('funcionarios_documentos.funcionario_id', '=', 'funcionarios_documentos_exigidos.funcionario_id');
                })
                ->select(
                    'funcionarios_documentos_exigidos.*',
                    'documentos.documento_fonte_id',
                    'documentos.name as documentoName',
                    'documento_submodulos.name as documentoSubmoduloName',
                    'documento_fontes.name as documentoFonteName',
                    'funcionarios_documentos.caminho as funcionarioDocumentoCaminho'
                )
                ->where('funcionarios_documentos_exigidos.funcionario_id', $funcionario_id)
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
                'editar_documentos_exigidos_funcionario_id' => 'required|integer',
                'editar_documentos_exigidos_documentos_exigidos' => 'nullable|array',
                'editar_documentos_exigidos_documentos_exigidos.*' => 'integer',
            ]);

            $funcionarioId = $request->input('editar_documentos_exigidos_funcionario_id');

            // Se não vier nada, considera array vazio
            $documentosIds = $request->input('editar_documentos_exigidos_documentos_exigidos', []);

            // IDs atualmente registrados
            $documentosExistentes = FuncionarioDocumentoExigido::where('funcionario_id', $funcionarioId)->pluck('documento_id')->toArray();

            // Calcula diferenças
            $novos = array_diff($documentosIds, $documentosExistentes);
            $removidos = array_diff($documentosExistentes, $documentosIds);

            // Inserir novos
            if (!empty($novos)) {
                $dados = collect($novos)
                    ->map(fn($id) => [
                        'funcionario_id' => $funcionarioId,
                        'documento_id' => $id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                    ->toArray();

                FuncionarioDocumentoExigido::insert($dados);
            }

            // Remover desmarcados
            if (!empty($removidos)) {
                FuncionarioDocumentoExigido::where('funcionario_id', $funcionarioId)
                    ->whereIn('documento_id', $removidos)
                    ->delete();
            }

            return $this->sendResponse(
                'Documentos exigidos sincronizados com sucesso.',
                2010,
                null,
                null
            );
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse(
                'Houve um erro ao realizar a operação.',
                5000,
                null,
                null
            );
        }
    }

    public function documentos_vencidos()
    {
        $registros = FuncionarioDocumento::join('funcionarios', 'funcionarios.id', 'funcionarios_documentos.funcionario_id')
            ->select([
                'funcionarios.id as funcionarioId',
                'funcionarios.name as funcionarioName',
                'funcionarios.cpf as funcionarioCpf',
                'funcionarios_documentos.data_vencimento'
            ])
            ->where('funcionarios_documentos.data_vencimento', '<', date('Y-m-d'))
            ->orderBy('funcionarios.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    // Ação 1: Entregas de Uniformes - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Ação 1: Entregas de Uniformes - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function entregas_uniformes_index()
    {
        try {
            $registros = EntregaUniforme::orderby('numero_entrega')->get();

            return $this->sendResponse('Dados Estatísticas.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function entregas_uniformes_show($id)
    {
        try {
            $data = array();

            $registro = EntregaUniforme::find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado. xxx:'.$id, 4040, null, null);
            }

            $data['entrega'] = $registro;

            $data['entrega_dados'] = EntregaUniformeDado::where('entrega_uniforme_id', $id)
                ->orderby('funcionario_nome')
                ->orderby('uniforme_nome')
                ->get();

            return $this->sendResponse('Registro encontrado.', 2000, null, $data);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function entregas_uniformes_store(EntregaUniformeStoreRequest $request)
    {
        try {
            $dados = $request->validated();
            $uniformes = $dados['uniformes'];
            unset($dados['uniformes']);

            DB::transaction(function () use ($dados, $uniformes, &$registro) {
                // Inclusão Prncipal
                $registro = EntregaUniforme::create($dados);

                // Inclusão Grade
                foreach ($uniformes as $uniforme) {
                    EntregaUniformeDado::create([
                        'entrega_uniforme_id' => $registro->id,
                        'funcionario_id' => $uniforme['funcionario_id'],
                        'funcionario_nome' => $uniforme['funcionario_nome'],
                        'uniforme_id' => $uniforme['uniforme_id'],
                        'uniforme_nome' => $uniforme['uniforme_nome'],
                        'quantidade' => $uniforme['quantidade'],
                        'tamanho' => $uniforme['tamanho'],
                        'data_entrega' => $uniforme['data_entrega'] ?? null,
                    ]);
                }
            });

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function entregas_uniformes_update(EntregaUniformeUpdateRequest $request, int $id)
    {
        try {
            $dados = $request->validated();
            $uniformes = $dados['uniformes'];
            unset($dados['uniformes']);

            DB::transaction(function () use ($dados, $uniformes, $id, &$registro) {
                // Localiza o registro principal
                $registro = EntregaUniforme::findOrFail($id);

                // Atualiza o registro principal
                $registro->update($dados);

                // Remove a grade atual
                EntregaUniformeDado::where('entrega_uniforme_id', $registro->id)->delete();

                // Recria a grade
                foreach ($uniformes as $uniforme) {
                    EntregaUniformeDado::create([
                        'entrega_uniforme_id' => $registro->id,
                        'funcionario_id' => $uniforme['funcionario_id'],
                        'funcionario_nome' => $uniforme['funcionario_nome'],
                        'uniforme_id' => $uniforme['uniforme_id'],
                        'uniforme_nome' => $uniforme['uniforme_nome'],
                        'quantidade' => $uniforme['quantidade'],
                        'tamanho' => $uniforme['tamanho'],
                        'data_entrega' => $uniforme['data_entrega'] ?? null,
                    ]);
                }
            });

            return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function entregas_uniformes_destroy(int $id)
    {
        try {
            $registro = EntregaUniforme::find($id);
            $dados = EntregaUniformeDado::where('entrega_uniforme_id', $id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            }

            DB::transaction(function () use ($registro, $dados) {
                $dados->delete();
                $registro->delete();
            });

            return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function entregas_uniformes_dados_estatisticas()
    {
        try {
            $data = array();
            $data['total_entregas_realizadas'] = EntregaUniforme::count();

            return $this->sendResponse('Dados Estatísticas.', 2000, null, $data);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function recibo_funcionario(int $entrega_uniforme_id, int $funcionario_id)
    {
        try {
            $registros = EntregaUniforme::join('entregas_uniformes_dados', 'entregas_uniformes_dados.entrega_uniforme_id', 'entregas_uniformes.id')
                ->join('funcionarios', 'funcionarios.id', 'entregas_uniformes_dados.funcionario_id')
                ->join('uniformes', 'uniformes.id', 'entregas_uniformes_dados.uniforme_id')
                ->leftjoin('clientes as tomadores_servicos', 'tomadores_servicos.id', 'funcionarios.tomador_servico_cliente_id')
                ->leftjoin('funcoes', 'funcoes.id', 'funcionarios.funcao_id')
                ->select(
                    'entregas_uniformes_dados.funcionario_nome as entregaUniformeDadoFuncionarioNome',
                    'entregas_uniformes_dados.uniforme_nome as entregaUniformeDadoUniformeNome',
                    'entregas_uniformes_dados.quantidade as entregaUniformeDadoQuantidade',
                    'entregas_uniformes_dados.tamanho as entregaUniformeDadoTamanho',
                    'entregas_uniformes_dados.data_entrega as entregaUniformeDadoDataEntrega',
                    'funcionarios.name as funcionarioName',
                    'funcionarios.cpf as funcionarioCpf',
                    'tomadores_servicos.name as tomadorServicoClienteName',
                    'funcoes.name as funcaoName',
                    'uniformes.name as uniformeName'
                )
                ->where('entregas_uniformes_dados.entrega_uniforme_id', $entrega_uniforme_id)
                ->where('entregas_uniformes_dados.funcionario_id', $funcionario_id)
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Ação 1: Entregas de Uniformes - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Ação 1: Entregas de Uniformes - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
