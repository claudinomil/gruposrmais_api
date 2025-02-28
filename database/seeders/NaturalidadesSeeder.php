<?php

namespace Database\Seeders;

use App\Models\Naturalidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NaturalidadesSeeder extends Seeder
{
    public function run()
    {
        Naturalidade::create(['name' => 'Acre']);
        Naturalidade::create(['name' => 'Alagoas']);
        Naturalidade::create(['name' => 'Amapá']);
        Naturalidade::create(['name' => 'Amazonas']);
        Naturalidade::create(['name' => 'Bahia']);
        Naturalidade::create(['name' => 'Ceará']);
        Naturalidade::create(['name' => 'Distrito Federal']);
        Naturalidade::create(['name' => 'Espírito Santo']);
        Naturalidade::create(['name' => 'Goiás']);
        Naturalidade::create(['name' => 'Maranhão']);
        Naturalidade::create(['name' => 'Mato Grosso']);
        Naturalidade::create(['name' => 'Mato Grosso do Sul']);
        Naturalidade::create(['name' => 'Minas Gerais']);
        Naturalidade::create(['name' => 'Pará']);
        Naturalidade::create(['name' => 'Paraíba']);
        Naturalidade::create(['name' => 'Paraná']);
        Naturalidade::create(['name' => 'Pernambuco']);
        Naturalidade::create(['name' => 'Piauí']);
        Naturalidade::create(['name' => 'Rio de Janeiro']);
        Naturalidade::create(['name' => 'Rio Grande do Norte']);
        Naturalidade::create(['name' => 'Rio Grande do Sul']);
        Naturalidade::create(['name' => 'Rondônia']);
        Naturalidade::create(['name' => 'Roraima']);
        Naturalidade::create(['name' => 'Santa Catarina']);
        Naturalidade::create(['name' => 'São Paulo']);
        Naturalidade::create(['name' => 'Sergipe']);
        Naturalidade::create(['name' => 'Tocantins']);
    }
}
