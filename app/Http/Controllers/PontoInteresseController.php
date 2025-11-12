<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\PontoInteresseStoreRequest;
use App\Http\Requests\PontoInteresseUpdateRequest;
use App\Models\Especialidade;
use App\Models\PontoTipo;
use App\Models\PontoInteresse;
use App\Models\PontoInteresseEspecialidade;
use App\Models\PontoNatureza;

class PontoInteresseController extends Controller
{
    private $ponto_interesse;

    public function __construct(PontoInteresse $ponto_interesse)
    {
        $this->ponto_interesse = $ponto_interesse;
    }

    public function index()
    {
        $registros = $this->ponto_interesse
            ->join('pontos_tipos', 'pontos_tipos.id', 'pontos_interesse.ponto_tipo_id')
            ->leftjoin('pontos_naturezas', 'pontos_naturezas.id', 'pontos_interesse.ponto_natureza_id')
            ->select('pontos_interesse.*', 'pontos_tipos.name as mapaTipoName', 'pontos_naturezas.name as mapaNaturezaName')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = PontoInteresse
                ::where('pontos_interesse.id', '=', $id)
                ->get()[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                // Especialidades
                $registro['especialidades'] = PontoInteresseEspecialidade::where('ponto_interesse_id', '=', $id)->get();
                
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

            //Mapas Pontos Tipos
            $registros['pontos_tipos'] = PontoTipo::all();

            //Mapas Pontos Naturezas
            $registros['pontos_naturezas'] = PontoNatureza::all();

            // Especialidades
            $registros['especialidades'] = Especialidade
                ::join('especialidades_tipos', 'especialidades_tipos.id', 'especialidades.especialidade_tipo_id')
                ->select('especialidades.*', 'especialidades_tipos.name as especialidadeTipoName')
                ->orderby('especialidades_tipos.name')
                ->orderby('especialidades.name')
                ->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(PontoInteresseStoreRequest $request)
    {
        try {
            //Incluindo registro
            $registro = $this->ponto_interesse->create($request->all());

            // Editar dados na tabela pontos_interesse_especialidades
            SuporteFacade::editPontosInteresseEspecialidades(1, $registro['id'], $request);
            
            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(PontoInteresseUpdateRequest $request, $id)
    {
        try {
            $registro = $this->ponto_interesse->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                // Editar dados na tabela pontos_interesse_especialidades
                SuporteFacade::editPontosInteresseEspecialidades(2, $registro['id'], $request);

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
            $registro = $this->ponto_interesse->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                
                // Editar dados na tabela pontos_interesse_especialidades
                SuporteFacade::editPontosInteresseEspecialidades(3, $registro['id'], []);

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
        $registros = $this->ponto_interesse
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

    public function pontos_tipo($ponto_tipo_id)
    {
        $registros = PontoInteresse
            ::join('pontos_tipos', 'pontos_tipos.id', 'pontos_interesse.ponto_tipo_id')
            ->where('pontos_interesse.ponto_tipo_id', '=', $ponto_tipo_id)
            ->select('pontos_interesse.*', 'pontos_tipos.name as ponto_tipo')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }
}
