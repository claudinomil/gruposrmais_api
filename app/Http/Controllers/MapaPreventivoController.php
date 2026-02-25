<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\MapaPreventivoStoreRequest;
use App\Http\Requests\MapaPreventivoUpdateRequest;
use App\Models\MapaPreventivo;
use App\Models\EdificacaoLocal;
use App\Models\EdificacaoNivel;
use App\Models\SistemaPreventivo;

class MapaPreventivoController extends Controller
{
    private $mapa_preventivo;

    public function __construct(MapaPreventivo $mapa_preventivo)
    {
        $this->mapa_preventivo = $mapa_preventivo;
    }

    public function index()
    {
        $registros = $this->mapa_preventivo
            ->Join('sistemas_preventivos', 'sistemas_preventivos.id', '=', 'mapas_preventivos.sistema_preventivo_id')
            ->Join('edificacoes_locais', 'edificacoes_locais.id', '=', 'mapas_preventivos.edificacao_local_id')
            ->Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
            ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
            ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
            ->select(['mapas_preventivos.*', 'sistemas_preventivos.name as sistemaPreventivoName', 'edificacoes_locais.name as edificacaoLocalName', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->mapa_preventivo
                ->Join('sistemas_preventivos', 'sistemas_preventivos.id', '=', 'mapas_preventivos.sistema_preventivo_id')
                ->Join('edificacoes_locais', 'edificacoes_locais.id', '=', 'mapas_preventivos.edificacao_local_id')
                ->Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
                ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
                ->select(['mapas_preventivos.*', 'sistemas_preventivos.name as sistemaPreventivoName', 'edificacoes_locais.name as edificacaoLocalName', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
                ->where('mapas_preventivos.id', '=', $id)
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

            // Edificações Locais
            $registros['edificacoes_locais'] = EdificacaoLocal
                ::Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
                ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
                ->select(['edificacoes_locais.*', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
                ->orderby('clientes.name')
                ->orderby('edificacoes.name')
                ->orderby('edificacoes_niveis.name')
                ->get();

            // Sistemas Preventivos
            $registros['sistemas_preventivos'] = SistemaPreventivo::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(MapaPreventivoStoreRequest $request)
    {
        try {
            // Incluindo registro
            $this->mapa_preventivo->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(MapaPreventivoUpdateRequest $request, $id)
    {
        try {
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'mapas_preventivos');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar registro
            $registro = $this->mapa_preventivo->find($id);

            if (!$registro) {
                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'mapas_preventivos');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'mapas_preventivos');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            SuporteFacade::bloquearTabela(3, 'mapas_preventivos');
            //''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'mapas_preventivos');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar registro
            $registro = $this->mapa_preventivo->find($id);

            if (!$registro) {
                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'mapas_preventivos');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela ordens_servicos_edificacoes
                // if (SuporteFacade::verificarRelacionamento('ordens_servicos_edificacoes', 'mapa_preventivo_id', $id) > 0) {
                //     return $this->sendResponse('Náo é possível excluir. Registro relacionado com Ordens Serviços Veículos.', 2040, null, null);
                // }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'mapas_preventivos');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            SuporteFacade::bloquearTabela(3, 'mapas_preventivos');
            //''''''''''''''''''''''''''''''''''''''''''''''''

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
        $registros = $this->mapa_preventivo
            ->Join('sistemas_preventivos', 'sistemas_preventivos.id', '=', 'mapas_preventivos.sistema_preventivo_id')
            ->Join('edificacoes_locais', 'edificacoes_locais.id', '=', 'mapas_preventivos.edificacao_local_id')
            ->Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
            ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
            ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
            ->select(['mapas_preventivos.*', 'sistemas_preventivos.name as sistemaPreventivoName', 'edificacoes_locais.name as edificacaoLocalName', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
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
