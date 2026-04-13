<?php

namespace App\Http\Controllers;

use App\Models\BrigadaIncendio;
use App\Models\Cliente;
use App\Models\ClienteDocumentoExigido;
use App\Models\ClienteLoja;
use App\Models\Funcionario;
use App\Models\GrupoGrafico;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\Transacao;
use App\Models\User;
use App\Models\VisitaTecnica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $x_cliente_id;

    public function __construct(Request $request)
    {
        $this->x_cliente_id = $request->header('X-Cliente-Id');
    }

    public function graficos()
    {
        try {
            if ($this->x_cliente_id == 0) {$sistema = 1;} else {$sistema = 2;}

            // array
            $content = array();

            // Grupos Gráficos
            $content['grupos_graficos'] = GrupoGrafico::join('graficos', 'graficos.id', 'grupos_graficos.grafico_id')
                ->select('graficos.id as grafico_id', 'graficos.name as grafico_name', 'graficos.tipo as grafico_tipo', 'graficos.ordem_visualizacao as grafico_ordem_visualizacao')
                ->where('graficos.sistema', $sistema)
                ->where('grupos_graficos.grupo_id', Auth::user()->grupo_id)
                ->where('graficos.dashboard', 1)
                ->orderby('graficos.ordem_visualizacao', 'ASC')
                ->get();

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function grafico_dados($grafico_id)
    {
        try {
            // array
            $content = array();

            // Gráfico id=1 (Usuários Grupos)
            if ($grafico_id == 1) {
                // Usuários Quantidade
                $content['usuarios_quantidade'] = User::count();

                // Usuários Distribuição por Grupos
                $content['usuarios_grupos'] = DB::select("SELECT grupos.name, count(users.id) as quantidade FROM users INNER JOIN grupos ON users.grupo_id=grupos.id GROUP BY grupos.name ORDER BY grupos.name");
            }

            // Gráfico id=2 (Usuários Situações)
            if ($grafico_id == 2) {
                // Usuários Quantidade
                $content['usuarios_quantidade'] = User::count();

                // Usuários Distribuição por Situacoes
                $content['usuarios_situacoes'] = DB::select("SELECT situacoes.name, count(users.id) as quantidade FROM users INNER JOIN situacoes ON users.situacao_id=situacoes.id GROUP BY situacoes.name ORDER BY situacoes.name");
            }

            // Gráfico id=3 (Funcionários Contratações)
            if ($grafico_id == 3) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::count();

                // Funcionários Distribuição por Contratações
                $content['funcionarios_contratacoes'] = DB::select("SELECT contratacao_tipos.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN contratacao_tipos ON funcionarios.contratacao_tipo_id=contratacao_tipos.id GROUP BY contratacao_tipos.name ORDER BY contratacao_tipos.name");
            }

            // Gráfico id=4 (Funcionários Funções)
            if ($grafico_id == 4) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::count();

                // Funcionários Distribuição por Funções
                $content['funcionarios_funcoes'] = DB::select("SELECT funcoes.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN funcoes ON funcionarios.funcao_id=funcoes.id GROUP BY funcoes.name ORDER BY funcoes.name");
            }

            // Gráfico id=5 (Funcionários Gêneros)
            if ($grafico_id == 5) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::count();

                // Funcionários Distribuição por Gêneros
                $content['funcionarios_generos'] = DB::select("SELECT generos.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN generos ON funcionarios.genero_id=generos.id GROUP BY generos.name ORDER BY generos.name");
            }

            // Gráfico id=6 (Clientes Status)
            if ($grafico_id == 6) {
                // Clientes Quantidades
                $content['clientes_quantidade'] = Cliente::count();

                // Clientes Distribuição por Status
                $content['clientes_status'] = DB::select("SELECT CASE WHEN status=1 THEN 'ATIVO' WHEN status=2 THEN 'INATIVO' ELSE 'DESCONHECIDO' END AS name, count(clientes.id) as quantidade FROM clientes GROUP BY status ORDER BY status");
            }

            // Gráfico id=7 (Clientes Tipos)
            if ($grafico_id == 7) {
                // Clientes Quantidades
                $content['clientes_quantidade'] = Cliente::count();

                // Clientes Distribuição por Tipos
                $content['clientes_tipos'] = DB::select("SELECT CASE WHEN tipo=1 THEN 'PESSOA JURÍDICA' WHEN tipo=2 THEN 'PESSOA FÍSICA' ELSE 'DESCONHECIDO' END AS name, count(clientes.id) as quantidade FROM clientes GROUP BY tipo ORDER BY tipo");
            }

            // Gráfico id=8 (Transações Operações)
            if ($grafico_id == 8) {
                // Transações Quantidades
                $content['transacoes_quantidade'] = Transacao::count();

                // Transações Distribuição por Operações
                $content['transacoes_operacoes'] = DB::select("SELECT transacoes.operacao_id, operacoes.name, COUNT(*) as quantidade FROM transacoes INNER JOIN operacoes ON operacoes.id = transacoes.operacao_id GROUP BY transacoes.operacao_id, operacoes.name ORDER BY operacoes.name");
            }

            // Gráfico id=9 (Transações Submódulos)
            if ($grafico_id == 9) {
                // Transações Quantidades
                $content['transacoes_quantidade'] = Transacao::count();

                // Transações Distribuição por Submodulos
                $content['transacoes_submodulos'] = DB::select("SELECT transacoes.submodulo_id, submodulos.name, COUNT(*) as quantidade FROM transacoes INNER JOIN submodulos ON submodulos.id = transacoes.submodulo_id GROUP BY transacoes.submodulo_id, submodulos.name ORDER BY submodulos.name");
            }

            // Gráfico id=10 (Operações)
            if ($grafico_id == 10) {
                // Propostas Quantidade
                $content['operacoes_propostas_quantidade'] = Proposta::count();

                // Brigadas Incêndios Quantidade
                $content['operacoes_brigadas_incendios_quantidade'] = BrigadaIncendio::count();

                // Visitas Técnicas Quantidade
                $content['operacoes_visitas_tecnicas_quantidade'] = VisitaTecnica::count();

                // Ordens de Serviços Quantidade
                $content['operacoes_ordens_servicos_quantidade'] = OrdemServico::count();

                // Quantidade Total
                $content['operacoes_total_quantidade'] = $content['operacoes_propostas_quantidade'] + $content['operacoes_brigadas_incendios_quantidade'] + $content['operacoes_visitas_tecnicas_quantidade'] + $content['operacoes_ordens_servicos_quantidade'];
            }

            // Gráfico id=11 (Funcionários Contratações)
            if ($grafico_id == 11) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::where('tomador_servico_cliente_id', $this->x_cliente_id)->count();

                // Funcionários Distribuição por Contratações
                $content['funcionarios_contratacoes'] = DB::select("SELECT contratacao_tipos.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN contratacao_tipos ON funcionarios.contratacao_tipo_id=contratacao_tipos.id WHERE funcionarios.tomador_servico_cliente_id=" . $this->x_cliente_id . " GROUP BY contratacao_tipos.name ORDER BY contratacao_tipos.name");
            }

            // Gráfico id=12 (Funcionários Funções)
            if ($grafico_id == 12) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::where('tomador_servico_cliente_id', $this->x_cliente_id)->count();

                // Funcionários Distribuição por Funções
                $content['funcionarios_funcoes'] = DB::select("SELECT funcoes.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN funcoes ON funcionarios.funcao_id=funcoes.id WHERE funcionarios.tomador_servico_cliente_id=" . $this->x_cliente_id . " GROUP BY funcoes.name ORDER BY funcoes.name");
            }

            // Gráfico id=13 (Funcionários Gêneros)
            if ($grafico_id == 13) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::where('tomador_servico_cliente_id', $this->x_cliente_id)->count();

                // Funcionários Distribuição por Gêneros
                $content['funcionarios_generos'] = DB::select("SELECT generos.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN generos ON funcionarios.genero_id=generos.id WHERE funcionarios.tomador_servico_cliente_id=" . $this->x_cliente_id . " GROUP BY generos.name ORDER BY generos.name");
            }

            // Gráfico id=14 (Operações)
            if ($grafico_id == 14) {
                // Propostas Quantidade
                $content['operacoes_propostas_quantidade'] = Proposta::where('cliente_id', $this->x_cliente_id)->count();

                // Brigadas Incêndios Quantidade
                $content['operacoes_brigadas_incendios_quantidade'] = BrigadaIncendio::where('cliente_id', $this->x_cliente_id)->count();

                // Visitas Técnicas Quantidade
                $content['operacoes_visitas_tecnicas_quantidade'] = VisitaTecnica::where('cliente_id', $this->x_cliente_id)->count();

                // Ordens de Serviços Quantidade
                $content['operacoes_ordens_servicos_quantidade'] = OrdemServico::where('cliente_id', $this->x_cliente_id)->count();

                // Quantidade Total
                $content['operacoes_total_quantidade'] = $content['operacoes_propostas_quantidade'] + $content['operacoes_brigadas_incendios_quantidade'] + $content['operacoes_visitas_tecnicas_quantidade'] + $content['operacoes_ordens_servicos_quantidade'];
            }

            // Gráfico id=15 (Cliente Edificação Lojas)
            if ($grafico_id == 15) {
                // Lojas Ocupadas
                $content['lojas_ocupadas'] = ClienteLoja::join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
                    ->join('edificacoes', 'edificacoes.id', 'edificacoes_niveis.edificacao_id')
                    ->where('edificacoes.cliente_id', $this->x_cliente_id)
                    ->where('clientes_lojas.subordinado_cliente_id', '!=', null)
                    ->count();

                // Lojas Desocupadas
                $content['lojas_desocupadas'] = ClienteLoja::join('edificacoes_niveis', 'edificacoes_niveis.id', 'clientes_lojas.edificacao_nivel_id')
                    ->join('edificacoes', 'edificacoes.id', 'edificacoes_niveis.edificacao_id')
                    ->where('edificacoes.cliente_id', $this->x_cliente_id)
                    ->where('clientes_lojas.subordinado_cliente_id', '=', null)
                    ->count();

                // Lojas Total
                $content['lojas_total'] = $content['lojas_ocupadas'] + $content['lojas_desocupadas'];
            }

            // Gráfico id=16 (Cliente Documentos Exigidos)
            if ($grafico_id == 16) {
                // Documentos Exigidos Pendentes
                $content['documentos_exigidos_pendentes'] = ClienteDocumentoExigido::leftjoin('clientes_documentos', 'clientes_documentos.documento_id', 'clientes_documentos_exigidos.documento_id')
                    ->where('clientes_documentos_exigidos.cliente_id', $this->x_cliente_id)
                    ->where('clientes_documentos.caminho', '=', null)
                    ->count();

                // Documentos Exigidos Concluidos
                $content['documentos_exigidos_concluidos'] = ClienteDocumentoExigido::leftjoin('clientes_documentos', 'clientes_documentos.documento_id', 'clientes_documentos_exigidos.documento_id')
                    ->where('clientes_documentos_exigidos.cliente_id', $this->x_cliente_id)
                    ->where('clientes_documentos.caminho', '!=', null)
                    ->count();

                // Documentos Exigidos Total
                $content['documentos_exigidos_total'] = ClienteDocumentoExigido::where('cliente_id', $this->x_cliente_id)->count();
            }

            return $this->sendResponse('Registros enviados com sucesso.', 2000, null, $content);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
