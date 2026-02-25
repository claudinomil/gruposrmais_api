<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\EdificacaoLocalStoreRequest;
use App\Http\Requests\EdificacaoLocalUpdateRequest;
use App\Models\EdificacaoLocal;
use App\Models\EdificacaoNivel;

class EdificacaoLocalController extends Controller
{
    private $edificacao_local;

    public function __construct(EdificacaoLocal $edificacao_local)
    {
        $this->edificacao_local = $edificacao_local;
    }

    public function index()
    {
        $registros = $this->edificacao_local
            ->Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
            ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
            ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
            ->select(['edificacoes_locais.*', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->edificacao_local
                ->Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
                ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
                ->select(['edificacoes_locais.*', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
                ->where('edificacoes_locais.id', '=', $id)
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

            // Edificações Níveis
            $registros['edificacoes_niveis'] = EdificacaoNivel
                ::Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
                ->select(['edificacoes_niveis.*', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
                ->orderby('clientes.name')
                ->orderby('edificacoes.name')
                ->orderby('edificacoes_niveis.name')
                ->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(EdificacaoLocalStoreRequest $request)
    {
        try {
            // Incluindo registro
            $this->edificacao_local->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(EdificacaoLocalUpdateRequest $request, $id)
    {
        try {
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'edificacoes_locais');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar registro
            $registro = $this->edificacao_local->find($id);

            if (!$registro) {
                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
            //''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'edificacoes_locais');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar registro
            $registro = $this->edificacao_local->find($id);

            if (!$registro) {
                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela mapas_preventivos
                if (SuporteFacade::verificarRelacionamento('mapas_preventivos', 'edificacao_local_id', $id) > 0) {
                    // Verificar/Bloquear/Desbloquear Tabela''''''''''
                    SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
                    //''''''''''''''''''''''''''''''''''''''''''''''''

                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Mapas Preventivos.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            SuporteFacade::bloquearTabela(3, 'edificacoes_locais');
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
        $registros = $this->edificacao_local
            ->Join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
            ->Join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
            ->Join('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
            ->select(['edificacoes_locais.*', 'edificacoes_niveis.name as edificacaoNivelName', 'edificacoes.name as edificacaoName', 'clientes.name as clienteName'])
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
