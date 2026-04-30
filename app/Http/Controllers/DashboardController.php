<?php

namespace App\Http\Controllers;

use App\Models\BrigadaIncendio;
use App\Models\Cliente;
use App\Models\ClienteDocumentoExigido;
use App\Models\ClienteLoja;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Edificacao;
use App\Models\EdificacaoNivel;
use App\Models\Funcionario;
use App\Models\GrupoGrafico;
use App\Models\OrdemServico;
use App\Models\Transacao;
use App\Models\User;
use App\Models\VisitaTecnica;
use App\Models\VistoriaSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $x_cliente_id;
    private $cliente_id;
    private $edificacao_id;
    private $edificacao_nivel_id;

    public function __construct(Request $request)
    {
        $this->x_cliente_id = $request->header('X-Cliente-Id');
    }

    public function auxiliary()
    {
        try {
            $registros = array();

            // Clientes
            $registros['clientes'] = Cliente::select('clientes.id', 'clientes.name', 'clientes.nome_fantasia')
                ->when($this->x_cliente_id != 0, function ($query) {
                    $query->where('id', $this->x_cliente_id);
                    $query->orWhere('principal_cliente_id', $this->x_cliente_id);
                })
                ->orderby('clientes.name')
                ->orderby('clientes.nome_fantasia')
                ->get();

            // Edificações
            $registros['edificacoes'] = Edificacao::join('clientes', 'clientes.id', 'edificacoes.cliente_id')
                ->select('edificacoes.id', 'edificacoes.name', 'edificacoes.cliente_id')
                ->orderby('clientes.name')
                ->orderby('clientes.nome_fantasia')
                ->orderby('edificacoes.name')
                ->get();

            // Edificações Níveis
            $registros['edificacoes_niveis'] = EdificacaoNivel::join('edificacoes', 'edificacoes.id', 'edificacoes_niveis.edificacao_id')
                ->select('edificacoes_niveis.id', 'edificacoes_niveis.name', 'edificacoes_niveis.edificacao_id')
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

    public function graficos($grafico_grupo_id)
    {
        try {
            if ($this->x_cliente_id == 0) {$sistema = 1;} else {$sistema = 2;}

            // array
            $content = array();

            // Gráfico Grupos (pertencentes ao Grupo de Acesso do Usuário logado)
            $content['grafico_grupos'] = GrupoGrafico::join('graficos', 'graficos.id', 'grupos_graficos.grafico_id')
                ->join('grafico_grupos', 'grafico_grupos.id', 'graficos.grafico_grupo_id')
                ->select('grafico_grupos.*')
                ->where('grupos_graficos.grupo_id', Auth::user()->grupo_id)
                ->where('graficos.dashboard', 1)
                ->orderBy('grafico_grupos.ordem_visualizacao')
                ->distinct()
                ->get();

            // Grupo Gráficos (pertencentes ao Grupo de Acesso do Usuário logado)
            $content['grupo_graficos'] = GrupoGrafico::join('graficos', 'graficos.id', 'grupos_graficos.grafico_id')
                ->join('grafico_grupos', 'grafico_grupos.id', 'graficos.grafico_grupo_id')
                ->select(
                    'graficos.id as grafico_id',
                    'graficos.name as grafico_name',
                    'graficos.tipo as grafico_tipo',
                    'graficos.ordem_visualizacao as grafico_ordem_visualizacao',
                    'grafico_grupos.id as graficoGrupoId',
                    'grafico_grupos.name as graficoGrupoName'
                )
                ->where('graficos.sistema', 'like', '%' . $sistema . '%')
                ->where('grupos_graficos.grupo_id', Auth::user()->grupo_id)
                ->where('graficos.dashboard', 1)
                ->when($grafico_grupo_id != 0, function ($query) use ($grafico_grupo_id) {
                    $query->where('grafico_grupos.id', $grafico_grupo_id);
                })
                ->orderBy('grafico_grupos.ordem_visualizacao')
                ->orderBy('graficos.ordem_visualizacao')
                ->get();

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function grupo_informacoes($grafico_grupo_id, $cliente_id, $edificacao_id, $edificacao_nivel_id)
    {
        try {
            if ($this->x_cliente_id == 0) {$sistema = 1;} else {$sistema = 2;}

            $this->cliente_id = $cliente_id;
            $this->edificacao_id = $edificacao_id;
            $this->edificacao_nivel_id = $edificacao_nivel_id;

            // array
            $content = array();

            // Grupo: Sistema
            if ($grafico_grupo_id == 1) {
                // Usuários Quantidade
                $content['usuarios_quantidade'] = $this->getCount(8);

                // Funcionários Quantidade
                $content['funcionarios_quantidade'] = $this->getCount(9);

                // Clientes Quantidade
                $content['clientes_quantidade'] = $this->getCount(10);

                // Transações Quantidade
                $content['transacoes_quantidade'] = $this->getCount(11);
            }

            // Grupo: Operações
            if ($grafico_grupo_id == 2) {
                // Ordens Serviços Quantidade
                $content['ordens_servicos_quantidade'] = $this->getCount(12);

                // Visitas Técnicas Quantidade
                $content['visitas_tecnicas_quantidade'] = $this->getCount(13);

                // Brigadas Incêndios Quantidade
                $content['brigadas_incendios_quantidade'] = $this->getCount(14);

                // Vistorias Sistemas Quantidade
                $content['vistorias_sistemas_quantidade'] = $this->getCount(15);
            }

            // Grupo: Clientes x Edificações
            if ($grafico_grupo_id == 3) {
                // Documentos Exigidos Pendentes
                $content['documentos_exigidos_pendentes'] = $this->getCount(2) - $this->getCount(1);

                // Documentos Exigidos Lançados
                $content['documentos_exigidos_lancados'] = $this->getCount(1);

                // Documentos Exigidos Quantidade
                $content['documentos_exigidos_quantidade'] = $this->getCount(2);

                // Documentos Exigidos Vencidos
                $content['documentos_exigidos_vencidos'] = $this->getCount(3);

                // Documentos Exigidos não Vencidos
                $content['documentos_exigidos_nao_vencidos'] = $this->getCount(4);

                // LUCs Quantidade
                $content['lucs_quantidade'] = $this->getCount(5);

                // LUCs Ocupadas
                $content['lucs_ocupadas'] = $this->getCount(6);

                // LUCs Desocupadas
                $content['lucs_desocupadas'] = $content['lucs_quantidade'] - $content['lucs_ocupadas'];

                // Quantidade Lojas
                $content['quantidade_lojas'] = $this->getCount(7);

                // Quantidade Sistemas Preventivos
                $content['quantidade_sistemas_preventivos'] = $this->getCount(16);
            }

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=1 (Usuários Grupos)
    public function grafico_1_dados()
    {
        try {
            // array
            $content = array();

            // Usuários Quantidade
            $content['usuarios_quantidade'] = $this->getCount(8);

            // Usuários Distribuição por Grupos
            $content['usuarios_grupos'] = DB::select("SELECT grupos.name, count(users.id) as quantidade FROM users INNER JOIN grupos ON users.grupo_id=grupos.id GROUP BY grupos.name ORDER BY grupos.name");

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=2 (Usuários Situações)
    public function grafico_2_dados()
    {
        try {
            // array
            $content = array();

            // Usuários Quantidade
            $content['usuarios_quantidade'] = $this->getCount(8);

            // Usuários Distribuição por Situacoes
            $content['usuarios_situacoes'] = DB::select("SELECT situacoes.name, count(users.id) as quantidade FROM users INNER JOIN situacoes ON users.situacao_id=situacoes.id GROUP BY situacoes.name ORDER BY situacoes.name");

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=3 (Funcionários Contratações)
    public function grafico_3_dados()
    {
        try {
            // array
            $content = array();

            // Funcionarios Quantidade
            $content['funcionarios_quantidade'] = $this->getCount(9);

            // Funcionários Distribuição por Contratações
            $query = "SELECT contratacao_tipos.name, COUNT(funcionarios.id) AS quantidade
                        FROM funcionarios
                        INNER JOIN contratacao_tipos ON funcionarios.contratacao_tipo_id = contratacao_tipos.id ";

            if ($this->x_cliente_id != 0) {$query .= "WHERE funcionarios.tomador_servico_cliente_id=".$this->x_cliente_id." ";}

            $query .= "GROUP BY contratacao_tipos.name ORDER BY contratacao_tipos.name";

            $content['funcionarios_contratacoes'] = DB::select($query);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=4 (Funcionários Funções)
    public function grafico_4_dados()
    {
        try {
            // array
            $content = array();

            // Funcionarios Quantidade
            $content['funcionarios_quantidade'] = $this->getCount(9);

            // Funcionários Distribuição por Funções
            $query = "SELECT funcoes.name, count(funcionarios.id) as quantidade
                        FROM funcionarios
                        INNER JOIN funcoes ON funcionarios.funcao_id=funcoes.id ";

            if ($this->x_cliente_id != 0) {$query .= "WHERE funcionarios.tomador_servico_cliente_id=".$this->x_cliente_id." ";}

            $query .= "GROUP BY funcoes.name ORDER BY funcoes.name";

            $content['funcionarios_funcoes'] = DB::select($query);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=5 (Funcionários Gêneros)
    public function grafico_5_dados()
    {
        try {
            // array
            $content = array();

            // Funcionarios Quantidade
            $content['funcionarios_quantidade'] = $this->getCount(9);

            // Funcionários Distribuição por Gêneros
            $query = "SELECT generos.name, count(funcionarios.id) as quantidade
                        FROM funcionarios
                        INNER JOIN generos ON funcionarios.genero_id=generos.id ";

            if ($this->x_cliente_id != 0) {$query .= "WHERE funcionarios.tomador_servico_cliente_id=".$this->x_cliente_id." ";}

            $query .= "GROUP BY generos.name ORDER BY generos.name";

            $content['funcionarios_generos'] = DB::select($query);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=6 (Clientes Status)
    public function grafico_6_dados()
    {
        try {
            // array
            $content = array();

            // Clientes Quantidades
            $content['clientes_quantidade'] = $this->getCount(10);

            // Clientes Distribuição por Status
            $query = "SELECT CASE WHEN status=1 THEN 'ATIVO' WHEN status=2 THEN 'INATIVO' ELSE 'DESCONHECIDO' END AS name, count(clientes.id) as quantidade
                        FROM clientes ";

            if ($this->x_cliente_id != 0) {$query .= "WHERE clientes.principal_cliente_id=".$this->x_cliente_id." ";}

            $query .= "GROUP BY status ORDER BY status";

            $content['clientes_status'] = DB::select($query);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=7 (Clientes Tipos)
    public function grafico_7_dados()
    {
        try {
            // array
            $content = array();

            // Clientes Quantidades
            $content['clientes_quantidade'] = $this->getCount(10);

            // Clientes Distribuição por Tipos
            $query = "SELECT CASE WHEN tipo=1 THEN 'PESSOA JURÍDICA' WHEN tipo=2 THEN 'PESSOA FÍSICA' ELSE 'DESCONHECIDO' END AS name, count(clientes.id) as quantidade
                        FROM clientes ";

            if ($this->x_cliente_id != 0) {$query .= "WHERE clientes.principal_cliente_id=".$this->x_cliente_id." ";}

            $query .= "GROUP BY tipo ORDER BY tipo";

            $content['clientes_tipos'] = DB::select($query);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=8 (Transações Operações)
    public function grafico_8_dados()
    {
        try {
            // array
            $content = array();

            // Transações Quantidades
            $content['transacoes_quantidade'] = $this->getCount(11);

            // Transações Distribuição por Operações
            $content['transacoes_operacoes'] = DB::select("SELECT transacoes.operacao_id, operacoes.name, COUNT(*) as quantidade FROM transacoes INNER JOIN operacoes ON operacoes.id = transacoes.operacao_id GROUP BY transacoes.operacao_id, operacoes.name ORDER BY operacoes.name");

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=9 (Transações Submódulos)
    public function grafico_9_dados()
    {
        try {
            // array
            $content = array();

            // Transações Quantidades
            $content['transacoes_quantidade'] = $this->getCount(11);

            // Transações Distribuição por Submodulos
            $content['transacoes_submodulos'] = DB::select("SELECT transacoes.submodulo_id, submodulos.name, COUNT(*) as quantidade FROM transacoes INNER JOIN submodulos ON submodulos.id = transacoes.submodulo_id GROUP BY transacoes.submodulo_id, submodulos.name ORDER BY submodulos.name");

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=10 (Operações)
    public function grafico_10_dados()
    {
        try {
            // array
            $content = array();

            // Vistorias Sistemas Quantidade
            $content['operacoes_vistorias_sistemas_quantidade'] = $this->getCount(15);

            // Brigadas Incêndios Quantidade
            $content['operacoes_brigadas_incendios_quantidade'] = $this->getCount(14);

            // Visitas Técnicas Quantidade
            $content['operacoes_visitas_tecnicas_quantidade'] = $this->getCount(13);

            // Ordens de Serviços Quantidade
            $content['operacoes_ordens_servicos_quantidade'] = $this->getCount(12);

            // Quantidade Total
            $content['operacoes_total_quantidade'] = $content['operacoes_vistorias_sistemas_quantidade'] + $content['operacoes_brigadas_incendios_quantidade'] + $content['operacoes_visitas_tecnicas_quantidade'] + $content['operacoes_ordens_servicos_quantidade'];

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=11 (Cliente Edificação - LUCs Ocupados)
    public function grafico_11_dados($cliente_id, $edificacao_id, $edificacao_nivel_id)
    {
        try {
            $this->cliente_id = $cliente_id;
            $this->edificacao_id = $edificacao_id;
            $this->edificacao_nivel_id = $edificacao_nivel_id;

            // array
            $content = array();

            // LUCs Quantidade
            $content['lucs_quantidade'] = $this->getCount(5);

            // LUCs Ocupadas
            $content['lucs_ocupadas'] = $this->getCount(6);

            // LUCs Desocupadas
            $content['lucs_desocupadas'] = $content['lucs_quantidade'] - $content['lucs_ocupadas'];

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=12 (Cliente Edificação - Documentos Exigidos)
    public function grafico_12_dados($cliente_id, $edificacao_id, $edificacao_nivel_id)
    {
        try {
            $this->cliente_id = $cliente_id;
            $this->edificacao_id = $edificacao_id;
            $this->edificacao_nivel_id = $edificacao_nivel_id;

            // array
            $content = array();

            // Documentos Exigidos Pendentes
            $content['documentos_exigidos_pendentes'] = $this->getCount(2) - $this->getCount(1);

            // Documentos Exigidos Lançados
            $content['documentos_exigidos_lancados'] = $this->getCount(1);

            // Documentos Exigidos Quantidade
            $content['documentos_exigidos_quantidade'] = $this->getCount(2);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    // Gráfico id=13 (Status Documentação Geral)
    public function grafico_13_dados($cliente_id, $edificacao_id, $edificacao_nivel_id)
    {
        try {
            $this->cliente_id = $cliente_id;
            $this->edificacao_id = $edificacao_id;
            $this->edificacao_nivel_id = $edificacao_nivel_id;

            // array
            $content = array();

            // Documentos Exigidos Quantidade
            $content['documentos_exigidos_quantidade'] = $this->getCount(2);

            // Documentos Exigidos Lançados
            $content['documentos_exigidos_lancados'] = $this->getCount(1);

            // Documentos Exigidos não Lançados
            $content['documentos_exigidos_nao_lancados'] = $content['documentos_exigidos_quantidade'] - $content['documentos_exigidos_lancados'];

            // Documentos Exigidos Vencidos
            $content['documentos_exigidos_vencidos'] = $this->getCount(3);

            // Documentos Exigidos não Vencidos
            $content['documentos_exigidos_nao_vencidos'] = $this->getCount(4);

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function grafico_14_dados()
    {
        try {
            // array
            $content = array();

        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function grafico_15_dados()
    {
        try {
            // array
            $content = array();

        } catch (\Exception $e) {
            if (config('app.debug')) {return $this->sendResponse($e->getMessage(), 5000, null, null);}

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function getCount($op) {
        // Documentos Exigidos Lançados
        if ($op == 1) {
            return ClienteDocumentoExigido::query()
                        ->join('edificacoes', 'edificacoes.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id')
                        ->leftjoin('edificacoes_niveis', 'edificacoes_niveis.edificacao_id', '=', 'edificacoes.id')
                        ->join('clientes_documentos', function($join) {
                            $join->on('clientes_documentos.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id')
                            ->on('clientes_documentos.documento_id', '=', 'clientes_documentos_exigidos.documento_id')
                            ->on('clientes_documentos.edificacao_id', '=', 'edificacoes.id');
                        })
                        ->where('edificacoes.cliente_id', $this->cliente_id)
                        ->when($this->edificacao_id != 0, function ($q) {
                            $q->where('edificacoes.id', $this->edificacao_id);
                        })
                        ->when($this->edificacao_nivel_id != 0, function ($q) {
                            $q->where('edificacoes_niveis.id', $this->edificacao_nivel_id);
                        })
                        ->whereNotNull('clientes_documentos.caminho')
                        ->distinct('clientes_documentos_exigidos.id')
                        ->count();
        }

        // Documentos Exigidos Quantidade
        if ($op == 2) {
            return ClienteDocumentoExigido::where('cliente_id', $this->cliente_id)->count();
        }

        // Documentos Exigidos Vencidos
        if ($op == 3) {
            return ClienteDocumentoExigido::query()
                        ->join('edificacoes', 'edificacoes.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id')
                        ->leftjoin('edificacoes_niveis', 'edificacoes_niveis.edificacao_id', '=', 'edificacoes.id')
                        ->join('clientes_documentos', function ($join) {
                            $join->on('clientes_documentos.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id')
                            ->on('clientes_documentos.documento_id', '=', 'clientes_documentos_exigidos.documento_id')
                            ->on('clientes_documentos.edificacao_id', '=', 'edificacoes.id');
                        })
                        ->where('edificacoes.cliente_id', $this->cliente_id)
                        ->when($this->edificacao_id != 0, function ($q) {
                            $q->where('edificacoes.id', $this->edificacao_id);
                        })
                        ->when($this->edificacao_nivel_id != 0, function ($q) {
                            $q->where('edificacoes_niveis.id', $this->edificacao_nivel_id);
                        })
                        ->whereNotNull('clientes_documentos.caminho')
                        ->whereDate('clientes_documentos.data_vencimento', '<', date('Y-m-d'))
                        ->distinct('clientes_documentos_exigidos.id')
                        ->count();
        }

        // Documentos Exigidos não Vencidos
        if ($op == 4) {
            return ClienteDocumentoExigido::query()
                        ->join('edificacoes', 'edificacoes.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id')
                        ->leftjoin('edificacoes_niveis', 'edificacoes_niveis.edificacao_id', '=', 'edificacoes.id')
                        ->join('clientes_documentos', function ($join) {
                            $join->on('clientes_documentos.cliente_id', '=', 'clientes_documentos_exigidos.cliente_id')
                            ->on('clientes_documentos.documento_id', '=', 'clientes_documentos_exigidos.documento_id')
                            ->on('clientes_documentos.edificacao_id', '=', 'edificacoes.id');
                        })
                        ->where('edificacoes.cliente_id', $this->cliente_id)
                        ->when($this->edificacao_id != 0, function ($q) {
                            $q->where('edificacoes.id', $this->edificacao_id);
                        })
                        ->when($this->edificacao_nivel_id != 0, function ($q) {
                            $q->where('edificacoes_niveis.id', $this->edificacao_nivel_id);
                        })
                        ->whereNotNull('clientes_documentos.caminho')
                        ->whereDate('clientes_documentos.data_vencimento', '>=', date('Y-m-d'))
                        ->distinct('clientes_documentos_exigidos.id')
                        ->count();
        }

        // LUCs Quantidade
        if ($op == 5) {
            //return Edificacao::where('id', $this->edificacao_id)->value('quantidade_lucs');
            return Edificacao::where('cliente_id', $this->cliente_id)
                        ->when($this->edificacao_id != 0, function ($q) {
                            $q->where('id', $this->edificacao_id);
                        })
                        ->sum('quantidade_lucs');
        }

        // LUCs Ocupadas
        if ($op == 6) {
            return ClienteLoja::query()
                        ->leftjoin('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'clientes_lojas.edificacao_nivel_id')
                        ->join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                        ->where('edificacoes.cliente_id', $this->cliente_id)
                        ->when($this->edificacao_id != 0, function ($q) {
                            $q->where('edificacoes.id', $this->edificacao_id);
                        })
                        ->when($this->edificacao_nivel_id != 0, function ($q) {
                            $q->where('edificacoes_niveis.id', $this->edificacao_nivel_id);
                        })
                        ->whereNotNull('clientes_lojas.subordinado_cliente_id')
                        ->distinct('clientes_lojas.id')
                        ->count();
        }

        // Quantidade Lojas
        if ($op == 7) {
            return ClienteLoja::query()
                        ->join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'clientes_lojas.edificacao_nivel_id')
                        ->join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                        ->where('edificacoes.cliente_id', $this->cliente_id)
                        ->when($this->edificacao_id != 0, function ($q) {
                            $q->where('edificacoes.id', $this->edificacao_id);
                        })
                        ->when($this->edificacao_nivel_id != 0, function ($q) {
                            $q->where('edificacoes_niveis.id', $this->edificacao_nivel_id);
                        })
                        ->whereNotNull('clientes_lojas.subordinado_cliente_id')
                        ->distinct('clientes_lojas.id')
                        //->distinct('clientes_lojas.subordinado_cliente_id')
                        ->count();
        }

        // Usuários Quantidade
        if ($op == 8) {
            return User::count();
        }

        // Funcionários Quantidade
        if ($op == 9) {
            return Funcionario::when($this->x_cliente_id != 0, function ($query) {
                $query->where('tomador_servico_cliente_id', $this->x_cliente_id);
            })->count();
        }

        // Clientes Quantidade
        if ($op == 10) {
            return Cliente::when($this->x_cliente_id != 0, function ($query) {
                $query->where('principal_cliente_id', $this->x_cliente_id);
            })->count();
        }

        // Transações Quantidade
        if ($op == 11) {
            return Transacao::count();
        }

        // Ordens Serviços Quantidade
        if ($op == 12) {
            return OrdemServico::when($this->x_cliente_id != 0, function ($query) {
                $query->where('cliente_id', $this->x_cliente_id);
            })->count();
        }

        // Visitas Técnicas Quantidade
        if ($op == 13) {
            return VisitaTecnica::when($this->x_cliente_id != 0, function ($query) {
                $query->where('cliente_id', $this->x_cliente_id);
            })->count();
        }

        // Brigadas Incêndios Quantidade
        if ($op == 14) {
            return BrigadaIncendio::when($this->x_cliente_id != 0, function ($query) {
                $query->where('cliente_id', $this->x_cliente_id);
            })->count();
        }

        // Vistorias Sistemas Quantidade
        if ($op == 15) {
            return VistoriaSistema::when($this->x_cliente_id != 0, function ($query) {
                $query->where('cliente_id', $this->x_cliente_id);
            })->count();
        }

        // Quantidade Sistemas Preventivos
        if ($op == 16) {
            return ClienteSistemaPreventivo::query()
                    ->join('edificacoes_locais', 'edificacoes_locais.id', '=', 'clientes_sistemas_preventivos.edificacao_local_id')
                    ->join('edificacoes_niveis', 'edificacoes_niveis.id', '=', 'edificacoes_locais.edificacao_nivel_id')
                    ->join('edificacoes', 'edificacoes.id', '=', 'edificacoes_niveis.edificacao_id')
                    ->where('edificacoes.cliente_id', $this->cliente_id)
                    ->when($this->edificacao_id != 0, function ($q) {
                        $q->where('edificacoes.id', $this->edificacao_id);
                    })
                    ->when($this->edificacao_nivel_id != 0, function ($q) {
                        $q->where('edificacoes_niveis.id', $this->edificacao_nivel_id);
                    })
                    ->distinct('clientes_sistemas_preventivos.id')
                    ->count();
        }
    }
}
