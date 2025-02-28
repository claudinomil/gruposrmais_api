<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteServico;
use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class Z_FakerSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        //Funcionários
        for($i=1; $i<=5; $i++) {
            Funcionario::create([
                'empresa_id' => 1,
                'name' => $faker->name,
                'data_nascimento' => $faker->date('d/m/Y'),
                'contratacao_tipo_id' => 1,
                'genero_id' => 1,
                'departamento_id' => $faker->numberBetween(1, 4),
                'funcao_id' => $faker->numberBetween(1, 4),
                'cpf' => $faker->cpf(false),
                'foto' => 'build/assets/images/funcionarios/funcionario-0.png',
                'created_at' => now()
            ]);
        }

        //Clientes
        for($i=1; $i<=3; $i++) {
            Cliente::create([
                'empresa_id' => 1,
                'status' => 1,
                'tipo' => 1,
                'name' => $faker->name,
                'cnpj' => $faker->cnpj(false),
                'created_at' => now()
            ]);

            Cliente::create([
                'empresa_id' => 1,
                'status' => 1,
                'tipo' => 2,
                'name' => $faker->name,
                'cpf' => $faker->cpf(false),
                'created_at' => now()
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
