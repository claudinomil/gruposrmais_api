<?php

namespace Database\Seeders;

use App\Models\BrigadaIncendio;
use App\Models\Cliente;
use App\Models\ClienteExecutivo;
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

class Z_Faker4Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Cliente id:1 Update''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Cliente::where('id', 1)->update(['dominio' => 'rede1']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // User id:2 Update'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::where('id', 2)->update(['cliente_id' => 1, 'grupo_id' => 11]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Funcionários Update''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        for($i=1; $i<21; $i++) {
            Funcionario::where('id', $i)->update(['tomador_servico_cliente_id' => 1]);
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Grupos Gráficos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 11]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 12]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 13]);
        GrupoGrafico::create(['grupo_id' => 11, 'grafico_id' => 14]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''



    }
}
