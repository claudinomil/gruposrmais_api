<?php

namespace Database\Seeders;

use App\Models\OrdemServicoTipo;
use App\Models\Servico;
use App\Models\Veiculo;
use App\Models\VeiculoCategoria;
use App\Models\VeiculoCombustivel;
use App\Models\VeiculoMarca;
use App\Models\VeiculoModelo;
use Illuminate\Database\Seeder;

class ZZZ_20260505_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Serviços
        Servico::create(['id' => 8, 'name' => 'TRANSPORTE DE FUNCIONÁRIOS', 'servico_tipo_id' => 4, 'valor' => '0.00']);

        // Ordens Serviços Tipos
        OrdemServicoTipo::create(['id' => 4, 'name' => 'TRANSPORTE DE FUNCIONÁRIOS']);

        // Veículo Categorias
        VeiculoCategoria::create(['id' => 4, 'name' => 'UBER']);
        VeiculoCategoria::create(['id' => 5, 'name' => 'Taxi']);

        // Veículo Marcas
        VeiculoMarca::create(['id' => 21, 'name' => 'UBER']);
        VeiculoMarca::create(['id' => 22, 'name' => 'Taxi']);

        // Veículo Modelos
        VeiculoModelo::create(['id' => 70, 'veiculo_marca_id' => 21, 'name' => 'UBER']);
        VeiculoModelo::create(['id' => 71, 'veiculo_marca_id' => 22, 'name' => 'Taxi']);

        // Veículo
        Veiculo::create(['veiculo_marca_id' => 21, 'veiculo_modelo_id' => 70, 'placa' => 'ZZZ9999', 'renavam' => '9999999999', 'chassi' => '999999999999999', 'ano_modelo' => '9999', 'ano_fabricacao' => '9999', 'cor' => 'PRETO', 'veiculo_combustivel_id' => 8, 'gnv' => 2, 'blindado' => 2, 'veiculo_categoria_id' => 4]);
        Veiculo::create(['veiculo_marca_id' => 22, 'veiculo_modelo_id' => 71, 'placa' => 'ZZZ8888', 'renavam' => '8888888888', 'chassi' => '888888888888888', 'ano_modelo' => '8888', 'ano_fabricacao' => '8888', 'cor' => 'PRETO', 'veiculo_combustivel_id' => 8, 'gnv' => 2, 'blindado' => 2, 'veiculo_categoria_id' => 5]);
    }
}
