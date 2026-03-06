<?php

namespace Database\Seeders;

use App\Models\BrigadaIncendio;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Edificacao;
use App\Models\EdificacaoMedidaSeguranca;
use App\Models\EdificacaoNivel;
use App\Models\Fornecedor;
use App\Models\Funcionario;
use App\Models\GrupoGrafico;
use App\Models\Modulo;
use App\Models\ProdutoEntrada;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\Submodulo;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\VisitaTecnica;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Z_Faker5Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Criar Edificações e Edificações Níveis'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Para o Cliente SHOPPING 1'''''''''''''''''''''''''''''''''''''''''
        $cliente = Cliente::where('name', 'SHOPPING 1')->first();

        $edificacao = Edificacao::create([
            'cliente_id' => $cliente->id,
            'cliente_nome' => $cliente->name,
            'cliente_telefone' => $cliente->telefone_1,
            'cliente_celular' => $cliente->celular_1,
            'cliente_email' => $cliente->email,
            'cliente_logradouro' => $cliente->logradouro,
            'cliente_bairro' => $cliente->bairro,
            'cliente_cidade' => $cliente->cidade,
            'name' => 'Edificação Principal',
            'pavimentos' => 2,
            'mezaninos' => 2,
            'coberturas' => 0,
            'areas_tecnicas' => 0,
            'altura' => 2.22,
            'area_total_construida' => 50.0,
            'lotacao' => 1,
            'carga_incendio' => 1,
            'incendio_risco_id' => 1,
            'edificacao_classificacao_id' => 1,
            'grupo' => 'A',
            'ocupacao_uso' => 'Residencial',
            'divisao' => 'A-1',
            'descricao' => 'Residencial privativa unifamiliar',
            'definicao' => 'Casas térreas ou assobradadas (isoladas e não isoladas)'
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 1,
            'name' => 'Pavimento 1',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 2,
            'name' => 'Mezanino 1',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 2,
            'name' => 'Mezanino 2',
            'area_construida' => 20.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Para o Cliente SHOPPING 1'''''''''''''''''''''''''''''''''''''''''
        $cliente = Cliente::where('name', 'SHOPPING 1')->first();

        $edificacao = Edificacao::create([
            'cliente_id' => $cliente->id,
            'cliente_nome' => $cliente->name,
            'cliente_telefone' => $cliente->telefone_1,
            'cliente_celular' => $cliente->celular_1,
            'cliente_email' => $cliente->email,
            'cliente_logradouro' => $cliente->logradouro,
            'cliente_bairro' => $cliente->bairro,
            'cliente_cidade' => $cliente->cidade,
            'name' => 'Edificação Secundária',
            'pavimentos' => 2,
            'mezaninos' => 0,
            'coberturas' => 0,
            'areas_tecnicas' => 0,
            'altura' => 2.22,
            'area_total_construida' => 50.0,
            'lotacao' => 1,
            'carga_incendio' => 1,
            'incendio_risco_id' => 1,
            'edificacao_classificacao_id' => 1,
            'grupo' => 'A',
            'ocupacao_uso' => 'Residencial',
            'divisao' => 'A-1',
            'descricao' => 'Residencial privativa unifamiliar',
            'definicao' => 'Casas térreas ou assobradadas (isoladas e não isoladas)'
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 1,
            'name' => 'Pavimento 1',
            'area_construida' => 20.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 30.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Para o Cliente REDE 1'''''''''''''''''''''''''''''''''''''''''''''
        $cliente = Cliente::where('name', 'REDE 1')->first();

        $edificacao = Edificacao::create([
            'cliente_id' => $cliente->id,
            'cliente_nome' => $cliente->name,
            'cliente_telefone' => $cliente->telefone_1,
            'cliente_celular' => $cliente->celular_1,
            'cliente_email' => $cliente->email,
            'cliente_logradouro' => $cliente->logradouro,
            'cliente_bairro' => $cliente->bairro,
            'cliente_cidade' => $cliente->cidade,
            'name' => 'Edificação Principal',
            'pavimentos' => 2,
            'mezaninos' => 0,
            'coberturas' => 1,
            'areas_tecnicas' => 0,
            'altura' => 2.22,
            'area_total_construida' => 50.0,
            'lotacao' => 1,
            'carga_incendio' => 1,
            'incendio_risco_id' => 1,
            'edificacao_classificacao_id' => 1,
            'grupo' => 'A',
            'ocupacao_uso' => 'Residencial',
            'divisao' => 'A-1',
            'descricao' => 'Residencial privativa unifamiliar',
            'definicao' => 'Casas térreas ou assobradadas (isoladas e não isoladas)'
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 1,
            'name' => 'Pavimento 1',
            'area_construida' => 15.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 15.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 3,
            'name' => 'Cobertura 1',
            'area_construida' => 20.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Para o Cliente REDE 1'''''''''''''''''''''''''''''''''''''''''''''
        $cliente = Cliente::where('name', 'REDE 1')->first();

        $edificacao = Edificacao::create([
            'cliente_id' => $cliente->id,
            'cliente_nome' => $cliente->name,
            'cliente_telefone' => $cliente->telefone_1,
            'cliente_celular' => $cliente->celular_1,
            'cliente_email' => $cliente->email,
            'cliente_logradouro' => $cliente->logradouro,
            'cliente_bairro' => $cliente->bairro,
            'cliente_cidade' => $cliente->cidade,
            'name' => 'Edificação Principal',
            'pavimentos' => 2,
            'mezaninos' => 2,
            'coberturas' => 1,
            'areas_tecnicas' => 0,
            'altura' => 2.22,
            'area_total_construida' => 50.0,
            'lotacao' => 1,
            'carga_incendio' => 1,
            'incendio_risco_id' => 1,
            'edificacao_classificacao_id' => 1,
            'grupo' => 'A',
            'ocupacao_uso' => 'Residencial',
            'divisao' => 'A-1',
            'descricao' => 'Residencial privativa unifamiliar',
            'definicao' => 'Casas térreas ou assobradadas (isoladas e não isoladas)'
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 1,
            'name' => 'Pavimento 1',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 2,
            'name' => 'Mezanino 1',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 2,
            'name' => 'Mezanino 2',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 3,
            'name' => 'Cobertura 1',
            'area_construida' => 10.00
        ]);

        // Edificações Medidas Segurança
        for($i=1; $i<=24; $i++) {
            EdificacaoMedidaSeguranca::create([
                'edificacao_nivel_id' => $edificacao_nivel->id,
                'medida_seguranca_id' => $i,
                'quantidade' => 0
            ]);
        }
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Clientes Sistemas Preventivos (para o Cliente SHOPPING 1)''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Medida Segurança: APARELHO EXTINTOR
        ClienteSistemaPreventivo::create(['id' => 1, 'cliente_id' => 3, 'medida_seguranca_id' => 3, 'name' => 'PQS', 'sistema_preventivo_numero' => '0000001', 'descricao' => 'EXEMPLO DE DESCRIÇÃO']);
        ClienteSistemaPreventivo::create(['id' => 2, 'cliente_id' => 3, 'medida_seguranca_id' => 3, 'name' => 'CO2', 'sistema_preventivo_numero' => '0000002', 'descricao' => 'EXEMPLO DE DESCRIÇÃO']);
        ClienteSistemaPreventivo::create(['id' => 3, 'cliente_id' => 3, 'medida_seguranca_id' => 3, 'name' => 'ÁGUA', 'sistema_preventivo_numero' => '0000003', 'descricao' => 'EXEMPLO DE DESCRIÇÃO']);
        ClienteSistemaPreventivo::create(['id' => 4, 'cliente_id' => 3, 'medida_seguranca_id' => 3, 'name' => 'ESPUMA MECÂNICA', 'sistema_preventivo_numero' => '0000004', 'descricao' => 'EXEMPLO DE DESCRIÇÃO']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
