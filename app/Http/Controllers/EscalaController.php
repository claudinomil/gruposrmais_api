<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\EscalaStoreRequest;
use App\Http\Requests\EscalaUpdateRequest;
use App\Models\AtestadoSaudeOcupacionalTipo;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\EscalaJornada;
use App\Models\EscalaTipo;
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
use Illuminate\Support\Facades\DB;
use App\Models\Escala;

class EscalaController extends Controller
{
    private $escala;

    public function __construct(Escala $escala)
    {
        $this->escala = $escala;
    }

    public function index()
    {
        $registros = $this->escala
            ->join('clientes', 'clientes.id', '=', 'escalas.cliente_id')
            ->join('escala_tipos', 'escala_tipos.id', '=', 'escalas.escala_tipo_id')
            ->join('escala_jornadas', 'escala_jornadas.id', '=', 'escalas.escala_jornada_id')
            ->select(['escalas.*', 'clientes.name as clienteName', 'escala_tipos.name as escalaTipoName', 'escala_jornadas.name as escalaJornadaName'])
            ->orderby('escalas.id')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->escala
                ->join('clientes', 'clientes.id', '=', 'escalas.cliente_id')
                ->join('escala_tipos', 'escala_tipos.id', '=', 'escalas.escala_tipo_id')
                ->join('escala_jornadas', 'escala_jornadas.id', '=', 'escalas.escala_jornada_id')
                ->select(['escalas.*', 'clientes.name as clienteName', 'escala_tipos.name as escalaTipoName', 'escala_jornadas.name as escalaJornadaName'])
                ->where('escalas.id', '=', $id)
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

            //Clientes
            $registros['clientes'] = Cliente::all();

            //Escala Tipos
            $registros['escala_tipos'] = EscalaTipo::all();

            //Escala Jornadas
            $registros['escala_jornadas'] = EscalaJornada::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(EscalaStoreRequest $request)
    {
        try {
            //Incluindo registro
            $this->escala->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(EscalaUpdateRequest $request, $id)
    {
        try {
            $registro = $this->escala->find($id);

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
            $registro = $this->escala->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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
        $registros = $this->escala
            ->join('clientes', 'clientes.id', '=', 'escalas.cliente_id')
            ->join('escala_tipos', 'escala_tipos.id', '=', 'escalas.escala_tipo_id')
            ->join('escala_jornadas', 'escala_jornadas.id', '=', 'escalas.escala_jornada_id')
            ->select(['escalas.*', 'clientes.name as clienteName', 'escala_tipos.name as escalaTipoName', 'escala_jornadas.name as escalaJornadaName'])
            ->orderby('escalas.id')
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
