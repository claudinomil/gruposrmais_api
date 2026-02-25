<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\MedidaSegurancaStoreRequest;
use App\Http\Requests\MedidaSegurancaUpdateRequest;
use App\Models\MedidaSeguranca;

class MedidaSegurancaController extends Controller
{
    private $medida_seguranca;

    public function __construct(MedidaSeguranca $medida_seguranca)
    {
        $this->medida_seguranca = $medida_seguranca;
    }

    public function index()
    {
        $registros = $this->medida_seguranca->orderby('ordem')->orderby('name')->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->medida_seguranca->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
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

    public function store(MedidaSegurancaStoreRequest $request)
    {
        try {
            //Incluindo registro
            $this->medida_seguranca->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(MedidaSegurancaUpdateRequest $request, $id)
    {
        try {
            $registro = $this->medida_seguranca->find($id);

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
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'medidas_seguranca');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar
            $registro = $this->medida_seguranca->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela edificacoes_medidas_seguranca
                if (SuporteFacade::verificarRelacionamento('edificacoes_medidas_seguranca', 'medida_seguranca_id', $id) > 0) {
                    // Verificar/Bloquear/Desbloquear Tabela''''''''''
                    SuporteFacade::bloquearTabela(3, 'medidas_seguranca');
                    //''''''''''''''''''''''''''''''''''''''''''''''''

                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Edificações Medidas Segurança.', 2040, null, null);
                }

                //Tabela sistemas_preventivos
                if (SuporteFacade::verificarRelacionamento('sistemas_preventivos', 'medida_seguranca_id', $id) > 0) {
                    // Verificar/Bloquear/Desbloquear Tabela''''''''''
                    SuporteFacade::bloquearTabela(3, 'medidas_seguranca');
                    //''''''''''''''''''''''''''''''''''''''''''''''''

                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Sistemas Preventivos.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'medidas_seguranca');
                //''''''''''''''''''''''''''''''''''''''''''''''''

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
        $registros = $this->medida_seguranca
            ->select(['medidas_seguranca.*'])
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
