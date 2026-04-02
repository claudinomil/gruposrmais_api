<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\SistemaPreventivoStoreRequest;
use App\Http\Requests\SistemaPreventivoUpdateRequest;
use App\Models\EquipamentoPreventivo;
use App\Models\SistemaPreventivoCategoria;
use App\Models\SistemaPreventivoCombustivel;
use App\Models\SistemaPreventivoMarca;
use App\Models\SistemaPreventivoModelo;
use Illuminate\Support\Facades\DB;
use App\Models\SistemaPreventivo;
use App\Models\MedidaSeguranca;
use App\Models\SistemaPreventivoEquipamento;

class SistemaPreventivoController extends Controller
{
    private $sistema_preventivo;

    public function __construct(SistemaPreventivo $sistema_preventivo)
    {
        $this->sistema_preventivo = $sistema_preventivo;
    }

    public function index()
    {
        // $registros = $this->sistema_preventivo
        //     ->Join('medidas_seguranca', 'medidas_seguranca.id', '=', 'sistemas_preventivos.medida_seguranca_id')
        //     ->select(['sistemas_preventivos.*', 'medidas_seguranca.name as medidaSegurancaName'])
        //     ->get();


        $registros = $this->sistema_preventivo
            ->join('medidas_seguranca', 'medidas_seguranca.id', '=', 'sistemas_preventivos.medida_seguranca_id')
            ->leftJoin('sistemas_preventivos_equipamentos as spe', 'spe.sistema_preventivo_id', '=', 'sistemas_preventivos.id')
            ->leftJoin('equipamentos_preventivos as ep', 'ep.id', '=', 'spe.equipamento_preventivo_id')
            ->select(
                'sistemas_preventivos.*',
                'medidas_seguranca.name as medidaSegurancaName',
                DB::raw("
                    CASE
                        WHEN COUNT(ep.id) = 0 THEN JSON_ARRAY()
                        ELSE JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'id', ep.id,
                                'name', ep.name,
                                'item', spe.equipamento_preventivo_item,
                                'nome', spe.equipamento_preventivo_nome,
                                'quantidade', spe.equipamento_preventivo_quantidade
                            )
                        )
                    END as equipamentos
                ")
            )
            ->groupBy('sistemas_preventivos.id', 'medidas_seguranca.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->sistema_preventivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                // buscar dados dos equipamentos para o sistema preventivo
                $registro['sistema_preventivo_equipamentos'] = SistemaPreventivoEquipamento::where('sistema_preventivo_id', '=', $id)->get();

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

            // Medidas Segurança
            $registros['medidas_seguranca'] = MedidaSeguranca::orderby('name')->get();

            // Equipamentos Preventivos
            $registros['equipamentos_preventivos'] = EquipamentoPreventivo::orderby('name')->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(SistemaPreventivoStoreRequest $request)
    {
        try {
            //Incluindo registro
            $registro = $this->sistema_preventivo->create($request->all());

            // Editar dados na tabela sistemas_preventivos_equipamentos
            SuporteFacade::editSistemaPreventivoEquipamento(1, $registro['id'], $request);

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(SistemaPreventivoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->sistema_preventivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                // Editar dados na tabela sistemas_preventivos_equipamentos
                SuporteFacade::editSistemaPreventivoEquipamento(3, $id, $request);

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
            $lock = SuporteFacade::bloquearTabela(2, 'sistemas_preventivos');
            if ($lock['status'] === 'locked') {
                return $this->sendResponse($lock['message'], 4423, null, null);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar
            $registro = $this->sistema_preventivo->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                // Editar dados na tabela sistemas_preventivos_equipamentos
                SuporteFacade::editSistemaPreventivoEquipamento(2, $id, '');

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'sistemas_preventivos');
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
        $registros = $this->sistema_preventivo
            ->Join('medidas_seguranca', 'medidas_seguranca.id', '=', 'sistemas_preventivos.medida_seguranca_id')
            ->select(['sistemas_preventivos.*', 'medidas_seguranca.name as medidaSegurancaName'])
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
}
