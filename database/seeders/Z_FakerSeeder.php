<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\ClienteServico;
use App\Models\Funcionario;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\VisitaTecnica;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Z_FakerSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        //Arrays
        $tipos_sanguineos = ['A', 'B', 'O', 'AB'];
        $fatores_rhs = ['POSITIVO', 'NEGATIVO'];
        $parentescos = ['PAI', 'MÃE', 'AMIGO'];

        //Funcionários
        for($i=1; $i<=5; $i++) {
            Funcionario::create([
                'name' => $faker->name,
                'data_nascimento' => $faker->date('d/m/Y'),
                'contratacao_tipo_id' => 1,
                'genero_id' => 1,
                'departamento_id' => $faker->numberBetween(1, 4),
                'funcao_id' => $faker->numberBetween(1, 4),
                'cpf' => $faker->cpf(false),
                'fotografia_documento' => 'build/assets/images/funcionarios/funcionario-0.png',
                'email' => $faker->email,
                'nacionalidade_id' => $faker->numberBetween(1, 5),
                'personal_identidade_estado_id' => $faker->numberBetween(1, 5),
                'personal_identidade_orgao_id' => $faker->numberBetween(1, 5),
                'personal_identidade_numero' => $faker->numberBetween(4578746, 5678576),
                'personal_identidade_data_emissao' => $faker->date('d/m/Y'),
                'cep' => '20735130',
                'numero' => '309',
                'complemento' => '302',
                'logradouro' => 'Rua Medina',
                'bairro' => 'Meier',
                'localidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'tipo_sanguineo' => $faker->randomElement($tipos_sanguineos),
                'fator_rh' => $faker->randomElement($fatores_rhs),
                'altura' => $faker->numberBetween(150, 210),
                'peso' => $faker->numberBetween(60, 120),
                'doenca_diabetes' => $faker->numberBetween(0, 1),
                'doenca_hipertensao' => $faker->numberBetween(0, 1),
                'doenca_asma' => $faker->numberBetween(0, 1),
                'doenca_renal' => $faker->numberBetween(0, 1),
                'doenca_cardiaca' => $faker->numberBetween(0, 1),
                'doenca_outras' => 'OUTRAS',
                'deficiencia_qual' => 'DEFICIÊNCIA',
                'cirurgia_quais_quando' => 'CIRUTGIA',
                'hospitalizado_quando_porque' => '',
                'convulsoes_epilepsia_ultimo_episodio' => '',
                'alergia_medicamentos_alimentos_substancias' => '',
                'medicacao_continua_quais_dosagem_horarios' => '',
                'plano_saude_qual' => 'UNIMED',
                'fumante' => $faker->numberBetween(0, 1),
                'bebida_alcoolica' => $faker->numberBetween(0, 1),
                'atividade_fisica' => $faker->numberBetween(0, 1),
                'doenca_familia_diabetes' => $faker->numberBetween(0, 1),
                'doenca_familia_hipertensao' => $faker->numberBetween(0, 1),
                'doenca_familia_epilepsia' => $faker->numberBetween(0, 1),
                'doenca_familia_cardiaca' => $faker->numberBetween(0, 1),
                'doenca_familia_cancer' => $faker->numberBetween(0, 1),
                'doenca_familia_outras' => 'OUTRAS',
                'contato_1_nome' => $faker->name,
                'contato_1_parentesco' => $faker->randomElement($parentescos),
                'contato_1_telefone' => '21'.$faker->numerify('########'),
                'contato_1_celular' => '21'.$faker->numerify('9########'),
                'contato_2_nome' => $faker->name,
                'contato_2_parentesco' => $faker->randomElement($parentescos),
                'contato_2_telefone' => '21'.$faker->numerify('########'),
                'contato_2_celular' => '21'.$faker->numerify('9########'),
                'created_at' => now()
            ]);
        }

        //Clientes
        for($i=1; $i<=2; $i++) {
            Cliente::create([
                'status' => 1,
                'tipo' => 1,
                'name' => 'REDE '.$i,
                'cnpj' => $faker->cnpj(false),
                'email' => $faker->email,
                'telefone_1' => '21'.$faker->numerify('########'),
                'telefone_2' => '21'.$faker->numerify('########'),
                'celular_1' => '21'.$faker->numerify('9########'),
                'celular_2' => '21'.$faker->numerify('9########'),
                'cep' => '20735130',
                'numero' => '309',
                'complemento' => '302',
                'logradouro' => 'Rua Medina',
                'bairro' => 'Meier',
                'localidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'created_at' => now()
            ]);
        }
        for($i=1; $i<=2; $i++) {
            Cliente::create([
                'status' => 1,
                'tipo' => 1,
                'rede_cliente_id' => $i,
                'name' => 'SHOPPING '.$i,
                'cnpj' => $faker->cnpj(false),
                'email' => $faker->email,
                'telefone_1' => '21'.$faker->numerify('########'),
                'telefone_2' => '21'.$faker->numerify('########'),
                'celular_1' => '21'.$faker->numerify('9########'),
                'celular_2' => '21'.$faker->numerify('9########'),
                'cep' => '20735130',
                'numero' => '309',
                'complemento' => '302',
                'logradouro' => 'Rua Medina',
                'bairro' => 'Meier',
                'localidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'created_at' => now()
            ]);
        }
        for($i=1; $i<=15; $i++) {
            if (($i % 2) == 0) {
                $tipo = 2;
                $cpf = $faker->cpf(false);
                $cnpj = '';
            } else {
                $tipo = 1;
                $cpf = '';
                $cnpj = $faker->cnpj(false);
            }

            Cliente::create([
                'status' => 1,
                'tipo' => $tipo,
                'name' => $faker->name,
                'cnpj' => $cnpj,
                'cpf' => $cpf,
                'email' => $faker->email,
                'rede_cliente_id' => $faker->numberBetween(1, 2),
                'principal_cliente_id' => $faker->numberBetween(3, 4),
                'telefone_1' => '21'.$faker->numerify('########'),
                'telefone_2' => '21'.$faker->numerify('########'),
                'celular_1' => '21'.$faker->numerify('9########'),
                'celular_2' => '21'.$faker->numerify('9########'),
                'cep' => '20735130',
                'numero' => '309',
                'complemento' => '302',
                'logradouro' => 'Rua Medina',
                'bairro' => 'Meier',
                'localidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'created_at' => now()
            ]);
        }

        //Veículos
        $cores = ['Branco', 'Preto', 'Prata', 'Cinza', 'Vermelho', 'Azul', 'Verde', 'Amarelo', 'Laranja', 'Marrom'];
        for($i=1; $i<=10; $i++) {
            Veiculo::create([
                'veiculo_marca_id' => $faker->numberBetween(1, 6),
                'veiculo_modelo_id' => $faker->numberBetween(1, 6),
                'placa' => $faker->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'),
                'renavam' => $renavam = $faker->numerify('###########'),
                'chassi' => $chassi = $faker->regexify('[A-HJ-NPR-Z0-9]{17}'),
                'ano_modelo' => '2025',
                'ano_fabricacao' => '2024',
                'cor' => $faker->randomElement($cores),
                'veiculo_combustivel_id' => $faker->numberBetween(1, 4),
                'gnv' => $faker->numberBetween(1, 2),
                'blindado' => $faker->numberBetween(1, 2),
                'veiculo_categoria_id' => $faker->numberBetween(1, 3)
            ]);
        }

        //Clientes Executivos
        $funcoes = [
            'Analista de Sistemas', 'Desenvolvedor Back-End', 'Desenvolvedor Front-End', 'Gerente de Projetos',
            'Engenheiro de Software', 'Administrador de Redes', 'Coordenador de TI', 'Diretor de Tecnologia',
            'Assistente Administrativo', 'Analista Financeiro', 'Contador', 'Gerente de RH',
            'Analista de Marketing', 'Designer Gráfico', 'Especialista em UX/UI', 'Executivo de Vendas',
            'Gerente Comercial', 'Operador de Produção', 'Técnico em Manutenção', 'Supervisor de Logística'
        ];
        for($i=1; $i<=12; $i++) {
            ClienteExecutivo::create([
                'cliente_id' => $faker->numberBetween(1, 6),
                'executivo_nome' => $faker->name,
                'executivo_funcao' => $faker->randomElement($funcoes),
                'genero_id' => $faker->numberBetween(1, 2),
                'email' => $faker->email,
                'nacionalidade_id' => $faker->numberBetween(1, 5),
                'personal_identidade_estado_id' => $faker->numberBetween(1, 5),
                'personal_identidade_orgao_id' => $faker->numberBetween(1, 5),
                'personal_identidade_numero' => $faker->numberBetween(4578746, 5678576),
                'telefone_1' => '21'.$faker->numerify('########'),
                'telefone_2' => '21'.$faker->numerify('########'),
                'celular_1' => '21'.$faker->numerify('9########'),
                'celular_2' => '21'.$faker->numerify('9########'),
                'fotografia_documento' => 'build/assets/images/clientes_executivos/cliente_executivo-0.png',
                'cep' => '20735130',
                'numero' => '309',
                'complemento' => '302',
                'logradouro' => 'Rua Medina',
                'bairro' => 'Meier',
                'localidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'tipo_sanguineo' => $faker->randomElement($tipos_sanguineos),
                'fator_rh' => $faker->randomElement($fatores_rhs),
                'altura' => $faker->numberBetween(150, 210),
                'peso' => $faker->numberBetween(60, 120),
                'doenca_diabetes' => $faker->numberBetween(0, 1),
                'doenca_hipertensao' => $faker->numberBetween(0, 1),
                'doenca_asma' => $faker->numberBetween(0, 1),
                'doenca_renal' => $faker->numberBetween(0, 1),
                'doenca_cardiaca' => $faker->numberBetween(0, 1),
                'doenca_outras' => 'OUTRAS',
                'deficiencia_qual' => 'DEFICIÊNCIA',
                'cirurgia_quais_quando' => 'CIRUTGIA',
                'hospitalizado_quando_porque' => '',
                'convulsoes_epilepsia_ultimo_episodio' => '',
                'alergia_medicamentos_alimentos_substancias' => '',
                'medicacao_continua_quais_dosagem_horarios' => '',
                'plano_saude_qual' => 'UNIMED',
                'fumante' => $faker->numberBetween(0, 1),
                'bebida_alcoolica' => $faker->numberBetween(0, 1),
                'atividade_fisica' => $faker->numberBetween(0, 1),
                'doenca_familia_diabetes' => $faker->numberBetween(0, 1),
                'doenca_familia_hipertensao' => $faker->numberBetween(0, 1),
                'doenca_familia_epilepsia' => $faker->numberBetween(0, 1),
                'doenca_familia_cardiaca' => $faker->numberBetween(0, 1),
                'doenca_familia_cancer' => $faker->numberBetween(0, 1),
                'doenca_familia_outras' => 'OUTRAS',
                'contato_1_nome' => $faker->name,
                'contato_1_parentesco' => $faker->randomElement($parentescos),
                'contato_1_telefone' => '21'.$faker->numerify('########'),
                'contato_1_celular' => '21'.$faker->numerify('9########'),
                'contato_2_nome' => $faker->name,
                'contato_2_parentesco' => $faker->randomElement($parentescos),
                'contato_2_telefone' => '21'.$faker->numerify('########'),
                'contato_2_celular' => '21'.$faker->numerify('9########'),
            ]);
        }

        //Visitas Técnicas
        for($i=1; $i<=10; $i++) {
            VisitaTecnica::create([
                'empresa_id' => $faker->numberBetween(1, 2),
                'visita_tecnica_tipo_id' => $faker->numberBetween(1, 2),
                'numero_visita_tecnica' => $i,
                'ano_visita_tecnica' => '2025',
                'data_abertura' => '24/07/2025',
                'hora_abertura' => '18:09',
                'data_prevista' => '24/07/2025',
                'hora_prevista' => '18:09',
                'visita_tecnica_status_id' => $faker->numberBetween(1, 2),
                'cliente_id' => $faker->numberBetween(1, 3),
                'vt_cs' => $faker->numberBetween(1, 2)
            ]);
        }

        //Ordens de Serviços
        for($i=1; $i<=10; $i++) {
            OrdemServico::create([
                'empresa_id' => $faker->numberBetween(1, 2),
                'ordem_servico_tipo_id' => $faker->numberBetween(1, 3),
                'numero_ordem_servico' => $i,
                'ano_ordem_servico' => '2025',
                'data_abertura' => '24/07/2025',
                'hora_abertura' => '18:09',
                'data_prevista' => '24/07/2025',
                'hora_prevista' => '18:09',
                'ordem_servico_status_id' => $faker->numberBetween(1, 2),
                'cliente_id' => $faker->numberBetween(1, 3),
                'ordem_servico_prioridade_id' => $faker->numberBetween(1, 3)
            ]);
        }

        //Propostas
        for($i=1; $i<=10; $i++) {
            Proposta::create([
                'empresa_id' => $faker->numberBetween(1, 2),
                'data_proposta' => '24/07/2025',
                'numero_proposta' => $i,
                'ano_proposta' => '2025',
                'cliente_id' => $faker->numberBetween(1, 3)
            ]);
        }

        // Usuários
        for($i=1; $i<=50; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'user_confirmed_at' => now(),
                'avatar' => 'build/assets/images/users/avatar-0.png',
                'created_at' => now()
            ]);
        }
    }
}