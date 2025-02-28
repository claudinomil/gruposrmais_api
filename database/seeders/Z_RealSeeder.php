<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\UserConfiguracao;
use Illuminate\Database\Seeder;

class Z_RealSeeder extends Seeder
{
    public function run()
    {
        //Cadastrando os Funcionários que já estavam no Banco de Dados''''''''''''''''''''''''''''''''''''''''''''''''''
        Funcionario::create([
            'empresa_id' => 1,
            'id' => 2,
            'name' => 'KARINY SOARES CORRÊA',
            'data_nascimento' => '06/07/1980',
            'contratacao_tipo_id' => 2,
            'genero_id' => 2,
            'estado_civil_id' => 2,
            'escolaridade_id' => 8,
            'nacionalidade_id' => 3,
            'naturalidade_id' => 19,
            'email' => NULL,
            'pai' => 'GERALDO MANGELO CORREA',
            'mae' => 'DOROTEIRA AUGUSTA SOARES',
            'telefone_1' => NULL,
            'telefone_2' => NULL,
            'celular_1' => NULL,
            'celular_2' => NULL,
            'personal_identidade_estado_id' => 19,
            'personal_identidade_orgao_id' => 122,
            'personal_identidade_numero' => NULL,
            'personal_identidade_data_emissao' => NULL,
            'professional_identidade_estado_id' => 19,
            'professional_identidade_orgao_id' => NULL,
            'professional_identidade_numero' => NULL,
            'professional_identidade_data_emissao' => NULL,
            'cpf' => '09069621703',
            'pis' => NULL,
            'pasep' => NULL,
            'carteira_trabalho' => NULL,
            'cep' => '20261004',
            'numero' => '39',
            'complemento' => 'APT 301',
            'logradouro' => 'RUA AURELIANO PORTUGAL',
            'bairro' => 'RIO COMPRIDO',
            'localidade' => 'RIO DE JANEIRO',
            'uf' => 'RJ',
            'departamento_id' => 1,
            'funcao_id' => 6,
            'banco_id' => 5,
            'agencia' => '8072',
            'conta' => '152377',
            'data_admissao' => NULL,
            'data_demissao' => NULL,
            'data_cadastro' => NULL,
            'data_afastamento' => NULL,
            'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
            'created_at' => now()
        ]);

        Funcionario::create([
            'empresa_id' => 1,
            'id' => 3,
            'name' => 'SHEILA DA SILVA GONÇALVES',
            'data_nascimento' => '20/07/1976',
            'contratacao_tipo_id' => 4,
            'genero_id' => 2,
            'estado_civil_id' => 2,
            'escolaridade_id' => 7,
            'nacionalidade_id' => 3,
            'naturalidade_id' => 21,
            'email' => NULL,
            'pai' => 'JOSÉ SETEMBRINO VALENÇA GONÇALVES',
            'mae' => 'LUCI DA SILVA',
            'telefone_1' => NULL,
            'telefone_2' => NULL,
            'celular_1' => NULL,
            'celular_2' => NULL,
            'personal_identidade_estado_id' => 19,
            'personal_identidade_orgao_id' => 72,
            'personal_identidade_numero' => '100951524',
            'personal_identidade_data_emissao' => '28/06/2011',
            'professional_identidade_estado_id' => NULL,
            'professional_identidade_orgao_id' => NULL,
            'professional_identidade_numero' => NULL,
            'professional_identidade_data_emissao' => NULL,
            'cpf' => '08309317751',
            'pis' => NULL,
            'pasep' => NULL,
            'carteira_trabalho' => NULL,
            'cep' => '25570180',
            'numero' => '33',
            'complemento' => NULL,
            'logradouro' => 'RUA AMÉRICO DE SOUZA',
            'bairro' => 'VILA SÃO JOÃO',
            'localidade' => 'SÃO JOÃO DE MERITI',
            'uf' => 'RJ',
            'departamento_id' => 1,
            'funcao_id' => 2,
            'banco_id' => 4,
            'agencia' => '0129',
            'conta' => '07006535',
            'data_admissao' => NULL,
            'data_demissao' => NULL,
            'data_cadastro' => '02/06/2023',
            'data_afastamento' => NULL,
            'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
            'created_at' => now()
        ]);

        Funcionario::create([
            'empresa_id' => 1,
            'id' => 4,
            'name' => 'LEONARDO ANDREI DOS SANTOS',
            'data_nascimento' => '25/02/1992',
            'contratacao_tipo_id' => 1,
            'genero_id' => 1,
            'estado_civil_id' => NULL,
            'escolaridade_id' => NULL,
            'nacionalidade_id' => 3,
            'naturalidade_id' => 19,
            'email' => NULL,
            'pai' => NULL,
            'mae' => 'ISABEL CRISTINA DOS SANTOS',
            'telefone_1' => NULL,
            'telefone_2' => NULL,
            'celular_1' => NULL,
            'celular_2' => NULL,
            'personal_identidade_estado_id' => NULL,
            'personal_identidade_orgao_id' => NULL,
            'personal_identidade_numero' => '245572433',
            'personal_identidade_data_emissao' => '15/07/2013',
            'professional_identidade_estado_id' => NULL,
            'professional_identidade_orgao_id' => NULL,
            'professional_identidade_numero' => NULL,
            'professional_identidade_data_emissao' => NULL,
            'cpf' => '14583567790',
            'pis' => '16445069437',
            'pasep' => NULL,
            'carteira_trabalho' => '96036',
            'cep' => '23075007',
            'numero' => '2466',
            'complemento' => 'BL 06',
            'logradouro' => 'ESTRADA DO TINGUI',
            'bairro' => 'CAMPO GRANDE',
            'localidade' => 'RIO DE JANEIRO',
            'uf' => 'RJ',
            'departamento_id' => 3,
            'funcao_id' => 1,
            'banco_id' => 5,
            'agencia' => NULL,
            'conta' => NULL,
            'data_admissao' => '01/10/2018',
            'data_demissao' => NULL,
            'data_cadastro' => NULL,
            'data_afastamento' => NULL,
            'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
            'created_at' => now()
        ]);

        Funcionario::create([
            'empresa_id' => 1,
            'id' => 5,
            'name' => 'CHRISTIAN DOS SANTOS VILLELA',
            'data_nascimento' => '13/02/1973',
            'contratacao_tipo_id' => 1,
            'genero_id' => 1,
            'estado_civil_id' => 2,
            'escolaridade_id' => 7,
            'nacionalidade_id' => 3,
            'naturalidade_id' => 19,
            'email' => NULL,
            'pai' => 'ALCIDES DOS SANTOS VILLELA',
            'mae' => 'DILCEA DA SILVA VILLELA',
            'telefone_1' => NULL,
            'telefone_2' => NULL,
            'celular_1' => NULL,
            'celular_2' => NULL,
            'personal_identidade_estado_id' => 19,
            'personal_identidade_orgao_id' => 96,
            'personal_identidade_numero' => '096876071',
            'personal_identidade_data_emissao' => '25/08/1990',
            'professional_identidade_estado_id' => NULL,
            'professional_identidade_orgao_id' => NULL,
            'professional_identidade_numero' => NULL,
            'professional_identidade_data_emissao' => NULL,
            'cpf' => '03386849725',
            'pis' => '12472120194',
            'pasep' => NULL,
            'carteira_trabalho' => NULL,
            'cep' => '21371020',
            'numero' => '444',
            'complemento' => 'CASA 02',
            'logradouro' => 'RUA CÉSAR MÚZIO',
            'bairro' => 'VICENTE DE CARVALHO',
            'localidade' => 'RIO DE JANEIRO',
            'uf' => 'RJ',
            'departamento_id' => 3,
            'funcao_id' => 1,
            'banco_id' => 5,
            'agencia' => NULL,
            'conta' => NULL,
            'data_admissao' => '17/06/2022',
            'data_demissao' => NULL,
            'data_cadastro' => NULL,
            'data_afastamento' => NULL,
            'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
            'created_at' => now()
        ]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Cadastrando os Grupos que já estavam no Banco de Dados''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grupo::create(['id' => 2, 'empresa_id' => 1, 'name' => 'COMERCIAL']);

        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 31]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 33]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 41]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 43]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 96]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 97]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 98]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 99]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 101]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 103]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 106]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 108]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 118]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 120]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 123]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 124]);
        GrupoPermissao::create(['grupo_id' => 2, 'permissao_id' => 125]);

        Grupo::create(['id' => 3, 'empresa_id' => 1, 'name' => 'ADMINISTRATIVO']);

        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 21]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 22]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 23]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 24]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 31]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 32]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 33]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 34]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 36]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 38]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 41]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 43]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 46]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 47]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 48]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 49]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 50]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 51]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 53]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 56]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 58]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 61]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 63]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 66]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 68]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 71]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 73]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 76]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 78]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 81]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 82]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 83]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 84]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 85]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 86]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 87]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 88]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 89]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 90]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 91]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 92]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 93]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 94]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 95]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 96]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 97]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 98]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 99]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 100]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 101]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 103]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 106]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 107]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 108]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 109]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 110]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 111]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 113]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 115]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 118]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 120]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 123]);
        GrupoPermissao::create(['grupo_id' => 3, 'permissao_id' => 125]);

        Grupo::create(['id' => 4, 'empresa_id' => 1, 'name' => 'BRIGADA']);

        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 31]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 33]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 41]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 43]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 96]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 98]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 101]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 103]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 118]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 120]);
        GrupoPermissao::create(['grupo_id' => 4, 'permissao_id' => 121]);

        Grupo::create(['id' => 5, 'empresa_id' => 1, 'name' => 'MANUTENÇÃO']);

        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 31]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 33]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 41]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 43]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 96]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 98]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 101]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 113]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 115]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 118]);
        GrupoPermissao::create(['grupo_id' => 5, 'permissao_id' => 120]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Cadastrando os Usuários que já estavam no Banco de Dados''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $user = \App\Models\User::factory()->create([
            'id' => 3,
            'name' => 'KARINY SOARES CORRÊA',
            'email' => 'kariny.correa@gruposrmais.com.br',
            'password' => '$2y$10$IqVxibaifTZGgCKpa1d.FOEluVAkRuPB/81G59mjPPCt3hvuFWcZS',
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'created_at' => now()
        ]);

        UserConfiguracao::create([
            'user_id' => 3,
            'empresa_id' => 1,
            'grupo_id' => 2,
            'situacao_id' => 1,
            'sistema_acesso_id' => 1,
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable'
        ]);

        $user = \App\Models\User::factory()->create([
            'id' => 4,
            'name' => 'SHEILA',
            'email' => 'sgsheila01@gmail.com',
            'password' => '$2y$10$7kaHGS0aJ3Y4t4wYdqPnZO50uDo0M/Kt4YQr//RZTbjQCLqGlNDle',
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'created_at' => now()
        ]);

        UserConfiguracao::create([
            'user_id' => 4,
            'empresa_id' => 1,
            'grupo_id' => 3,
            'situacao_id' => 1,
            'sistema_acesso_id' => 1,
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable'
        ]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
