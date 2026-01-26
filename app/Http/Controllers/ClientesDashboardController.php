<?php

namespace App\Http\Controllers;

use App\Models\BrigadaIncendio;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\GrupoGrafico;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\Transacao;
use App\Models\User;
use App\Models\VisitaTecnica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClientesDashboardController extends Controller
{
    public function graficos(Request $request)
    {
        $cliente_id = $request->header('X-Cliente-Id');



        // QUALQUER ALTERAÇÃO REPLICAR PARA O DashbordController, Dashbord2Controller E Dashbord3Controller

        try {
            // array
            $content = array();

            // Grupos Gráficos
            $content['grupos_graficos'] = GrupoGrafico
            ::join('graficos', 'graficos.id', 'grupos_graficos.grafico_id')
            ->select('graficos.id as grafico_id', 'graficos.name as grafico_name', 'graficos.tipo as grafico_tipo', 'graficos.ordem_visualizacao as grafico_ordem_visualizacao')
            ->where('graficos.sistema', 2)
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

    public function grafico_dados(Request $request, $grafico_id)
    {
        $cliente_id = $request->header('X-Cliente-Id');

        try {
            // array
            $content = array();

            // Gráfico id=11 (Funcionários Contratações)
            if ($grafico_id == 11) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::where('tomador_servico_cliente_id', $cliente_id)->count();

                // Funcionários Distribuição por Contratações
                $content['funcionarios_contratacoes'] = DB::select("SELECT contratacao_tipos.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN contratacao_tipos ON funcionarios.contratacao_tipo_id=contratacao_tipos.id WHERE funcionarios.tomador_servico_cliente_id=$cliente_id GROUP BY contratacao_tipos.name ORDER BY contratacao_tipos.name");
            }

            // Gráfico id=12 (Funcionários Funções)
            if ($grafico_id == 12) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::where('tomador_servico_cliente_id', $cliente_id)->count();

                // Funcionários Distribuição por Funções
                $content['funcionarios_funcoes'] = DB::select("SELECT funcoes.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN funcoes ON funcionarios.funcao_id=funcoes.id WHERE funcionarios.tomador_servico_cliente_id=$cliente_id GROUP BY funcoes.name ORDER BY funcoes.name");
            }

            // Gráfico id=13 (Funcionários Gêneros)
            if ($grafico_id == 13) {
                // Funcionarios Quantidade
                $content['funcionarios_quantidade'] = Funcionario::where('tomador_servico_cliente_id', $cliente_id)->count();

                // Funcionários Distribuição por Gêneros
                $content['funcionarios_generos'] = DB::select("SELECT generos.name, count(funcionarios.id) as quantidade FROM funcionarios INNER JOIN generos ON funcionarios.genero_id=generos.id WHERE funcionarios.tomador_servico_cliente_id=$cliente_id GROUP BY generos.name ORDER BY generos.name");
            }

            // Gráfico id=14 (Operações)
            if ($grafico_id == 14) {
                // Propostas Quantidade
                $content['operacoes_propostas_quantidade'] = Proposta::where('cliente_id', $cliente_id)->count();

                // Brigadas Incêndios Quantidade
                $content['operacoes_brigadas_incendios_quantidade'] = BrigadaIncendio::where('cliente_id', $cliente_id)->count();

                // Visitas Técnicas Quantidade
                $content['operacoes_visitas_tecnicas_quantidade'] = VisitaTecnica::where('cliente_id', $cliente_id)->count();

                // Ordens de Serviços Quantidade
                $content['operacoes_ordens_servicos_quantidade'] = OrdemServico::where('cliente_id', $cliente_id)->count();

                // Quantidade Total
                $content['operacoes_total_quantidade'] = $content['operacoes_propostas_quantidade'] + $content['operacoes_brigadas_incendios_quantidade'] + $content['operacoes_visitas_tecnicas_quantidade'] + $content['operacoes_ordens_servicos_quantidade'];
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
