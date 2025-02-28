<?php

namespace Database\Seeders;

use App\Models\ServicoStatus;
use Illuminate\Database\Seeder;

class ServicoStatusSeeder extends Seeder
{
    public function run()
    {
        ServicoStatus::create(['id' => 1, 'name' => 'Executado']);
        ServicoStatus::create(['id' => 2, 'name' => 'Aguardando']);
        ServicoStatus::create(['id' => 3, 'name' => 'Andamento']);
    }
}
