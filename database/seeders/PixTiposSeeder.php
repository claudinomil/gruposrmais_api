<?php

namespace Database\Seeders;

use App\Models\PixTipo;
use Illuminate\Database\Seeder;

class PixTiposSeeder extends Seeder
{
    public function run()
    {
        //criando
        PixTipo::create(['id' => 1, 'name' => 'Celular']);
        PixTipo::create(['id' => 2, 'name' => 'CPF']);
        PixTipo::create(['id' => 3, 'name' => 'CNPJ']);
        PixTipo::create(['id' => 4, 'name' => 'E-mail']);
        PixTipo::create(['id' => 5, 'name' => 'Chave Aleatória']);
    }
}
