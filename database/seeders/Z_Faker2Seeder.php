<?php

namespace Database\Seeders;

use App\Models\MaterialEntrada;
use App\Models\PontoInteresse;
use App\Models\PontoInteresseEspecialidade;
use Illuminate\Database\Seeder;

class Z_Faker2Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Alterando PontoInteresse - Iníco'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Bairros comumente considerados Zona Sul do RJ
        $bairros = ['COPACABANA', 'IPANEMA', 'LEBLON', 'BOTAFOGO', 'FLAMENGO', 'LEME', 'JARDIM BOTÂNICO', 'GÁVEA', 'HUMAITÁ', 'LARANJEIRAS', 'URCA', 'SANTA TERESA', 'GLÓRIA'];

        // Lista de logradouros típicos (apenas exemplos para variar)
        $logradouros = ['AVENIDA ATLÂNTICA', 'RUA BARÃO DA TORRE', 'RUA GUILHERME COTTA', 'RUA VISCONDE DE PIRAJÁ', 'AVENIDA PREFEITO OSMAR', 'RUA PAUL REDFERN', 'RUA DAS LARANJEIRAS', 'RUA JARDIM BOTÂNICO', 'RUA VOLUNTÁRIOS DA PÁTRIA', 'RUA URCA', 'RUA SÃO CLEMENTE'];

        // Atualizar ids 1..40
        for ($id = 1; $id <= 40; $id++) {
            $pi = PontoInteresse::find($id);
            if (! $pi) {
                // pula se o registro não existir
                continue;
            }

            // escolher bairro/logradouro aleatoriamente
            $bairro = $bairros[array_rand($bairros)];
            $logradouro = $logradouros[array_rand($logradouros)];

            // gerar CEP no formato 22000000 .. 22499999 (faixa aproximada do RJ zona sul)
            $cep_prefix = 22000 + random_int(0, 499); // 22000..22499
            $cep_suffix = str_pad((string) random_int(0, 999), 3, '0', STR_PAD_LEFT);
            $cep = sprintf('%05d-%s', $cep_prefix, $cep_suffix);
            $cep = str_replace('-', '', $cep);

            // número (pode ter letra)
            $numero = (string) random_int(1, 2000);
            if (random_int(0, 4) === 0) { // ~20% com sufixo
                $numero .= chr(65 + random_int(0, 2)); // A,B ou C
            }

            // complemento: 50% vazio, senão "APTO X" ou "LOJA X"
            $complemento = '';
            if (random_int(0, 1) === 1) {
                $tipo = random_int(0,1) ? 'APTO' : 'LOJA';
                $complemento = $tipo . ' ' . random_int(1, 999);
            }

            // telefones: padrão (21) 9xxxx-xxxx -> armazenamos como dígitos: 21 + 9 + 8 dígitos => 11 dígitos
            // Ex.: 21912345678
            $telefone1 = '21' . '9' . str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
            $telefone2 = '21' . '9' . str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

            // localidade e uf
            $localidade = 'RIO DE JANEIRO';
            $uf = 'RJ';

            // Natureza
            $ponto_natureza_id = $faker->numberBetween(1, 10);

            // garantir maiúsculas (mb para segurança com acentos)
            $pi->cep = mb_strtoupper($cep);
            $pi->numero = mb_strtoupper($numero);
            $pi->complemento = mb_strtoupper($complemento);
            $pi->logradouro = mb_strtoupper($logradouro);
            $pi->bairro = mb_strtoupper($bairro);
            $pi->localidade = mb_strtoupper($localidade);
            $pi->uf = mb_strtoupper($uf);
            $pi->telefone_1 = $telefone1;
            $pi->telefone_2 = $telefone2;
            $pi->ponto_natureza_id = $ponto_natureza_id;

            $pi->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Alterando PontoInteresseEspecialidade - Iníco''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        for ($pontoId = 1; $pontoId <= 10; $pontoId++) {

            // cria 10 especialidades diferentes (sem repetir dentro do mesmo ponto)
            $especialidades = collect(range(1, 56))->shuffle()->take(10);

            foreach ($especialidades as $especialidadeId) {
                PontoInteresseEspecialidade::create([
                    'ponto_interesse_id' => $pontoId,
                    'especialidade_id' => $especialidadeId,
                ]);
            }
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
