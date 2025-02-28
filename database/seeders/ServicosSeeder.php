<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicosSeeder extends Seeder
{
    public function run()
    {
        Servico::create(['id' => 1, 'empresa_id' => 1, 'name' => 'RECARGA DE EXTINTOR DE INCÊNDIO DO TIPO CO2 - 6KG', 'servico_tipo_id' => '2', 'valor' => '0.00']);
        Servico::create(['id' => 2, 'empresa_id' => 1, 'name' => 'RECARGA DE EXTINTOR DE INCÊNDIO DO TIPO PQS BC - 6KG', 'servico_tipo_id' => '2', 'valor' => '0.00']);
        Servico::create(['id' => 3, 'empresa_id' => 1, 'name' => 'RECARGA DE EXTINTOR DE INCÊNDIO DO TIPO AP - 10L', 'servico_tipo_id' => '2', 'valor' => '0.00']);
        Servico::create(['id' => 4, 'empresa_id' => 1, 'name' => 'RETESTE DE MANGUEIRAS DE INCÊNDIO DO TIPO 2, DE 2 ½”', 'servico_tipo_id' => '2', 'valor' => '0.00']);
        Servico::create(['id' => 5, 'empresa_id' => 1, 'name' => 'BRIGADA DE INCÊNDIO', 'servico_tipo_id' => '1', 'valor' => '0.00']);
        Servico::create(['id' => 6, 'empresa_id' => 1, 'name' => 'VISITA TÉCNICA', 'servico_tipo_id' => '3', 'valor' => '0.00']);
    }
}
