<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\ProdutoEntradaStoreRequest;
use App\Http\Requests\ProdutoEntradaUpdateRequest;
use App\Models\EstoqueLocal;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ProdutoEntrada;
use App\Models\ProdutoEntradaItem;
use App\Models\ProdutoMovimentacao;
use App\Models\ProdutoMovimentacaoItem;
use App\Models\ProdutoTipo;
use Illuminate\Http\Request;

class ProdutoEntradaController extends Controller
{
    private $produto_entrada;

    public function __construct(ProdutoEntrada $produto_entrada)
    {
        $this->produto_entrada = $produto_entrada;
    }

    public function index(Request $request)
    {
        $empresa_id = $request->header('X-Empresa-Id');

        $registros = $this->produto_entrada
        ->with('produtos_entradas_itens') // carrega todos os itens relacionados
        ->join('fornecedores', 'fornecedores.id', 'produtos_entradas.fornecedor_id')
        ->select('produtos_entradas.*', 'fornecedores.name as fornecedorName')
        ->where('produtos_entradas.empresa_id', $empresa_id)
        ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->produto_entrada->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
            } else {
                // Materiais Entradas Itens
                $registro['produto_entrada_itens'] = ProdutoEntradaItem::where('produto_entrada_id', '=', $id)->get();

                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function auxiliary(Request $request)
    {
        try {
            $registros = array();

            // Empresa ID no $request
            $empresa_id = $request->header('X-Empresa-Id');

            // Fornecedores
            $registros['fornecedores'] = Fornecedor::orderby('name')->get();

            //Materiais (com Categorias)
            $registros['produtos'] = Produto
                ::join('produto_categorias', 'produto_categorias.id', 'produtos.produto_categoria_id')
                ->select('produtos.*', 'produto_categorias.name as produtoCategoriaName')
                ->orderby('produto_categorias.name')
                ->orderby('produtos.name')
                ->get();

            // Estoques Locais
            $registros['estoques_locais'] = EstoqueLocal
                ::leftjoin('empresas', 'empresas.id', 'estoques_locais.empresa_id')
                ->select('estoques_locais.*', 'empresas.name as empresaName')
                ->where('estoques_locais.empresa_id', $empresa_id)
                ->orderby('estoques_locais.name')
                ->get();

            // Produto Tipos
            $registros['produto_tipos'] = ProdutoTipo::orderby('name')->get();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(ProdutoEntradaStoreRequest $request)
    {
        try {
            // Empresa ID no $request
            $empresa_id = $request->header('X-Empresa-Id');

            // Merge no request
            $request->merge(['empresa_id' => $empresa_id]);

            // Dispara validação customizada (lança ValidationException se houver erro)
            SuporteFacade::validarPatrimoniosDuplicados($request);

            //Incluindo registro
            $registro = $this->produto_entrada->create($request->all());

            //Editar dados na tabela produtos_entradas_itens
            SuporteFacade::editProdutoEntradaItem(1, $registro['id'], $request);

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, 'null');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(ProdutoEntradaUpdateRequest $request, $id)
    {
        try {
            $registro = $this->produto_entrada->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                //Editar dados na tabela produtos_entradas_itens
                SuporteFacade::editProdutoEntradaItem(3, $registro['id'], $request);

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
            $registro = $this->produto_entrada->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Editar dados na tabela produtos_entradas_itens
                SuporteFacade::editProdutoEntradaItem(2, $registro['id'], '');

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
        $registros = $this->produto_entrada
            ->select(['produtos_entradas.*'])
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

            // Produto Entrada
            $produto_entrada = ProdutoEntrada
                ::join('empresas', 'empresas.id', '=', 'produtos_entradas.empresa_id')
                ->select(['produtos_entradas.*', 'empresas.name as empresaName'])
                ->where('produtos_entradas.id', '=', $id)
                ->get();

            $registro['produto_entrada'] = $produto_entrada[0];

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function upload_nota_fiscal(Request $request)
    {
        try {
            $registro = $this->produto_entrada->find($request['produto_entrada_id']);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->nf_pdf_caminho = $request['nf_pdf_caminho'];
                $registro->save();

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function executar_entrada($id)
    {
        try {
            // Produto Entrada
            $produto_entrada = ProdutoEntrada::find($id);

            // Produto Entrada Itens
            $produto_entrada_itens = ProdutoEntradaItem::where('produto_entrada_id', $id)->get();

            // Dados
            $data = array();
            $data['origem_estoque_local_id'] = $produto_entrada->estoque_local_id;
            $data['destino_estoque_local_id'] = $produto_entrada->estoque_local_id;
            $data['data_movimentacao'] = date('d/m/Y');
            $data['hora_movimentacao'] = date('H:i:s');
            $data['tipo'] = 'entrada';

            // Incluir na tabela produtos_movimentacoes
            $registro = ProdutoMovimentacao::create($data);

            // Estoque Local de Destino
            $destino_estoque_local_id = $produto_entrada->estoque_local_id;

            // Produto Situação
            $produto_situacao_id = 1; // ATIVO - permite movimentação

            // Edições
            if (isset($produto_entrada_itens)) {
                foreach ($produto_entrada_itens as $produto_entrada_item) {
                    // Incluir na tabela produtos_movimentacoes_itens
                    ProdutoMovimentacaoItem::create(['produto_movimentacao_id' => $registro['id'], 'produto_entrada_item_id' => $produto_entrada_item['id']]);

                    // Alterar tabela produtos_entradas_itens
                    ProdutoEntradaItem::where('id', $produto_entrada_item['id'])->update(['estoque_local_id' => $destino_estoque_local_id, 'produto_situacao_id' => $produto_situacao_id]);

                    // Criar registro na tabela produtos_controle_situacoes_itens
                    SuporteFacade::gravarRegistroControleSituacao(
                        $produto_entrada_item['id'],
                        $produto_entrada_item['produto_situacao_id'],
                        $produto_situacao_id,
                        $produto_entrada_item['estoque_local_id'],
                        $destino_estoque_local_id,
                        'Registro criado ao Executar Entrada',
                        date('d/m/Y'),
                        date('H:i:s')
                    );
                }
            }

            // Alterar tabela produtos_entradas
            ProdutoEntrada::where('id', $id)->update(['executada' => 1]);

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
