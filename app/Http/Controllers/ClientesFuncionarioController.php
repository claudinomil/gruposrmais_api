<?php

namespace App\Http\Controllers;

use App\Models\DocumentoFonte;
use App\Models\Funcionario;
use App\Models\FuncionarioDocumento;
use App\Models\FuncionarioDocumentoMensal;
use Illuminate\Http\Request;

class ClientesFuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $cliente_id = $request->header('X-Cliente-Id');

        $registros = Funcionario
            ::leftJoin('departamentos', 'departamentos.id', 'funcionarios.departamento_id')
            ->leftJoin('funcoes', 'funcoes.id', 'funcionarios.funcao_id')
            ->select(['funcionarios.*', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName'])
            ->where('funcionarios.tomador_servico_cliente_id', $cliente_id)
            ->orderby('funcionarios.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        $registro = Funcionario
            ::leftJoin('empresas', 'empresas.id', 'funcionarios.empresa_id')
            ->leftJoin('identidade_orgaos', 'identidade_orgaos.id', 'funcionarios.personal_identidade_orgao_id')
            ->leftJoin('estados', 'estados.id', 'funcionarios.personal_identidade_estado_id')
            ->leftJoin('generos', 'generos.id', 'funcionarios.genero_id')
            ->leftJoin('contratacao_tipos', 'contratacao_tipos.id', 'funcionarios.contratacao_tipo_id')
            ->leftJoin('departamentos', 'departamentos.id', 'funcionarios.departamento_id')
            ->leftJoin('funcoes', 'funcoes.id', 'funcionarios.funcao_id')
            ->leftJoin('escolaridades', 'escolaridades.id', 'funcionarios.escolaridade_id')
            ->leftJoin('estados_civis', 'estados_civis.id', 'funcionarios.estado_civil_id')
            ->leftJoin('bancos', 'bancos.id', 'funcionarios.banco_id')
            ->leftJoin('clientes as tomador_servico_clientes', 'tomador_servico_clientes.id', 'funcionarios.tomador_servico_cliente_id')
            ->select([
                'funcionarios.*',
                'empresas.name as empresaName',
                'identidade_orgaos.name as identidadeOrgaoName',
                'estados.name as identidadeEstadoName',
                'generos.name as generoName',
                'contratacao_tipos.name as contratacaoTipoName',
                'estados_civis.name as estadoCivilName',
                'bancos.name as bancoName',
                'departamentos.name as departamentoName',
                'funcoes.name as funcaoName',
                'tomador_servico_clientes.name as tomadorServicoClienteName'
            ])
            ->where('funcionarios.id', $id)
            ->get()[0];

        if (!$registro) {
            return $this->sendResponse('Registro não encontrado.', 4040, null, null);
        } else {
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        }
    }

    public function filter(Request $request, $array_dados)
    {
        $cliente_id = $request->header('X-Cliente-Id');

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Funcionario
            ::leftJoin('departamentos', 'departamentos.id', 'funcionarios.departamento_id')
            ->leftJoin('funcoes', 'funcoes.id', 'funcionarios.funcao_id')
            ->select(['funcionarios.*', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName'])
            ->orderby('funcionarios.name')
            ->where('funcionarios.tomador_servico_cliente_id', $cliente_id)
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

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function modal_info($id)
    {
        try {
            $registro = array();

            // Funcionario
            $funcionario = Funcionario
                ::leftJoin('empresas', 'empresas.id', 'funcionarios.empresa_id')
                ->leftJoin('identidade_orgaos', 'identidade_orgaos.id', 'funcionarios.personal_identidade_orgao_id')
                ->leftJoin('estados', 'estados.id', 'funcionarios.personal_identidade_estado_id')
                ->leftJoin('generos', 'generos.id', 'funcionarios.genero_id')
                ->leftJoin('contratacao_tipos', 'contratacao_tipos.id', 'funcionarios.contratacao_tipo_id')
                ->leftJoin('departamentos', 'departamentos.id', 'funcionarios.departamento_id')
                ->leftJoin('funcoes', 'funcoes.id', 'funcionarios.funcao_id')
                ->leftJoin('escolaridades', 'escolaridades.id', 'funcionarios.escolaridade_id')
                ->leftJoin('estados_civis', 'estados_civis.id', 'funcionarios.estado_civil_id')
                ->leftJoin('bancos', 'bancos.id', 'funcionarios.banco_id')
                ->leftJoin('clientes as tomador_servico_clientes', 'tomador_servico_clientes.id', 'funcionarios.tomador_servico_cliente_id')
                ->select([
                    'funcionarios.*',
                    'empresas.name as empresaName',
                    'identidade_orgaos.name as identidadeOrgaoName',
                    'estados.name as identidadeEstadoName',
                    'generos.name as generoName',
                    'contratacao_tipos.name as contratacaoTipoName',
                    'estados_civis.name as estadoCivilName',
                    'bancos.name as bancoName',
                    'departamentos.name as departamentoName',
                    'funcoes.name as funcaoName',
                    'tomador_servico_clientes.name as tomadorServicoClienteName'
                ])
                ->where('funcionarios.id', '=', $id)
                ->get()[0];

            $registro['funcionario'] = $funcionario;

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
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

    public function documentos_mensais($funcionario_id)
    {
        try {
            $registros = array();

            $registros['funcionarios_documentos_mensais'] = FuncionarioDocumentoMensal
                ::join('documentos_mensais_funcionarios', 'funcionarios_documentos_mensais.documento_mensal_funcionario_id', 'documentos_mensais_funcionarios.id')
                ->select('funcionarios_documentos_mensais.*', 'documentos_mensais_funcionarios.name as documentoMensalName')
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
}
