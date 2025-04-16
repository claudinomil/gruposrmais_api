<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\UserConfiguracao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Z_RealSeeder extends Seeder
{
    public function run()
    {
        //EMPRESA id:1 - INÍCIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //EMPRESA id:1 - INÍCIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

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
            'password' => Hash::make('12345678'),
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
            'password' => Hash::make('12345678'),
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

        //EMPRESA id:1 - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //EMPRESA id:1 - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //EMPRESA id:2 - INÍCIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //EMPRESA id:2 - INÍCIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Departamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Departamento::create(['id' => 6, 'empresa_id' => 2, 'name' => 'OPERACIONAL']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Funções'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Funcao::create(['id' => 10, 'empresa_id' => 2, 'name' => 'BOMBEIRO CIVIL']);
        Funcao::create(['id' => 11, 'empresa_id' => 2, 'name' => 'APOIO']);
        Funcao::create(['id' => 12, 'empresa_id' => 2, 'name' => 'CORDENADOR']);
        Funcao::create(['id' => 13, 'empresa_id' => 2, 'name' => 'VIDEOMAKER']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Cadastrando os Funcionários que vão trabalhar como Temporários no Carnaval de 2025''''''''''''''''''''''''''''
        $funcionarios = [
            ["nome" => "LETICIA APARECIDA  DE ALMEIDA", "genero_id" => 2, "data_nascimento" => "15/10/1993", "cpf" => "15809670784", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "285526836", "pix_tipo_id" => "4", "pix_chave" => "leticialhalmeida@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "AGATHA CAUÃNY DA SILVA IZIDRO", "genero_id" => 2, "data_nascimento" => "19/07/2004", "cpf" => "22569345784", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "352448088", "pix_tipo_id" => "1", "pix_chave" => "21968688284", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "AISHA PEREIRA CABOCLO", "genero_id" => 2, "data_nascimento" => "01/10/2002", "cpf" => "12070044726", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "285266920", "pix_tipo_id" => "1", "pix_chave" => "21989140707", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LUCIANO DE ABREU MARTINS", "genero_id" => 1, "data_nascimento" => "22/08/1970", "cpf" => "07097252723", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "091044024", "pix_tipo_id" => "2", "pix_chave" => "07097252723", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "VANESSA CRISTINA DA SILVA SANTOS COSTA", "genero_id" => 2, "data_nascimento" => "22/04/1991", "cpf" => "10158363728", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "204148555", "pix_tipo_id" => "1", "pix_chave" => "21966961196", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CRISTIANE FERREIRA DE FREITAS", "genero_id" => 2, "data_nascimento" => "08/06/1986", "cpf" => "11079030760", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "212291496", "pix_tipo_id" => "2", "pix_chave" => "11079030760", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DAIANE FLORENTINO DOS SANTOS", "genero_id" => 2, "data_nascimento" => "24/04/1996", "cpf" => "16520827789", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "217214782", "pix_tipo_id" => "2", "pix_chave" => "16520827789", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "FABIO NETO DOS SANTOS", "genero_id" => 1, "data_nascimento" => "05/01/1981", "cpf" => "08745761728", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "114618416", "pix_tipo_id" => "4", "pix_chave" => "neto35869@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DARLIANE FRANCISCA DA SILVA", "genero_id" => 2, "data_nascimento" => "29/01/1996", "cpf" => "15696878709", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "270411614", "pix_tipo_id" => "1", "pix_chave" => "21974002322", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "HELANDER FELIPE DE SOUZA", "genero_id" => 1, "data_nascimento" => "09/10/1994", "cpf" => "16485538771", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "293145587", "pix_tipo_id" => "2", "pix_chave" => "16485538771", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "VITOR HUGO SANTANA DE SOUZA", "genero_id" => 1, "data_nascimento" => "23/02/2004", "cpf" => "20310326745", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "322679564", "pix_tipo_id" => "1", "pix_chave" => "21988656055", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JANAINA SALVINO DE AMARANTE", "genero_id" => 2, "data_nascimento" => "05/09/1979", "cpf" => "08147056770", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "122474992", "pix_tipo_id" => "1", "pix_chave" => "21987910248", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LILIANE OLIVEIRA DA PAIXÃO FOLY", "genero_id" => 2, "data_nascimento" => "02/12/1984", "cpf" => "10785390731", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "213321839", "pix_tipo_id" => "4", "pix_chave" => "lilianefoly214@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LUCAS TERRA DA SILVA", "genero_id" => 1, "data_nascimento" => "24/05/1999", "cpf" => "13858390747", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "300820834", "pix_tipo_id" => "2", "pix_chave" => "18530703782", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANDRE LUIZ DE ANDRADE MARQUES JUNIOR", "genero_id" => 1, "data_nascimento" => "24/05/1999", "cpf" => "18530703782", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "300820834", "pix_tipo_id" => "2", "pix_chave" => "18530703782", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "VALESCA SILVA RAMOS", "genero_id" => 2, "data_nascimento" => "26/01/1989", "cpf" => "12764303700", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "2455877406", "pix_tipo_id" => "1", "pix_chave" => "21979200116", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "IURI RANGEL DE PINHO", "genero_id" => 1, "data_nascimento" => "31/05/2004", "cpf" => "18463490794", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "258853647", "pix_tipo_id" => "2", "pix_chave" => "18463490794", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DAVID GOMES", "genero_id" => 1, "data_nascimento" => "22/09/1995", "cpf" => "14522572727", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "272777947", "pix_tipo_id" => "4", "pix_chave" => "gomes85871@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "WILLIAN DE ALBERNAZ MORENO", "genero_id" => 1, "data_nascimento" => "10/03/1995", "cpf" => "15238087721", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "279398333", "pix_tipo_id" => "1", "pix_chave" => "21983843658", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "VITÓRIA DE SOUZA DO NASCIMENTO", "genero_id" => 2, "data_nascimento" => "10/01/2003", "cpf" => "19328641721", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "224729889", "pix_tipo_id" => "1", "pix_chave" => "21969471502", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JOÃO PEDRO MATOS MACIEL", "genero_id" => 1, "data_nascimento" => "01/03/2005", "cpf" => "17548238746", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "258499961", "pix_tipo_id" => "2", "pix_chave" => "17548238746", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "VANESSA DE AGUIAR CORDEIRO", "genero_id" => 2, "data_nascimento" => "13/10/1986", "cpf" => "11432826719", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "209149681", "pix_tipo_id" => "2", "pix_chave" => "11432826719", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RODRIGO BATISTA DA CRUZ", "genero_id" => 1, "data_nascimento" => "31/03/1993", "cpf" => "15795615781", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "273857011", "pix_tipo_id" => "2", "pix_chave" => "15795615781", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DANIEL CRUZ NASCIMENTO", "genero_id" => 1, "data_nascimento" => "05/01/1992", "cpf" => "14225213706", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "268286945", "pix_tipo_id" => "1", "pix_chave" => "21978956921", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "HIGOR GUSTAVO PEREIRA GOMES DA CRUZ", "genero_id" => 1, "data_nascimento" => "15/05/1995", "cpf" => "17068091741", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "287175483", "pix_tipo_id" => "1", "pix_chave" => "21966307779", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MARCOS TEIXEIRA DE SANTANA", "genero_id" => 1, "data_nascimento" => "09/09/1988", "cpf" => "12754752722", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "214903932", "pix_tipo_id" => "1", "pix_chave" => "21977410705", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "TIAGO LEONARDO LIMA DE VILHENA CARVALHO", "genero_id" => 1, "data_nascimento" => "06/06/1986", "cpf" => "11219852708", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "2065507704", "pix_tipo_id" => "1", "pix_chave" => "21987730746", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAIANE DOS SANTOS NASCIMENTO", "genero_id" => 2, "data_nascimento" => "05/04/1998", "cpf" => "17696519778", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "304889363", "pix_tipo_id" => "4", "pix_chave" => "sraiane456@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "RAIANE DOS SANTOS NASCIMENTO", "genero_id" => 2, "data_nascimento" => "05/04/1998", "cpf" => "17696519778", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "304889363", "pix_tipo_id" => "4", "pix_chave" => "sraiane456@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ALUISIO GAMA DA SILVA", "genero_id" => 1, "data_nascimento" => "20/03/1966", "cpf" => "96454253791", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "074769803", "pix_tipo_id" => "1", "pix_chave" => "21964940714", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "ALUISIO GAMA DA SILVA", "genero_id" => 1, "data_nascimento" => "20/03/1966", "cpf" => "96454253791", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "074769803", "pix_tipo_id" => "1", "pix_chave" => "21964940714", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAFAEL AZEVEDO SOUZA", "genero_id" => 1, "data_nascimento" => "14/03/1985", "cpf" => "10753726742", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "203123550", "pix_tipo_id" => "1", "pix_chave" => "21993152346", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MAILA SOUZA DA SILVA", "genero_id" => 2, "data_nascimento" => "19/05/1995", "cpf" => "17825737717", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "307701219", "pix_tipo_id" => "1", "pix_chave" => "21992572702", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "EDUARDO ALVES DE SOUZA", "genero_id" => 1, "data_nascimento" => "06/01/2000", "cpf" => "15707508740", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "267704997", "pix_tipo_id" => "1", "pix_chave" => "21980816004", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "EDUARDO ALVES DE SOUZA", "genero_id" => 1, "data_nascimento" => "06/01/2000", "cpf" => "15707508740", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "267704997", "pix_tipo_id" => "1", "pix_chave" => "21980816004", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DAVID SILVA LACERDA", "genero_id" => 1, "data_nascimento" => "24/10/1980", "cpf" => "05614806725", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "125825125", "pix_tipo_id" => "1", "pix_chave" => "21983053780", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CLESIO DOS SANTOS MACHADO JUNIOR", "genero_id" => 1, "data_nascimento" => "05/04/1993", "cpf" => "14219566759", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "223003120", "pix_tipo_id" => "1", "pix_chave" => "21990166638", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "IURI RANGEL DE PINTO", "genero_id" => 1, "data_nascimento" => "31/05/2004", "cpf" => "18463490794", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "258853647", "pix_tipo_id" => "2", "pix_chave" => "18463490794", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANDRESA DOS SANTOS DAMASIO FARIAS", "genero_id" => 2, "data_nascimento" => "29/12/2001", "cpf" => "22088918728", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "325081180", "pix_tipo_id" => "1", "pix_chave" => "21974910467", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MATHEUS MELO MAIA", "genero_id" => 1, "data_nascimento" => "22/08/1997", "cpf" => "17702192771", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "17702192771", "pix_tipo_id" => "1", "pix_chave" => "21980289183", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "PATRICK DOS SANTOS ESTEVES", "genero_id" => 1, "data_nascimento" => "16/06/2001", "cpf" => "06531134712", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "324268549", "pix_tipo_id" => "4", "pix_chave" => "patrickesteves626@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANDERSON DO VALLE BRITO", "genero_id" => 1, "data_nascimento" => "01/09/1988", "cpf" => "12854162790", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "238331391", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "ANDERSON DO VALLE BRITO", "genero_id" => 2, "data_nascimento" => "01/09/1988", "cpf" => "12854162790", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "238331391", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "EMILIA NUNES MEDEIROS", "genero_id" => 2, "data_nascimento" => "15/05/1990", "cpf" => "13973388733", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "264427519", "pix_tipo_id" => "1", "pix_chave" => "21990748006", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DENISE DE SÁ SILVA DE OLIVEIRA", "genero_id" => 2, "data_nascimento" => "21/12/1992", "cpf" => "15922576747", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "265475392", "pix_tipo_id" => "2", "pix_chave" => "15922576747", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "DENISE DE SÁ SILVA DE OLIVEIRA", "genero_id" => 2, "data_nascimento" => "21/12/1992", "cpf" => "15922576747", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "265475392", "pix_tipo_id" => "2", "pix_chave" => "15922576747", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "GABRIEL DE OLIVEIRA RIBEIRO", "genero_id" => 1, "data_nascimento" => "26/08/2000", "cpf" => "19235835739", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "310793930", "pix_tipo_id" => "2", "pix_chave" => "15922576747", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ISRAEL MARCOS COUTINHO DA COSTA", "genero_id" => 1, "data_nascimento" => "05/05/2005", "cpf" => "20731226712", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "267945945", "pix_tipo_id" => "2", "pix_chave" => "20731226712", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RODRIGO DA SILVA NASCIMENTO JUNIOR", "genero_id" => 1, "data_nascimento" => "29/03/2004", "cpf" => "22334490754", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "348180761", "pix_tipo_id" => "1", "pix_chave" => "21972454959", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "RODRIGO DA SILVA NASCIMENTO JUNIOR", "genero_id" => 1, "data_nascimento" => "29/03/2004", "cpf" => "22334490754", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "348180761", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAFAELA SOARES PEREIRA", "genero_id" => 2, "data_nascimento" => "05/06/1984", "cpf" => "16102648781", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "280051491", "pix_tipo_id" => "1", "pix_chave" => "21995904498", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "PALOMA DE SOUZA COSTA", "genero_id" => 2, "data_nascimento" => "21/07/1987", "cpf" => "05902392799", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "209971514", "pix_tipo_id" => "2", "pix_chave" => "05902339299", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANA JULIA CARDOSO MOREIRA", "genero_id" => 2, "data_nascimento" => "02/10/2005", "cpf" => "20802674771", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "265099465", "pix_tipo_id" => "2", "pix_chave" => "20802674771", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LUIS GUSTAVO MENEZES DE OLIVEIRA", "genero_id" => 1, "data_nascimento" => "16/07/2003", "cpf" => "14492958789", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "282946367", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JESSICA DOS SANTOS MONTEIRO", "genero_id" => 2, "data_nascimento" => "25/12/2001", "cpf" => "19040052760", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "322835612", "pix_tipo_id" => "1", "pix_chave" => "21982568896", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "KETHELEN MACEDO DA SILVA LEMOS", "genero_id" => 2, "data_nascimento" => "15/06/2003", "cpf" => "22858942790", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "33373681", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "WELLINGTON JOAQUIM DOS SANTOS", "genero_id" => 1, "data_nascimento" => "12/05/1976", "cpf" => "03567739735", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "100834092", "pix_tipo_id" => "2", "pix_chave" => "03567739735", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JOYCE DE SOUZA SANT'ANNA", "genero_id" => 2, "data_nascimento" => "26/05/1990", "cpf" => "12866812786", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "243493707", "pix_tipo_id" => "4", "pix_chave" => "jsantanna920@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "GENILSON RICARDO", "genero_id" => 1, "data_nascimento" => "15/02/1971", "cpf" => "01222393778", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "094182227", "pix_tipo_id" => "1", "pix_chave" => "21970214463", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LETICIA FREITAS BORELI", "genero_id" => 2, "data_nascimento" => "21/04/1997", "cpf" => "17931036743", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "308381201", "pix_tipo_id" => "2", "pix_chave" => "17931036743", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "BETRIZ KAROLINE DA SILVA", "genero_id" => 2, "data_nascimento" => "08/03/1993", "cpf" => "14335931735", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "211332309", "pix_tipo_id" => "2", "pix_chave" => "14335931735", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CHARLES ALPHONSE SERPA", "genero_id" => 1, "data_nascimento" => "17/08/1979", "cpf" => "05321403708", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "0119601847", "pix_tipo_id" => "4", "pix_chave" => "charlesserpa06@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ESTER VITORIA SCHMITH PINHEIRO", "genero_id" => 2, "data_nascimento" => "05/09/1999", "cpf" => "18027523745", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "247857592", "pix_tipo_id" => "1", "pix_chave" => "21965328717", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "ESTER VITORIA SCHMITH PINHEIRO", "genero_id" => 2, "data_nascimento" => "05/09/1999", "cpf" => "18027523745", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "247857592", "pix_tipo_id" => "1", "pix_chave" => "21965328717", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "FELIPE EUSÉBIO DA SILVA", "genero_id" => 1, "data_nascimento" => "07/08/2000", "cpf" => "18602342756", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "301962437", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MATHEUS SANTOS DA SILVA", "genero_id" => 1, "data_nascimento" => "10/01/2000", "cpf" => "17482185739", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "271339814", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LEONARDO DO SANTOS PINTO", "genero_id" => 1, "data_nascimento" => "13/04/1992", "cpf" => "14158335752", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "256561226", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAFAEL DE PAULA GONÇALVES MARIA", "genero_id" => 1, "data_nascimento" => "11/02/1989", "cpf" => "12460444710", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "215198144", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "THAIANA AZEVEDO DA SILVA DE FREITAS", "genero_id" => 2, "data_nascimento" => "10/11/1987", "cpf" => "12904605746", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "242272243", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "THAIANA AZEVEDO DA SILVA DE FREITAS", "genero_id" => 2, "data_nascimento" => "10/11/1987", "cpf" => "12904605746", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "242272243", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "BRUNO DE OLIVEIRA APRIGIO", "genero_id" => 2, "data_nascimento" => "26/05/1990", "cpf" => "13218769710", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "231152059", "pix_tipo_id" => "2", "pix_chave" => "13218769710", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "BRUNO DE OLIVEIRA APRIGIO", "genero_id" => 1, "data_nascimento" => "26/05/1990", "cpf" => "13218769710", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "231152059", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "PATRICK LEONARDO DE ABREU SOARES", "genero_id" => 1, "data_nascimento" => "28/02/1992", "cpf" => "14723422757", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "246919625", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MARCO AURELIO DA SILVA", "genero_id" => 1, "data_nascimento" => "18/06/1972", "cpf" => "02087682704", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "092522465", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAFAEL CELESTINO DE SOUZA", "genero_id" => 1, "data_nascimento" => "18/11/1992", "cpf" => "11985588730", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "219193872", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "BERNARDO MARQUES DE ARAUJO", "genero_id" => 1, "data_nascimento" => "22/05/2001", "cpf" => "15337261754", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "", "pix_tipo_id" => "1", "pix_chave" => "21979077595", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "BERNARDO MARQUES DE ARAUJO", "genero_id" => 1, "data_nascimento" => "22/05/2001", "cpf" => "15337261754", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "239782618", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "FABIANA RENOVATA MENDONÇA", "genero_id" => 2, "data_nascimento" => "29/03/1984", "cpf" => "10534290701", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "209801927", "pix_tipo_id" => "1", "pix_chave" => "21994563038", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "FABIANA RENOVATA MENDONÇA", "genero_id" => 2, "data_nascimento" => "29/03/1984", "cpf" => "10534290701", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "209801927", "pix_tipo_id" => "1", "pix_chave" => "21994563038", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ESTER GOMES LOPES DE ALMEIDA", "genero_id" => 2, "data_nascimento" => "08/01/2002", "cpf" => "17029663721", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "307054338", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "JOSE LUIZ DO NASCIMENTO", "genero_id" => 1, "data_nascimento" => "10/03/1983", "cpf" => "05483610709", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "130748254", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "RICHARDSON FERNANDI DA SILVA", "genero_id" => 1, "data_nascimento" => "24/08/1991", "cpf" => "14976205703", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "263591786", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "EDUARDO SOUZA DE PAULA", "genero_id" => 1, "data_nascimento" => "05/02/1980", "cpf" => "95462244304", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "280817891", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "KAWANNE ASSUNÇÃO CARVALHO", "genero_id" => 2, "data_nascimento" => "02/02/1993", "cpf" => "12965676724", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "264776824", "pix_tipo_id" => "2", "pix_chave" => "22981304086", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "SUZANE BORGES", "genero_id" => 2, "data_nascimento" => "08/06/1989", "cpf" => "13317554762", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "267467694", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ALAN RAMOS MENDES", "genero_id" => 1, "data_nascimento" => "05/08/1997", "cpf" => "18511892702", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "281482018", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RONALDO DE SIQUEIRA CUNHA", "genero_id" => 1, "data_nascimento" => "12/10/1970", "cpf" => "03257383789", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "092253210", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MATHEUS MENDONÇA DOS SANTOS", "genero_id" => 1, "data_nascimento" => "04/11/1994", "cpf" => "17127950741", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "297407272", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MATHEUS TORRES LOURENÇO", "genero_id" => 1, "data_nascimento" => "09/11/2000", "cpf" => "18893229706", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "309217800", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CARLA DA CONCEIÇÃO SANTOS", "genero_id" => 2, "data_nascimento" => "12/08/1985", "cpf" => "13543732781", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "211491388", "pix_tipo_id" => "1", "pix_chave" => "21967740626", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ALAN LEAL HEMERLY", "genero_id" => 1, "data_nascimento" => "30/05/1978", "cpf" => "66806488234", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "294768940", "pix_tipo_id" => "2", "pix_chave" => "66806488234", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "IRISMAR DA SILVA DIAS DE SOUZA", "genero_id" => 1, "data_nascimento" => "12/10/1982", "cpf" => "93766343300", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "295412985", "pix_tipo_id" => "4", "pix_chave" => "irisdesouza@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LORRAYNE DA ISLVA SIQUEIRA", "genero_id" => 2, "data_nascimento" => "02/09/1999", "cpf" => "14520356792", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "286851019", "pix_tipo_id" => "4", "pix_chave" => "lorranebeberj@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MATHEUS ALMEIDA COSTA COCO", "genero_id" => 1, "data_nascimento" => "07/06/2000", "cpf" => "17453161754", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "323192401", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CLEITON NASCIMENTO", "genero_id" => 1, "data_nascimento" => "12/01/1985", "cpf" => "10978918797", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "208920397", "pix_tipo_id" => "2", "pix_chave" => "10978918797", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DOUGLAS HONÓRIO DE ARAUJO", "genero_id" => 1, "data_nascimento" => "25/05/1986", "cpf" => "10637335708", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "206703787", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "MARCOS PAULO MACHADO DE OLIVEIRA", "genero_id" => 1, "data_nascimento" => "24/10/1978", "cpf" => "09152319725", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "112666383", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
//            ["nome" => "MARCUS VINICIUS MACHADO DE OLIVEIRA", "genero_id" => 1, "data_nascimento" => "21/06/1972", "cpf" => "02382468789", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "OO87176970", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "FABRICIO PACHECO PEREIRA", "genero_id" => 1, "data_nascimento" => "20/7/1985", "cpf" => "10911662774", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "205284631", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
//            ["nome" => "SHEILA DA SILVA GONÇALVES", "genero_id" => 2, "data_nascimento" => "20/07/1976", "cpf" => "08309317751", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "100951524", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "GRACIETE  FERREIRA ROCHA", "genero_id" => 2, "data_nascimento" => "20/04/1982", "cpf" => "09251860742", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "120055421", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "FRANCISCO NEVES DA SILVA", "genero_id" => 1, "data_nascimento" => "13/10/1970", "cpf" => "01227875797", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "664797E12", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "CLARA DA SILVA GONÇALVES CUNHA", "genero_id" => 2, "data_nascimento" => "14/09/2006", "cpf" => "20970949707", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "281832477", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "DAIANE GOMES DE SOUSA", "genero_id" => 2, "data_nascimento" => "24/04/1995", "cpf" => "15642099701", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "282590587", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "BRUNA COELHO SANTA RITA PEREIRA", "genero_id" => 2, "data_nascimento" => "01/04/1979", "cpf" => "07778305747", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "116052853", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "EDUARDO XAVIER DE  TOLEDO BARCELOS", "genero_id" => 1, "data_nascimento" => "27/04/1974", "cpf" => "04271558788", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "71237", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "GIULIA GIOVANNA DRUMMOND POYARES", "genero_id" => 2, "data_nascimento" => "20/10/1991", "cpf" => "70006430139", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "13"],
            ["nome" => "ARIANE FELIPE DE SOUZA", "genero_id" => 2, "data_nascimento" => "28/11/1994", "cpf" => "16670586736", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "276945839", "pix_tipo_id" => "1", "pix_chave" => "21969089159", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "THATYANE LIMA RDA SILVA", "genero_id" => 2, "data_nascimento" => "28/11/1994", "cpf" => "14218390754", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "276945839", "pix_tipo_id" => "1", "pix_chave" => "21969089159", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MARCOS PAULO MIRANDA CORREIA DA SILVA", "genero_id" => 1, "data_nascimento" => "22/09/1984", "cpf" => "11839784725", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "201540994", "pix_tipo_id" => "1", "pix_chave" => "21972290560", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ESTER DE OLIVEIRA AUGUSTO", "genero_id" => 2, "data_nascimento" => "05/07/1998", "cpf" => "18637919731", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "309451540", "pix_tipo_id" => "1", "pix_chave" => "21986676267", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "REBECA DE LIMA PIRES MARTINS", "genero_id" => 2, "data_nascimento" => "28/04/1999", "cpf" => "15358634711", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "353736713", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "VINICIUS ALEXANDRE NASCIMENTO CORREIA DA SILVA", "genero_id" => 1, "data_nascimento" => "11/11/2001", "cpf" => "19962524709", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "294539168", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAYSSA KELLEN MOTA GOMES DA SILVA", "genero_id" => 2, "data_nascimento" => "24/01/2000", "cpf" => "19080469700", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "304179633", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "IAGO DE OLIVEIRA RODRIGUES", "genero_id" => 1, "data_nascimento" => "30/03/1997", "cpf" => "12546029762", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "305425456", "pix_tipo_id" => "1", "pix_chave" => "21970872009", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "IAGO DE OLIVERIA RODRIGUES", "genero_id" => 1, "data_nascimento" => "30/03/1997", "cpf" => "12546029762", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "305425456", "pix_tipo_id" => "1", "pix_chave" => "21970872009", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "RAMON GARCIA BEZERRA", "genero_id" => 1, "data_nascimento" => "30/03/2000", "cpf" => "19096056701", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "323281634", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MATHEUS MUNIZ AMORA", "genero_id" => 1, "data_nascimento" => "29/06/1997", "cpf" => "18482504797", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "286688106", "pix_tipo_id" => "1", "pix_chave" => "21964218292", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CLAYTON FERREIRA DA SILVA", "genero_id" => 1, "data_nascimento" => "14/03/2001", "cpf" => "17704916785", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "323532341", "pix_tipo_id" => "1", "pix_chave" => "21982152110", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "YAN LUCIANO SABINO GONÇALVES", "genero_id" => 1, "data_nascimento" => "09/03/1997", "cpf" => "17080159733", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "262691871", "pix_tipo_id" => "1", "pix_chave" => "21982152110", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ALINE CONCEIÇÃO DOS SANTOS GODOY DE AZEVEDO", "genero_id" => 2, "data_nascimento" => "24/06/1983", "cpf" => "05656703797", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "05656703797", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JHONATAN DE VAZ MONTEIRO", "genero_id" => 1, "data_nascimento" => "24/05/2002", "cpf" => "12512663710", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "268207032", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ADRIANO SOUZA BRANDÃO", "genero_id" => 1, "data_nascimento" => "02/07/1984", "cpf" => "10865790701", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "212248405", "pix_tipo_id" => "1", "pix_chave" => "21985348885", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "ADRIANO DE SOUZA BRANDÃO", "genero_id" => 2, "data_nascimento" => "02/07/1984", "cpf" => "10865790701", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "2122484005", "pix_tipo_id" => "1", "pix_chave" => "21971170978", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MARIA VICTORIA MARTIN GOMES", "genero_id" => 2, "data_nascimento" => "19/07/2002", "cpf" => "20102236755", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "313445298", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MOISES LOURIVAL SOBREIRA", "genero_id" => 1, "data_nascimento" => "29/03/1990", "cpf" => "13111292789", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "6425876908", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "11"],
            ["nome" => "PEDRO SANTA RITA DE OLIVEIRA", "genero_id" => 1, "data_nascimento" => "17/12/2001", "cpf" => "12056250705", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "JULIA SANTA RITA DE OLIVEIRA", "genero_id" => 2, "data_nascimento" => "15/02/2007", "cpf" => "13500345760", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "JULIA ALVES DE ALMEIDA GALINDO", "genero_id" => 2, "data_nascimento" => "07/08/2002", "cpf" => "19913402735", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "12"],
            ["nome" => "MARCUS VINICIUS BARBOSA DA FONSECA", "genero_id" => 1, "data_nascimento" => "06/07/1996", "cpf" => "16974024703", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "297914244", "pix_tipo_id" => "1", "pix_chave" => "21968549135", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "BRENO BARREIROS DA SILVA", "genero_id" => 1, "data_nascimento" => "07/04/1989", "cpf" => "01563425297", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "6756057", "pix_tipo_id" => "2", "pix_chave" => "01563425297", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "SANDRO ROGERIO DE SOUZA NASCIMENTO", "genero_id" => 1, "data_nascimento" => "15/12/1973", "cpf" => "03594341771", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "101610491", "pix_tipo_id" => "1", "pix_chave" => "21979673243", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "LEIDIANE GOMES DE OLIVEIRA", "genero_id" => 2, "data_nascimento" => "25/07/1987", "cpf" => "13317147709", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "208918110", "pix_tipo_id" => "2", "pix_chave" => "13317147709", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANDRESSA MARIA LIMA LA ROSA", "genero_id" => 2, "data_nascimento" => "15/07/1995", "cpf" => "16204821776", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "290293315", "pix_tipo_id" => "1", "pix_chave" => "21968285650", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JEAN DE SOUZA RODRIGUES", "genero_id" => 1, "data_nascimento" => "04/12/2004", "cpf" => "17751266767", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "338963069", "pix_tipo_id" => "2", "pix_chave" => "17751266767", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "BRUNO DA SILVA DUARTE", "genero_id" => 1, "data_nascimento" => "14/04/1989", "cpf" => "12871383731", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "211486808", "pix_tipo_id" => "1", "pix_chave" => "21983285777", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "ALAN RAMOS MENDES", "genero_id" => 2, "data_nascimento" => "05/08/1997", "cpf" => "18511892702", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "281482018", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "CRISTIANE CESAR DOS SANTOS", "genero_id" => 2, "data_nascimento" => "20/01/1988", "cpf" => "12254957767", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "241631696", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ALEXIA SANTOS LUCENA", "genero_id" => 2, "data_nascimento" => "06/12/1997", "cpf" => "17537050708", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "17537050708", "pix_tipo_id" => "2", "pix_chave" => "17537050708", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANGÉLICA ESCOBAR", "genero_id" => 2, "data_nascimento" => "13/04/1985", "cpf" => "10898691770", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "212385033", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "DAIANA DO NASCIMENTO RAMOS", "genero_id" => 2, "data_nascimento" => "29/11/1994", "cpf" => "15308378711", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "284886546", "pix_tipo_id" => "2", "pix_chave" => "15308378711", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "MARCELO EDUARDO SANFROT JUNGER", "genero_id" => 1, "data_nascimento" => "27/11/1998", "cpf" => "18415722761", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "29890344", "pix_tipo_id" => "1", "pix_chave" => "21990666748", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "CHARLES ALPHONSE SERPA", "genero_id" => 2, "data_nascimento" => "17/08/1979", "cpf" => "05321403708", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "0119601847", "pix_tipo_id" => "4", "pix_chave" => "charlesserpa06@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "JONATHA DOS SANTOS LUZ AGUIAR", "genero_id" => 1, "data_nascimento" => "06/11/1993", "cpf" => "15246464741", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "272263526", "pix_tipo_id" => "4", "pix_chave" => "jonatha93@gmail.com", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "SUZANE BORGES", "genero_id" => 2, "data_nascimento" => "08/06/1989", "cpf" => "13317554762", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "267467694", "pix_tipo_id" => NULL, "pix_chave" => "", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "LETICIA FREITAS BORELI", "genero_id" => 2, "data_nascimento" => "21/04/1997", "cpf" => "17931036743", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "308381201", "pix_tipo_id" => "2", "pix_chave" => "17931036743", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "BETRIZ KAROLINE DA SILVA", "genero_id" => 2, "data_nascimento" => "08/03/1993", "cpf" => "14335931735", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "211332309", "pix_tipo_id" => "2", "pix_chave" => "14335931735", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "PAULO ROBERTO DOS SANTOS MARTINS JUNIOR", "genero_id" => 1, "data_nascimento" => "18/09/1997", "cpf" => "18368855713", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "", "pix_tipo_id" => "1", "pix_chave" => "21989351544", "departamento_id" => "6", "funcao_id" => "10"],
//            ["nome" => "KAWANNE ASSUNÇÃO CARVALHO", "genero_id" => 2, "data_nascimento" => "02/02/1993", "cpf" => "12965676724", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "264776824", "pix_tipo_id" => "1", "pix_chave" => "22981304086", "departamento_id" => "6", "funcao_id" => "10"],
            ["nome" => "ANDREA BUENO DA FONSECA", "genero_id" => 2, "data_nascimento" => "03/08/1975", "cpf" => "07027364735", "personal_identidade_estado_id" => "19", "personal_identidade_orgao_id" => "70", "personal_identidade_numero" => "106351596", "pix_tipo_id" => "1", "pix_chave" => "21980689399", "departamento_id" => "6", "funcao_id" => "10"],

        ];


        /*


        $funcionario['nome']
        $funcionario['data_nascimento']
        $funcionario['genero_id']
        $funcionario['email']
        $funcionario['personal_identidade_estado_id']
        $funcionario['personal_identidade_orgao_id']
        $funcionario['personal_identidade_numero']
        $funcionario['cpf']
        $funcionario['pix_tipo_id']
        $funcionario['pix_chave']

        */





        foreach ($funcionarios as $funcionario) {
            Funcionario::create([
                'empresa_id' => 2,
                'name' => $funcionario['nome'],
                'data_nascimento' => $funcionario['data_nascimento'],
                'contratacao_tipo_id' => 4,
                'genero_id' => $funcionario['genero_id'],
//                'estado_civil_id' => NULL,
//                'escolaridade_id' => NULL,
//                'nacionalidade_id' => NULL,
                'naturalidade_id' => 19,
//                'email' => $funcionario['email'],
//                'pai' => '',
//                'mae' => '',
//                'telefone_1' => NULL,
//                'telefone_2' => NULL,
//                'celular_1' => NULL,
//                'celular_2' => NULL,
                'personal_identidade_estado_id' => $funcionario['personal_identidade_estado_id'],
                'personal_identidade_orgao_id' => $funcionario['personal_identidade_orgao_id'],
                'personal_identidade_numero' => $funcionario['personal_identidade_numero'],
//                'personal_identidade_data_emissao' => NULL,
//                'professional_identidade_estado_id' => NULL,
//                'professional_identidade_orgao_id' => NULL,
//                'professional_identidade_numero' => NULL,
//                'professional_identidade_data_emissao' => NULL,
                'cpf' => $funcionario['cpf'],
//                'pis' => NULL,
//                'pasep' => NULL,
//                'carteira_trabalho' => NULL,
//                'cep' => '',
//                'numero' => '',
//                'complemento' => '',
//                'logradouro' => '',
//                'bairro' => '',
//                'localidade' => '',
//                'uf' => '',
                'departamento_id' => $funcionario['departamento_id'],
                'funcao_id' => $funcionario['funcao_id'],
//                'banco_id' => NULL,
//                'agencia' => '',
//                'conta' => '',
//                'data_admissao' => NULL,
//                'data_demissao' => NULL,
//                'data_cadastro' => NULL,
//                'data_afastamento' => NULL,
                'pix_tipo_id' => $funcionario['pix_tipo_id'],
                'pix_chave' => $funcionario['pix_chave'],
                'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
                'created_at' => now()
            ]);
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Cadastrando os Grupos que já estavam no Banco de Dados''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Grupo::create(['id' => 6, 'empresa_id' => 2, 'name' => 'ADMINISTRADOR']);

        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 1]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 2]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 3]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 4]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 5]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 6]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 7]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 8]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 9]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 10]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 11]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 12]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 13]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 14]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 15]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 16]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 17]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 18]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 19]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 20]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 21]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 22]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 23]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 24]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 25]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 26]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 27]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 28]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 29]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 30]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 31]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 32]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 33]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 34]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 35]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 36]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 37]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 38]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 39]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 40]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 41]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 42]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 43]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 44]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 45]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 46]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 47]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 48]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 49]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 50]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 51]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 52]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 53]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 54]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 55]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 56]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 57]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 58]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 59]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 60]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 61]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 62]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 63]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 64]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 65]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 66]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 67]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 68]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 69]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 70]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 71]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 72]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 73]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 74]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 75]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 76]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 77]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 78]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 79]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 80]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 81]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 82]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 83]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 84]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 85]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 86]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 87]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 88]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 89]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 90]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 91]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 92]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 93]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 94]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 95]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 96]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 97]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 98]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 99]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 100]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 101]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 102]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 103]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 104]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 105]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 106]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 107]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 108]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 109]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 110]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 111]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 112]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 113]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 114]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 115]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 116]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 117]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 118]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 119]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 120]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 121]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 122]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 123]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 124]);
        GrupoPermissao::create(['grupo_id' => 6, 'permissao_id' => 125]);

        Grupo::create(['id' => 7, 'empresa_id' => 2, 'name' => 'ADMINISTRATIVO']);

        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 21]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 22]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 23]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 24]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 31]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 32]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 33]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 34]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 36]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 38]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 41]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 43]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 46]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 47]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 48]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 49]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 50]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 51]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 53]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 56]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 58]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 61]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 63]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 66]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 67]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 68]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 69]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 70]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 71]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 73]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 76]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 78]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 81]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 82]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 83]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 84]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 85]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 86]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 87]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 88]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 89]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 90]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 91]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 92]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 93]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 94]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 95]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 96]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 97]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 98]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 99]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 100]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 101]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 103]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 106]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 107]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 108]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 109]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 110]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 111]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 113]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 115]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 118]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 120]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 123]);
        GrupoPermissao::create(['grupo_id' => 7, 'permissao_id' => 125]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Cadastrando os Usuários que já estavam no Banco de Dados''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Usuário id=4 Sheila
        UserConfiguracao::create([
            'user_id' => 4,
            'empresa_id' => 2,
            'grupo_id' => 7,
            'situacao_id' => 1,
            'sistema_acesso_id' => 1,
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable'
        ]);

        //Usuário id=1 Claudino
        UserConfiguracao::create([
            'user_id' => 1,
            'empresa_id' => 2,
            'grupo_id' => 6,
            'situacao_id' => 1,
            'sistema_acesso_id' => 1,
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable'
        ]);

        //Usuário id=2 Marcus
        UserConfiguracao::create([
            'user_id' => 2,
            'empresa_id' => 2,
            'grupo_id' => 6,
            'situacao_id' => 1,
            'sistema_acesso_id' => 1,
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable'
        ]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //EMPRESA id:2 - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //EMPRESA id:2 - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
