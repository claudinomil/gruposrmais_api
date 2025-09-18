<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\BrigadaIncendioStoreRequest;
use App\Http\Requests\BrigadaIncendioUpdateRequest;
use App\Models\BrigadaIncendio;
use App\Models\BrigadaIncendioEscala;
use App\Models\BrigadaIncendioMaterial;
use App\Models\Cliente;
use App\Models\EscalaTipo;
use App\Models\Funcionario;
use App\Models\Material;
use Illuminate\Http\Request;

class BrigadaIncendioController extends Controller
{
    private $brigada_incendio;

    public function __construct(BrigadaIncendio $brigada_incendio)
    {
        $this->brigada_incendio = $brigada_incendio;
    }

    public function index(Request $request)
    {
        $empresa_id = $request->header('X-Empresa-Id');
        
        $registros = $this->brigada_incendio
        ->join('clientes', 'clientes.id', 'brigadas_incendios.cliente_id')
        ->select('brigadas_incendios.*', 'clientes.name as clienteName')
        ->where('brigadas_incendios.empresa_id', $empresa_id)
        ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->brigada_incendio->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
            } else {
                // Materiais da Brigada de Incêndio
                $registro['brigada_incendio_materiais'] = BrigadaIncendioMaterial::where('brigada_incendio_id', '=', $id)->get();

                // Escalas da Brigada de Incêndio
                $registro['brigada_incendio_escalas'] = BrigadaIncendioEscala::where('brigada_incendio_id', '=', $id)->get();
                
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
            $registros['clientes'] = Cliente::orderby('name')->get();

            //Materiais (com Categorias)
            $registros['materiais'] = Material
                ::join('material_categorias', 'material_categorias.id', 'materiais.material_categoria_id')
                ->select('materiais.*', 'material_categorias.name as materialCategoriaName')
                ->orderby('material_categorias.name')
                ->orderby('materiais.name')
                ->get();

            // Escalas Tipos
            $registros['escala_tipos'] = EscalaTipo::orderby('name')->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
    
    public function dados($op)
    {
        try {
            $registros = array();

            if ($op == 1) {
                // Funcionários
                $registros['funcionarios'] = Funcionario::select('id', 'name')->orderby('name')->get();
            }
            
            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(BrigadaIncendioStoreRequest $request)
    {
        try {
            // Empresa ID no $request
            $empresa_id = $request->header('X-Empresa-Id');

            // Definir numero_brigada_incendio
            $reg = BrigadaIncendio::orderBy('numero_brigada_incendio', 'desc')->first();
            $numero_brigada_incendio = $reg ? $reg->numero_brigada_incendio + 1 : 1;

            // Merge no request
            $request->merge([
                'empresa_id' => $empresa_id,
                'numero_brigada_incendio' => $numero_brigada_incendio,
                'data_abertura' => date('d/m/Y'),
                'hora_abertura' => date('H:i:s'),
                'ano_brigada_incendio' => date('Y'),
                'data_prevista' => date('d/m/Y'),
                'hora_prevista' => date('H:i:s')
            ]);
            
            //Incluindo registro
            $registro = $this->brigada_incendio->create($request->all());

            //Editar dados na tabela brigadas_incendios_materiais
            SuporteFacade::editBrigadaIncendioMaterial(1, $registro['id'], $request);

            //Editar dados na tabela brigadas_incendios_escalas
            SuporteFacade::editBrigadaIncendioEscala(1, $registro['id'], $request);

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, 'null');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
    
    public function update(BrigadaIncendioUpdateRequest $request, $id)
    {
        try {
            $registro = $this->brigada_incendio->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                //Editar dados na tabela brigadas_incendios_materiais
                SuporteFacade::editBrigadaIncendioMaterial(3, $registro['id'], $request);

                //Editar dados na tabela brigadas_incendios_escalas
                SuporteFacade::editBrigadaIncendioEscala(3, $registro['id'], $request);

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
            $registro = $this->brigada_incendio->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Editar dados na tabela brigadas_incendios_materiais
                SuporteFacade::editBrigadaIncendioMaterial(2, $registro['id'], '');

                //Editar dados na tabela brigadas_incendios_escalas
                SuporteFacade::editBrigadaIncendioEscala(2, $registro['id'], '');

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
        $registros = $this->brigada_incendio
            ->select(['brigadas_incendios.*'])
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