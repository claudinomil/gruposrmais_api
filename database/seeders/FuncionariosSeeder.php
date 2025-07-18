<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class FuncionariosSeeder extends Seeder
{
    public function run()
    {
        Funcionario::create([
            'id' => 1,
            'name' => 'MARCUS VINICIUS MACHADO DE OLIVEIRA',
            'data_nascimento' => '21/06/1972',
            'contratacao_tipo_id' => 4,
            'genero_id' => 1,
            'estado_civil_id' => 2,
            'escolaridade_id' => 9,
            'nacionalidade_id' => 3,
            'naturalidade_id' => 19,
            'email' => 'mvmdeoliveira@gmail.com',
            'pai' => 'MARCO AURELIO ALVES DE OLIVEIRA',
            'mae' => 'MARIA CELIA MACHADO DE OLIVEIRA',
            'telefone_1' => NULL,
            'telefone_2' => NULL,
            'celular_1' => NULL,
            'celular_2' => NULL,
            'personal_identidade_estado_id' => NULL,
            'personal_identidade_orgao_id' => NULL,
            'personal_identidade_numero' => NULL,
            'personal_identidade_data_emissao' => NULL,
            'professional_identidade_estado_id' => NULL,
            'professional_identidade_orgao_id' => NULL,
            'professional_identidade_numero' => NULL,
            'professional_identidade_data_emissao' => NULL,
            'cpf' => '02382468769',
            'pis' => NULL,
            'pasep' => NULL,
            'carteira_trabalho' => NULL,
            'cep' => NULL,
            'numero' => NULL,
            'complemento' => NULL,
            'logradouro' => NULL,
            'bairro' => NULL,
            'localidade' => NULL,
            'uf' => NULL,
            'departamento_id' => 5,
            'funcao_id' => 8,
            'banco_id' => NULL,
            'agencia' => NULL,
            'conta' => NULL,
            'data_admissao' => NULL,
            'data_demissao' => NULL,
            'data_cadastro' => NULL,
            'data_afastamento' => NULL,
            'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
            'created_at' => now()
        ]);
    }
}
