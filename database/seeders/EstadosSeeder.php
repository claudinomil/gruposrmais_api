<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    public function run()
    {
        Estado::create(['name' => 'Acre', 'uf' => 'AC']);
        Estado::create(['name' => 'Alagoas', 'uf' => 'AL']);
        Estado::create(['name' => 'Amapá', 'uf' => 'AP']);
        Estado::create(['name' => 'Amazonas', 'uf' => 'AM']);
        Estado::create(['name' => 'Bahia', 'uf' => 'BA']);
        Estado::create(['name' => 'Ceará', 'uf' => 'CE']);
        Estado::create(['name' => 'Distrito Federal', 'uf' => 'DF']);
        Estado::create(['name' => 'Espírito Santo', 'uf' => 'ES']);
        Estado::create(['name' => 'Goiás', 'uf' => 'GO']);
        Estado::create(['name' => 'Maranhão', 'uf' => 'MA']);
        Estado::create(['name' => 'Mato Grosso', 'uf' => 'MT']);
        Estado::create(['name' => 'Mato Grosso do Sul', 'uf' => 'MS']);
        Estado::create(['name' => 'Minas Gerais', 'uf' => 'MG']);
        Estado::create(['name' => 'Pará', 'uf' => 'PA']);
        Estado::create(['name' => 'Paraíba', 'uf' => 'PB']);
        Estado::create(['name' => 'Paraná', 'uf' => 'PR']);
        Estado::create(['name' => 'Pernambuco', 'uf' => 'PE']);
        Estado::create(['name' => 'Piauí', 'uf' => 'PI']);
        Estado::create(['name' => 'Rio de Janeiro', 'uf' => 'RJ']);
        Estado::create(['name' => 'Rio Grande do Norte', 'uf' => 'RN']);
        Estado::create(['name' => 'Rio Grande do Sul', 'uf' => 'RS']);
        Estado::create(['name' => 'Rondônia', 'uf' => 'RO']);
        Estado::create(['name' => 'Roraima', 'uf' => 'RR']);
        Estado::create(['name' => 'Santa Catarina', 'uf' => 'SC']);
        Estado::create(['name' => 'São Paulo', 'uf' => 'SP']);
        Estado::create(['name' => 'Sergipe', 'uf' => 'SE']);
        Estado::create(['name' => 'Tocantins', 'uf' => 'TO']);
    }
}
