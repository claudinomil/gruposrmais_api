<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Http\Requests\FuncionarioStoreRequest;
use App\Http\Requests\FuncionarioUpdateRequest;
use App\Models\ClienteExecutivo;
use App\Models\Departamento;
use App\Models\Genero;
use App\Models\ContratacaoTipo;
use App\Models\IdentidadeOrgao;
use App\Models\EstadoCivil;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Funcao;
use App\Models\Banco;
use App\Models\Escolaridade;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use App\Models\FuncionarioDocumento;

class GuestController extends Controller
{
    public function validar_cartao_emergencial($submodulo, $id)
    {
        try {
            if ($submodulo == 'clientes_executivos') {
                $registro = ClienteExecutivo::where('id', '=', $id)->get()[0];
            }

            if ($submodulo == 'funcionarios') {
                $registro = Funcionario
                    ::leftJoin('nacionalidades', 'funcionarios.nacionalidade_id', 'nacionalidades.id')
                    ->leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
                    ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
                    ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                    ->select(['funcionarios.*', 'nacionalidades.name as nacionalidadeName', 'identidade_orgaos.name as identidadeOrgaoName', 'estados.name as identidadeEstadoName', 'generos.name as generoName'])
                    ->where('funcionarios.id', '=', $id)
                    ->get()[0];
            }

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 2040, null, null);
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

    public function auxiliary($empresa_id)
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
            $registros['departamentos'] = Departamento::where('empresa_id', '=', $empresa_id)->get();

            //Funções
            $registros['funcoes'] = Funcao::where('empresa_id', '=', $empresa_id)->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(FuncionarioStoreRequest $request, $empresa_id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($empresa_id);

            //Colocar empresa_id no Request
            $request['empresa_id'] = $empresa_id;

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

    public function update(FuncionarioUpdateRequest $request, $id, $empresa_id)
    {
        try {
            $registro = $this->funcionario->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

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

    public function destroy($id, $empresa_id)
    {
        try {
            $registro = $this->funcionario->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Atualisar objeto Auth::user()
                SuporteFacade::setUserLogged($empresa_id);

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela users
                if (SuporteFacade::verificarRelacionamento('users', 'funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Usuários.', 2040, null, null);
                }

                //Tabela funcionarios_documentos
                if (SuporteFacade::verificarRelacionamento('funcionarios_documentos', 'funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Funcionários Documentos.', 2040, null, null);
                }

                //Tabela clientes_servicos
                if (SuporteFacade::verificarRelacionamento('clientes_servicos', 'responsavel_funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Clientes Serviços.', 2040, null, null);
                }

                //Tabela brigadas_escalas
                if (SuporteFacade::verificarRelacionamento('brigadas_escalas', 'funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Brigadas Escalas.', 2040, null, null);
                }

                //Tabela cliente_servicos_brigadistas
                if (SuporteFacade::verificarRelacionamento('cliente_servicos_brigadistas', 'funcionario_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Cliente Serviços Brigadistas.', 2040, null, null);
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

    public function filter($array_dados, $empresa_id)
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
            ->select(['funcionarios.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'contratacao_tipos.name as contratacaoTipoName', 'estados_civis.name as estado_civilName', 'bancos.name as bancoName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName'])
            ->where('funcionarios.empresa_id', '=', $empresa_id)
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

    public function modal_info($id)
    {
        try {
            $registro = array();

            //Funcionario
            $funcionario = Funcionario
                ::leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
                ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
                ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                ->leftJoin('departamentos', 'funcionarios.departamento_id', '=', 'departamentos.id')
                ->leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->leftJoin('escolaridades', 'funcionarios.escolaridade_id', '=', 'escolaridades.id')
                ->leftJoin('estados_civis', 'funcionarios.estado_civil_id', '=', 'estados_civis.id')
                ->leftJoin('bancos', 'funcionarios.banco_id', '=', 'bancos.id')
                ->select(['funcionarios.*', 'identidade_orgaos.name as identidade_orgaosName', 'estados.name as identidadeEstadoName', 'generos.name as generoName', 'estados_civis.name as estado_civilName', 'bancos.name as bancoName', 'departamentos.name as departamentoName', 'funcoes.name as funcaoName'])
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

    public function upload_foto(Request $request, $id)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($request['empresa_id']);

            $registro = $this->funcionario->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                //Transação
                $dadosAtual = array();
                $dadosAtual['empresa_id'] = $request['empresa_id'];
                $dadosAtual['name'] = $request['name'];
                $dadosAtual['foto'] = 'Foto atualizada';

                Transacoes::transacaoRecord(3, 2, 'funcionarios', $request, $dadosAtual);

                //Return
                return $this->sendResponse('Foto atualizada com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_documento_pdf(Request $request)
    {
        try {
            //Atualisar objeto Auth::user()
            SuporteFacade::setUserLogged($request['empresa_id']);

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

    public function documentos_pdf($funcionario_id)
    {
        try {
            $registros = FuncionarioDocumento
                ::where('funcionario_id', $funcionario_id)
                ->get();

            return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function deletar_documento_pdf($funcionario_documento_id, $empresa_id)
    {
        //Atualisar objeto Auth::user()
        SuporteFacade::setUserLogged($empresa_id);

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

    public function funcionario_acao_1_gerar_pdf_dados($funcionarios_ids, $empresa_id)
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
                ->where('funcionarios.empresa_id', $empresa_id)
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

    public function funcionario_acao_1_grade_funcionarios($empresa_id)
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
                ->where('funcionarios.empresa_id', $empresa_id)
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

    public function cartoes_emergenciais_dados($empresa_id, $ids)
    {
        try {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $registros = Funcionario
                ::leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                ->select(['funcionarios.*', 'generos.name as generoName'])
                ->where('funcionarios.empresa_id', '=', $empresa_id)
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
}
