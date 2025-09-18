<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
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
use App\Models\Escolaridade;
use App\Models\Estado;
use App\Models\PixTipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use App\Models\FuncionarioDocumento;

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
            $registros['funcoes'] = Funcao::all();

            //Clientes
            $registros['clientes'] = Cliente::all();

            //PIX Tipos
            $registros['pix_tipos'] = PixTipo::all();

            //aTESTADO sAÚDE oCUPACIONAL tIPOS
            $registros['atestado_saude_ocupacional_tipos'] = AtestadoSaudeOcupacionalTipo::all();

            //Empresas
            $registros['empresas'] = Empresa::all();

            //Documentos
            $registros['documentos'] = Documento
                ::join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
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

    public function funcionario_acao_1_gerar_pdf_dados($funcionarios_ids)
    {
        try {
            //Limpar Querys executadas
            //DB::enableQueryLog();

            // Converter a string em um array de inteiros
            $ids_array = array_map('intval', explode(',', $funcionarios_ids));

            $registros = Funcionario
                ::leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
                ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
                ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                ->leftJoin('contratacao_tipos', 'funcionarios.contratacao_tipo_id', '=', 'contratacao_tipos.id')
                ->leftJoin('departamentos', 'funcionarios.departamento_id', '=', 'departamentos.id')
                ->leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->leftJoin('escolaridades', 'funcionarios.escolaridade_id', '=', 'escolaridades.id')
                ->leftJoin('estados_civis', 'funcionarios.estado_civil_id', '=', 'estados_civis.id')
                ->leftJoin('bancos', 'funcionarios.banco_id', '=', 'bancos.id')
                ->select(['funcionarios.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'contratacao_tipos.name as contratacaoTipoName', 'estados_civis.name as estado_civilName', 'bancos.name as bancoName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName'])
                ->whereIn('funcionarios.id', $ids_array)
                ->get();


        //Código SQL Bruto
        //$sql = DB::getQueryLog();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function funcionario_acao_1_grade_funcionarios()
    {
        try {
            $registros = Funcionario
                ::leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
                ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
                ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                ->leftJoin('contratacao_tipos', 'funcionarios.contratacao_tipo_id', '=', 'contratacao_tipos.id')
                ->leftJoin('departamentos', 'funcionarios.departamento_id', '=', 'departamentos.id')
                ->leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->leftJoin('escolaridades', 'funcionarios.escolaridade_id', '=', 'escolaridades.id')
                ->leftJoin('estados_civis', 'funcionarios.estado_civil_id', '=', 'estados_civis.id')
                ->leftJoin('bancos', 'funcionarios.banco_id', '=', 'bancos.id')
                ->select(['funcionarios.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'contratacao_tipos.name as contratacaoTipoName', 'estados_civis.name as estado_civilName', 'bancos.name as bancoName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName'])
                ->orderBy('funcionarios.name')
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
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

    public function modal_info($id)
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
                ->select(['funcionarios.*', 'generos.name as generoName', 'empresas.name as empresaName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName', 'tomador_servico_clientes.name as tomadorServicoName', 'contratacao_tipos.name as contratacaoTipoName', 'estados_civis.name as estado_civilName'])
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

    public function estatisticas($id)
    {
        try {
            $registro = array();

            //Documentos
            $documentos = FuncionarioDocumento
                ::where('funcionario_id', '=', $id)
                ->count();

            $registro['documentos'] = $documentos;

            //Tomadores de Serviços
            $tomadores_servicos = 999;

            $registro['tomadores_servicos'] = $tomadores_servicos;

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

    public function upload_documento(Request $request)
    {
        try {
            //Incluir Registro
            if ($request['acao'] == 1) {
                //Registro
                FuncionarioDocumento::create($request->all());

                //Transação
                Transacoes::transacaoRecord(2, 1, 'funcionarios', $request, $request);

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

    public function documentos($funcionario_id)
    {
        try {
            $registros = array();

            $registros['documento_fontes'] = DocumentoFonte::orderby('ordem', 'ASC')->get();

            $registros['funcionarios_documentos'] = FuncionarioDocumento
                ::join('documentos', 'funcionarios_documentos.documento_id', 'documentos.id')
                ->join('documento_submodulos', 'documentos.documento_submodulo_id', 'documento_submodulos.id')
                ->join('documento_fontes', 'documentos.documento_fonte_id', 'documento_fontes.id')
                ->select('funcionarios_documentos.*', 'documentos.documento_fonte_id', 'documentos.name as documentoName', 'documento_submodulos.name as documentoSubmoduloName', 'documento_fontes.name as documentoFonteName')
                ->where('funcionarios_documentos.funcionario_id', $funcionario_id)
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

    public function deletar_documento($funcionario_documento_id)
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

    public function tomadores_servicos($funcionario_id)
    {
        try {
            $registros = array();

            //Tomadores de Serviços
            $registros['tomadores_servicos'] = [];

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
