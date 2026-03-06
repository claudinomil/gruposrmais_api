<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Http\Requests\VistoriaSistemaStoreRequest;
use App\Http\Requests\VistoriaSistemaUpdateRequest;
use App\Models\Edificacao;
use App\Models\Funcionario;
use App\Models\VistoriaSistemaDado;
use App\Models\VistoriaSistemaStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\VistoriaSistema;
use Illuminate\Http\Request;

class VistoriaSistemaController extends Controller
{
    private $vistoria_sistema;

    public function __construct(VistoriaSistema $vistoria_sistema)
    {
        $this->vistoria_sistema = $vistoria_sistema;
    }

    public function index(Request $request)
    {
        $empresa_id = $request->header('X-Empresa-Id');

        $registros = $this->vistoria_sistema
            ->Join('edificacoes', 'edificacoes.id', 'vistorias_sistemas.edificacao_id')
            ->select(['vistorias_sistemas.*', 'edificacoes.name as edificacaoName'])
            ->where('vistorias_sistemas.empresa_id', $empresa_id)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->vistoria_sistema
                ->Join('edificacoes', 'edificacoes.id', 'vistorias_sistemas.edificacao_id')
                ->Join('vistoria_sistema_status', 'vistorias_sistemas.vistoria_sistema_status_id', '=', 'vistoria_sistema_status.id')
                ->select(['vistorias_sistemas.*', 'edificacoes.name as edificacaoName', 'vistoria_sistema_status.name as vistoriaSistemaStatusName'])
                ->where('vistorias_sistemas.id', '=', $id)
                ->get()[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //buscar dados vistorias_sistemas_dados
                $registro['vistorias_sistemas_dados'] = VistoriaSistemaDado::where('vistoria_sistema_id', '=', $id)->get();

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

            // Edificacoes
            $registros['edificacoes'] = Edificacao
                ::join('clientes', 'clientes.id', 'edificacoes.cliente_id')
                ->select('edificacoes.*', 'clientes.name as clienteName')
                ->get();

            //Funcionários
            $funcionarios = Funcionario
                ::leftJoin('funcoes', 'funcionarios.funcao_id', '=', 'funcoes.id')
                ->select(['funcionarios.*', 'funcoes.name as funcaoName'])
                ->get();

            $registros['funcionarios'] = $funcionarios;

            // Vistorias Sistemas Status
            $registros['vistoria_sistema_status'] = VistoriaSistemaStatus::all();

            // Vistorias Sistemas Perguntas
            $registros['vistoria_sistema_perguntas'] = [];

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(VistoriaSistemaStoreRequest $request)
    {
        try {
            //Empresa ID no $request
            $request['empresa_id'] = $request->header('X-Empresa-Id');

            //Acertos campos''''''''''''''''''''''''''''''''''''''''''''''''
            //vistoria_sistema_status_id
            $request['vistoria_sistema_status_id'] = 1;

            //numero_vistoria_sistema
            $reg = VistoriaSistema::orderBy('numero_vistoria_sistema', 'desc')->first();
            if ($reg) {
                $request['numero_vistoria_sistema'] = $reg['numero_vistoria_sistema'] + 1;
            } else {
                $request['numero_vistoria_sistema'] = 1;
            }

            //data_abertura
            $request['data_abertura'] = date('d/m/Y');

            //hora_abertura
            $request['hora_abertura'] = date('H:i:s');

            //ano_vistoria_sistema
            $request['ano_vistoria_sistema'] = substr($request['data_abertura'], 6, 4);

            //data_prevista
            $request['data_prevista'] = $request['data_abertura'];

            //hora_prevista
            $request['hora_prevista'] = $request['hora_abertura'];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Buscar dados Edificacoes''''''''''''''''''''''''''''''''''''''
            $edificacao = Edificacao
                ::join('incendio_riscos', 'incendio_riscos.id', 'edificacoes.incendio_risco_id')
                ->select('edificacoes.*', 'incendio_riscos.name as incendioRiscoName')
                ->where('edificacoes.id', $request['edificacao_id'])
                ->first();

            if (!$edificacao) {
                return $this->sendResponse('Edificação não encontrada.', 2040, null, null);
            } else {
                $request['edificacao_nome'] = $edificacao['name'];
                $request['edificacao_pavimentos'] = $edificacao['pavimentos'];
                $request['edificacao_mezaninos'] = $edificacao['mezaninos'];
                $request['edificacao_coberturas'] = $edificacao['coberturas'];
                $request['edificacao_areas_tecnicas'] = $edificacao['areas_tecnicas'];
                $request['edificacao_altura'] = $edificacao['altura'];
                $request['edificacao_area_total_construida'] = $edificacao['area_total_construida'];
                $request['edificacao_lotacao'] = $edificacao['lotacao'];
                $request['edificacao_carga_incendio'] = $edificacao['carga_incendio'];
                $request['edificacao_incendio_risco'] = $edificacao['incendioRiscoName'];
                $request['edificacao_grupo'] = $edificacao['grupo'];
                $request['edificacao_ocupacao_uso'] = $edificacao['ocupacao_uso'];
                $request['edificacao_divisao'] = $edificacao['divisao'];
                $request['edificacao_descricao'] = $edificacao['descricao'];
                $request['edificacao_definicao'] = $edificacao['definicao'];
                $request['cliente_id'] = $edificacao['cliente_id'];
                $request['cliente_nome'] = $edificacao['cliente_nome'];
                $request['cliente_telefone'] = $edificacao['cliente_telefone'];
                $request['cliente_celular'] = $edificacao['cliente_celular'];
                $request['cliente_email'] = $edificacao['cliente_email'];
                $request['cliente_logradouro'] = $edificacao['cliente_logradouro'];
                $request['cliente_bairro'] = $edificacao['cliente_bairro'];
                $request['cliente_cidade'] = $edificacao['cliente_cidade'];
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Buscar dados Responsável''''''''''''''''''''''''''''''''''''''
            if (Auth::user()->funcionario_id != null) {
                $resp_func_id = Auth::user()->funcionario_id;

                $responsavel = Funcionario::find($resp_func_id);

                if ($responsavel) {
                    $request['responsavel_funcionario_id'] = $responsavel['id'];
                    $request['responsavel_nome'] = $responsavel['name'];
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Incluindo registro na tabela vistorias_sistemas
            $registro = $this->vistoria_sistema->create($request->all());

            //Incluindo registros na tabela vistorias_sistemas_dados''''''''''
            $vistoria_sistema_id = $registro['id'];

            $vistoria_sistema_perguntas = [];

            foreach ($vistoria_sistema_perguntas as $vistoria_sistema_pergunta) {
                $dados = $vistoria_sistema_pergunta->toArray(); // transforma o objeto em array

                $dados['vistoria_sistema_id'] = $vistoria_sistema_id;
                unset($dados['id'], $dados['created_at'], $dados['updated_at']);

                VistoriaSistemaDado::create($dados);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Return
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(VistoriaSistemaUpdateRequest $request, $id)
    {
        try {
            $registro = $this->vistoria_sistema->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                // Buscar dados Edificacoes'''''''''''''''''''''''''''''''''''''
                $edificacao = Edificacao
                    ::join('incendio_riscos', 'incendio_riscos.id', 'edificacoes.incendio_risco_id')
                    ->select('edificacoes.*', 'incendio_riscos.name as incendioRiscoName')
                    ->where('edificacoes.id', $registro->edificacao_id)
                    ->first();

                if (!$edificacao) {
                    return $this->sendResponse('Edificação não encontrada.', 2040, null, null);
                } else {
                    $request['edificacao_nome'] = $edificacao['name'];
                    $request['edificacao_pavimentos'] = $edificacao['pavimentos'];
                    $request['edificacao_mezaninos'] = $edificacao['mezaninos'];
                    $request['edificacao_coberturas'] = $edificacao['coberturas'];
                    $request['edificacao_areas_tecnicas'] = $edificacao['areas_tecnicas'];
                    $request['edificacao_altura'] = $edificacao['altura'];
                    $request['edificacao_area_total_construida'] = $edificacao['area_total_construida'];
                    $request['edificacao_lotacao'] = $edificacao['lotacao'];
                    $request['edificacao_carga_incendio'] = $edificacao['carga_incendio'];
                    $request['edificacao_incendio_risco'] = $edificacao['incendioRiscoName'];
                    $request['edificacao_grupo'] = $edificacao['grupo'];
                    $request['edificacao_ocupacao_uso'] = $edificacao['ocupacao_uso'];
                    $request['edificacao_divisao'] = $edificacao['divisao'];
                    $request['edificacao_descricao'] = $edificacao['descricao'];
                    $request['edificacao_definicao'] = $edificacao['definicao'];
                    $request['cliente_id'] = $edificacao['cliente_id'];
                    $request['cliente_nome'] = $edificacao['cliente_nome'];
                    $request['cliente_telefone'] = $edificacao['cliente_telefone'];
                    $request['cliente_celular'] = $edificacao['cliente_celular'];
                    $request['cliente_email'] = $edificacao['cliente_email'];
                    $request['cliente_logradouro'] = $edificacao['cliente_logradouro'];
                    $request['cliente_bairro'] = $edificacao['cliente_bairro'];
                    $request['cliente_cidade'] = $edificacao['cliente_cidade'];
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Alterando registro
                $registro->update($request->all());

                //Return
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
            $registro = $this->vistoria_sistema->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Buscar todos os Ids da tabela vistorias_sistemas_dados relacionado ao Id da tabela vistorias_sistemas'''''
                $ids = VistoriaSistemaDado::where('vistoria_sistema_id', '=', $id)->get('id');
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Apagar dados na tabela funcionarios_documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                VistoriaSistemaDado::where('vistoria_sistema_id', '=', $id)->delete();
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, $ids);
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
        $empresa_id = $request->header('X-Empresa-Id');

        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->vistoria_sistema
            ->Join('edificacoes', 'edificacoes.id', 'vistorias_sistemas.edificacao_id')
            ->select(['vistorias_sistemas.*', 'edificacoes.name as edificacaoName'])
            ->where('vistorias_sistemas.empresa_id', $empresa_id)
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

    public function updatePergunta(Request $request, $vistoria_sistema_dado_id)
    {
        try {
            $registro = VistoriaSistemaDado::find($vistoria_sistema_dado_id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 2040, null, null);
            } else {
                //Acertar fotografia_x'''''''''''''''''''''''''''''''''''''''''''''''
                //fotografia_1
                $path = parse_url($request['fotografia_1'], PHP_URL_PATH);
                $path = ltrim($path, '/');
                $request['fotografia_1'] = $path;

                //fotografia_2
                $path = parse_url($request['fotografia_2'], PHP_URL_PATH);
                $path = ltrim($path, '/');
                $request['fotografia_2'] = $path;

                //fotografia_3
                $path = parse_url($request['fotografia_3'], PHP_URL_PATH);
                $path = ltrim($path, '/');
                $request['fotografia_3'] = $path;
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Acertar pdf_x''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //pdf_1
                $path = parse_url($request['pdf_1'], PHP_URL_PATH);
                $path = ltrim($path, '/');
                $request['pdf_1'] = $path;

                //pdf_2
                $path = parse_url($request['pdf_2'], PHP_URL_PATH);
                $path = ltrim($path, '/');
                $request['pdf_2'] = $path;

                //pdf_3
                $path = parse_url($request['pdf_3'], PHP_URL_PATH);
                $path = ltrim($path, '/');
                $request['pdf_3'] = $path;
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Gravar transação
                $dadosAnterior = VistoriaSistemaDado::find($vistoria_sistema_dado_id);

                //Alterando registro
                $registro->update($request->all());

                //Gravar transação
                Transacoes::transacaoRecord(2, 2, 'vistorias_sistemas', $dadosAnterior, $request);

                //Return
                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $request);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
