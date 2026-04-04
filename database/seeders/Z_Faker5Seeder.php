<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Edificacao;
use App\Models\EdificacaoNivel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Z_Faker5Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Criar Edificações e Edificações Níveis'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

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

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 10.00
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 2,
            'name' => 'Mezanino 1',
            'area_construida' => 10.00
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 2,
            'name' => 'Mezanino 2',
            'area_construida' => 20.00
        ]);
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

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 30.00
        ]);
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

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 15.00
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 3,
            'name' => 'Cobertura 1',
            'area_construida' => 20.00
        ]);
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

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 1,
            'name' => 'Pavimento 2',
            'area_construida' => 10.00
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 2,
            'name' => 'Mezanino 1',
            'area_construida' => 10.00
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 2,
            'nivel' => 2,
            'name' => 'Mezanino 2',
            'area_construida' => 10.00
        ]);

        // Edificação Nível
        $edificacao_nivel = EdificacaoNivel::create([
            'edificacao_id' => $edificacao->id,
            'ordem' => 1,
            'nivel' => 3,
            'name' => 'Cobertura 1',
            'area_construida' => 10.00
        ]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Usuário para testes no Grupo Cliente Domínio'''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::create([
            'name' => 'CLAUDINO TESTE 1',
            'email' => 'claudinoteste1@gmail.com',
            'situacao_id' => 1,
            'grupo_id' => 1,
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'created_at' => now()
        ]);

        User::create([
            'name' => 'CLAUDINO TESTE 2',
            'email' => 'claudinoteste2@gmail.com',
            'situacao_id' => 1,
            'grupo_id' => 11,
            'cliente_id' => 1,
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'created_at' => now()
        ]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
