<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteExecutivo;
use App\Models\ClienteServico;
use App\Models\Funcionario;
use App\Models\Veiculo;
use Illuminate\Database\Seeder;

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
                'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
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
        for($i=1; $i<=3; $i++) {
            Cliente::create([
                'status' => 1,
                'tipo' => 1,
                'name' => $faker->name,
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

            Cliente::create([
                'status' => 1,
                'tipo' => 2,
                'name' => $faker->name,
                'cpf' => $faker->cpf(false),
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
                'foto' => 'build/assets/images/clientes_executivos/cliente_executivo-0.png',
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

        /*

        //Cliente Serviços
        for($i=1; $i<=5; $i++) {
            //Brigada Incêndio''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            if ($i == 1) {
                $bi_escala_tipo_id = 1;
                $bi_quantidade_alas_escala = 4;
                $bi_quantidade_brigadistas_por_ala = 1;
                $bi_quantidade_brigadistas_total = 4;
                $bi_hora_inicio_ala = '08:00:00';
            } else if ($i == 2) {
                $bi_escala_tipo_id = 2;
                $bi_quantidade_alas_escala = 3;
                $bi_quantidade_brigadistas_por_ala = 1;
                $bi_quantidade_brigadistas_total = 3;
                $bi_hora_inicio_ala = '08:00:00';
            } else if ($i == 3) {
                $bi_escala_tipo_id = 3;
                $bi_quantidade_alas_escala = 4;
                $bi_quantidade_brigadistas_por_ala = 1;
                $bi_quantidade_brigadistas_total = 4;
                $bi_hora_inicio_ala = '08:00:00';
            } else if ($i == 4) {
                $bi_escala_tipo_id = 1;
                $bi_quantidade_alas_escala = 4;
                $bi_quantidade_brigadistas_por_ala = 1;
                $bi_quantidade_brigadistas_total = 4;
                $bi_hora_inicio_ala = '08:00:00';
            } else if ($i == 5) {
                $bi_escala_tipo_id = 2;
                $bi_quantidade_alas_escala = 3;
                $bi_quantidade_brigadistas_por_ala = 1;
                $bi_quantidade_brigadistas_total = 3;
                $bi_hora_inicio_ala = '08:00:00';
            }

            $cliente_servico = ClienteServico::create([
                'cliente_id' => $faker->numberBetween(1, 20),
                'servico_id' => 5,
                'servico_status_id' => 2,
                'responsavel_funcionario_id' => $faker->numberBetween(1, 10),
                'data_inicio' => '2023-08-01',
                'data_fim' => '2023-08-15',
                'data_vencimento' => '2023-08-15',

                'bi_escala_tipo_id' => $bi_escala_tipo_id,
                'bi_quantidade_alas_escala' => $bi_quantidade_alas_escala,
                'bi_quantidade_brigadistas_por_ala' => $bi_quantidade_brigadistas_por_ala,
                'bi_quantidade_brigadistas_total' => $bi_quantidade_brigadistas_total,
                'bi_hora_inicio_ala' => $bi_hora_inicio_ala
            ]);
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Visita Técnica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            ClienteServico::create([
                'cliente_id' => $faker->numberBetween(1, 20),
                'servico_id' => 6,
                'servico_status_id' => 2,
                'responsavel_funcionario_id' => $faker->numberBetween(1, 10),
                'data_inicio' => $faker->date('d/m/Y'),
                'data_fim' => $faker->date('d/m/Y'),
                'data_vencimento' => $faker->date('d/m/Y')
            ]);
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        }

        */


    }
}
