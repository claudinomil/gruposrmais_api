<?php

namespace Database\Seeders;

use App\Models\AtestadoSaudeOcupacionalTipo;
use App\Models\Cliente;
use App\Models\ClienteLoja;
use App\Models\Fornecedor;
use App\Models\Funcao;
use App\Models\MedidaSeguranca;
use App\Models\SistemaPreventivo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Z_Faker999Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Copiar dados Reais para Desenvolvimento - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Copiar dados Reais para Desenvolvimento - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if (Config::has('database.connections.gruposrmais01')) {
            // CONEXÃO COM PRODUÇÃO
            DB::connection('gruposrmais01')->getPdo();

            // Clientes - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('clientes')->get();

            // Totais
            $total_producao = $registros_producao->count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            for($i=1; $i<=$total_producao; $i++) {
                Cliente::create([
                    'status' => 1,
                    'tipo' => 1,
                    'name' => 'TESTE '.$i,
                    'created_at' => now()
                ]);
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('clientes')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Clientes - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // atestado_saude_ocupacional_tipos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // atestado_saude_ocupacional_tipos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('atestado_saude_ocupacional_tipos')->get();

            // Totais
            $total_producao = $registros_producao->count();
            $total_desenvolvimento = AtestadoSaudeOcupacionalTipo::count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            if ($total_producao > $total_desenvolvimento) {
                $total_diferenca = $total_producao - $total_desenvolvimento;

                for($i=1; $i<=$total_diferenca; $i++) {
                    AtestadoSaudeOcupacionalTipo::create([
                        'name' => 'TESTE '.$i,
                        'created_at' => now()
                    ]);
                }
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('atestado_saude_ocupacional_tipos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // atestado_saude_ocupacional_tipos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // atestado_saude_ocupacional_tipos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Funções - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funções - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('funcoes')->get();

            // Totais
            $total_producao = $registros_producao->count();
            $total_desenvolvimento = Funcao::count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            if ($total_producao > $total_desenvolvimento) {
                $total_diferenca = $total_producao - $total_desenvolvimento;

                for($i=1; $i<=$total_diferenca; $i++) {
                    Funcao::create([
                        'name' => 'TESTE '.$i,
                        'created_at' => now()
                    ]);
                }
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('funcoes')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Funções - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funções - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Funcionários - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funcionários - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('funcionarios')->get();

            // Alterar Funcionários com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('funcionarios')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Funcionários - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funcionários - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Funcionários Documentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funcionários Documentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('funcionarios_documentos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('funcionarios_documentos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Funcionários Documentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funcionários Documentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Funcionários Documentos Mensais - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funcionários Documentos Mensais - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('funcionarios_documentos_mensais')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('funcionarios_documentos_mensais')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Funcionários Documentos Mensais - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Funcionários Documentos Mensais - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Edificações - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Edificações - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('edificacoes')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('edificacoes')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Edificações - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Edificações - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Edificações Níveis - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Edificações Níveis - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('edificacoes_niveis')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('edificacoes_niveis')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Edificações Níveis - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Edificações Níveis - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Edificações Locais - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Edificações Locais - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('edificacoes_locais')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('edificacoes_locais')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Edificações Locais - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Edificações Locais - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Clientes Documentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Documentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('clientes_documentos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('clientes_documentos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Clientes Documentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Documentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Clientes Documentos Exigidos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Documentos Exigidos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('clientes_documentos_exigidos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('clientes_documentos_exigidos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Clientes Documentos Exigidos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Documentos Exigidos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Clientes Lojas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Lojas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('clientes_lojas')->get();

            // Totais
            $total_producao = $registros_producao->count();
            $total_desenvolvimento = ClienteLoja::count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            if ($total_producao > $total_desenvolvimento) {
                $total_diferenca = $total_producao - $total_desenvolvimento;

                for($i=1; $i<=$total_diferenca; $i++) {
                    ClienteLoja::create([
                        'edificacao_nivel_id' => 1,
                        'luc' => '101',
                        'ordem' => 10
                    ]);
                }
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('clientes_lojas')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Clientes Lojas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Lojas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Medidas Segurança - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Medidas Segurança - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('medidas_seguranca')->get();

            // Totais
            $total_producao = $registros_producao->count();
            $total_desenvolvimento = MedidaSeguranca::count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            if ($total_producao > $total_desenvolvimento) {
                $total_diferenca = $total_producao - $total_desenvolvimento;

                for($i=1; $i<=$total_diferenca; $i++) {
                    MedidaSeguranca::create([
                        'name' => 'TESTE '.$i,
                        'ordem' => 10
                    ]);
                }
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('medidas_seguranca')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Medidas Segurança - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Medidas Segurança - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Equipamentos Preventivos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Equipamentos Preventivos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('equipamentos_preventivos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('equipamentos_preventivos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Equipamentos Preventivos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Equipamentos Preventivos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Sistemas Preventivos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Sistemas Preventivos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('sistemas_preventivos')->get();

            // Totais
            $total_producao = $registros_producao->count();
            $total_desenvolvimento = SistemaPreventivo::count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            if ($total_producao > $total_desenvolvimento) {
                $total_diferenca = $total_producao - $total_desenvolvimento;

                for($i=1; $i<=$total_diferenca; $i++) {
                    SistemaPreventivo::create([
                        'medida_seguranca_id' => 1,
                        'name' => 'TESTE '.$i
                    ]);
                }
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('sistemas_preventivos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Sistemas Preventivos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Sistemas Preventivos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Sistemas Preventivos Equipamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Sistemas Preventivos Equipamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('sistemas_preventivos_equipamentos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('sistemas_preventivos_equipamentos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Sistemas Preventivos Equipamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Sistemas Preventivos Equipamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Clientes Sistemas Preventivos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Sistemas Preventivos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('clientes_sistemas_preventivos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('clientes_sistemas_preventivos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Clientes Sistemas Preventivos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Clientes Sistemas Preventivos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Estoques - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Estoques - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('estoques')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('estoques')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Estoques - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Estoques - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Estoques Locais - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Estoques Locais - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('estoques_locais')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('estoques_locais')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Estoques Locais - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Estoques Locais - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Fornecedores - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Fornecedores - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('fornecedores')->get();

            // Totais
            $total_producao = $registros_producao->count();

            // Criar Registros faker para depois alterar com a produção (PARA NÂO DAR ERROS)
            for($i=1; $i<=$total_producao; $i++) {
                Fornecedor::create([
                    'status' => 1,
                    'tipo' => 1,
                    'name' => 'TESTE '.$i
                ]);
            }

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('fornecedores')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Fornecedores - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Fornecedores - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Produtos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Produtos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('produtos')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('produtos')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Produtos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Produtos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Produtos Entradas - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Produtos Entradas - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('produtos_entradas')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('produtos_entradas')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Produtos Entradas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Produtos Entradas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Produtos Entradas Itens - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Produtos Entradas Itens - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $registros_producao = DB::connection('gruposrmais01')->table('produtos_entradas_itens')->get();

            // Alterar Registros com a Produção
            foreach ($registros_producao as $registro_producao) {
                $dados = (array) $registro_producao;

                unset($dados['id']);

                DB::table('produtos_entradas_itens')->updateOrInsert(
                    [
                        'id' => $registro_producao->id
                    ],
                    $dados
                );
            }
            // Produtos Entradas Itens - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Produtos Entradas Itens - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        }
        // Copiar dados Reais para Desenvolvimento - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Copiar dados Reais para Desenvolvimento - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
