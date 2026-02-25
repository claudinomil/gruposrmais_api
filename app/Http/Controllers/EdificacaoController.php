<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\EdificacaoStoreRequest;
use App\Http\Requests\EdificacaoUpdateRequest;
use App\Models\Cliente;
use App\Models\Edificacao;
use App\Models\EdificacaoClassificacao;
use App\Models\EdificacaoNivel;
use App\Models\EdificacaoMedidaSeguranca;
use App\Models\IncendioRisco;
use App\Models\MedidaSeguranca;

class EdificacaoController extends Controller
{
    private $edificacao;

    public function __construct(Edificacao $edificacao)
    {
        $this->edificacao = $edificacao;
    }

    public function index()
    {
        $registros = $this->edificacao
            ->leftJoin('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
            ->leftJoin('incendio_riscos', 'incendio_riscos.id', '=', 'edificacoes.incendio_risco_id')
            ->leftJoin('edificacao_classificacoes', 'edificacao_classificacoes.id', '=', 'edificacoes.edificacao_classificacao_id')
            ->select(['edificacoes.*', 'clientes.name as clienteName', 'incendio_riscos.name as incendioRiscoName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->edificacao
                ->leftJoin('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
                ->leftJoin('incendio_riscos', 'incendio_riscos.id', '=', 'edificacoes.incendio_risco_id')
                ->leftJoin('edificacao_classificacoes', 'edificacao_classificacoes.id', '=', 'edificacoes.edificacao_classificacao_id')
                ->select(['edificacoes.*', 'clientes.name as clienteName', 'incendio_riscos.name as incendioRiscoName'])
                ->where('edificacoes.id', '=', $id)
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

            // Clientes
            $registros['clientes'] = Cliente::all();

            // Edificacao Classificacoes
            $registros['edificacao_classificacoes'] = EdificacaoClassificacao::all();

            // Incêndio Riscos
            $registros['incendio_riscos'] = IncendioRisco::all();

            // Medidas Segurança
            $registros['medidas_seguranca'] = MedidaSeguranca::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(EdificacaoStoreRequest $request)
    {
        try {
            // Incluindo registro
            $registro = $this->edificacao->create($request->all());

            // Editar dados na tabela edificacoes_niveis
            SuporteFacade::editEdificacoesNiveis($registro['id'], $request);

            // Editar dados na tabela edificacoes_medidas_seguranca
            SuporteFacade::editEdificacoesMedidasSeguranca($registro['id'], $request);

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(EdificacaoUpdateRequest $request, $id)
    {
        try {
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'edificacoes');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar registro
            $registro = $this->edificacao->find($id);

            if (!$registro) {
                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                // Editar dados na tabela edificacoes_niveis
                SuporteFacade::editEdificacoesNiveis($id, $request);

                // Editar dados na tabela edificacoes_medidas_seguranca
                SuporteFacade::editEdificacoesMedidasSeguranca($id, $request);

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            SuporteFacade::bloquearTabela(3, 'edificacoes');
            //''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            $lock = SuporteFacade::bloquearTabela(2, 'edificacoes');
            if ($lock['status'] === 'locked') {return $this->sendResponse($lock['message'], 4423, null, null);}
            //''''''''''''''''''''''''''''''''''''''''''''''''

            // Procurar registro
            $registro = $this->edificacao->find($id);

            if (!$registro) {
                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                // Verificar se tem edificacao_nivel_id em outras tabelas antes de excluir''''''''''''''''''''''''''''''
                // Buscar os níveis da edificação
                $nivelIds = EdificacaoNivel::where('edificacao_id', $id)->pluck('id');

                foreach($nivelIds as $nivelId) {
                    if (SuporteFacade::verificarRelacionamento('edificacoes_locais', 'edificacao_nivel_id', $nivelId) > 0) {
                        // Verificar/Bloquear/Desbloquear Tabela''''''''''
                        SuporteFacade::bloquearTabela(3, 'edificacoes');
                        //''''''''''''''''''''''''''''''''''''''''''''''''

                        return $this->sendResponse('Náo é possível excluir. Registro relacionado com Edificações Locais.', 2040, null, null);
                    }
                }

                // Deletar as medidas segurançarelacionadas a esses níveis
                if ($nivelIds->isNotEmpty()) {EdificacaoMedidaSeguranca::whereIn('edificacao_nivel_id', $nivelIds)->delete();}

                // Agora pode deletar os níveis
                EdificacaoNivel::where('edificacao_id', $id)->delete();
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                // Verificar/Bloquear/Desbloquear Tabela''''''''''
                SuporteFacade::bloquearTabela(3, 'edificacoes');
                //''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            // Verificar/Bloquear/Desbloquear Tabela''''''''''
            SuporteFacade::bloquearTabela(3, 'edificacoes');
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
        $registros = $this->edificacao
            ->leftJoin('clientes', 'clientes.id', '=', 'edificacoes.cliente_id')
            ->leftJoin('incendio_riscos', 'incendio_riscos.id', '=', 'edificacoes.incendio_risco_id')
            ->leftJoin('edificacao_classificacoes', 'edificacao_classificacoes.id', '=', 'edificacoes.edificacao_classificacao_id')
            ->select(['edificacoes.*', 'clientes.name as clienteName', 'incendio_riscos.name as incendioRiscoName'])
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

    public function medidas_seguranca()
    {
        $registros = MedidaSeguranca::orderby('ordem')->orderby('name')->get();

        return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
    }

    public function edificacao_medidas_seguranca($edificacao_id)
    {
        $registros = EdificacaoMedidaSeguranca
            ::join('edificacoes_niveis', 'edificacoes_niveis.id', 'edificacoes_medidas_seguranca.edificacao_nivel_id')
            ->join('medidas_seguranca', 'medidas_seguranca.id', 'edificacoes_medidas_seguranca.medida_seguranca_id')
            ->select(
                'edificacoes_medidas_seguranca.edificacao_nivel_id',
                'edificacoes_medidas_seguranca.medida_seguranca_id',
                'edificacoes_medidas_seguranca.quantidade as edificacaoMedidaSegurancaQuantidade',
                'edificacoes_niveis.name as edificacaoNivelName',
                'edificacoes_niveis.area_construida as edificacaoNivelAreaConstruida',
                'edificacoes_niveis.ordem as edificacaoNivelOrdem',
                'edificacoes_niveis.nivel as edificacaoNivelNivel',
                'medidas_seguranca.name as medidaSegurancaName'
            )
            ->where('edificacoes_niveis.edificacao_id', $edificacao_id)
            ->orderby('medidas_seguranca.ordem')->orderby('medidas_seguranca.name')->get();

        return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
    }
}
