<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncoesSeeder extends Seeder
{
    public function run()
    {
        Funcao::create(['id' => 1, 'name' => 'BRIGADISTA']);
        Funcao::create(['id' => 2, 'name' => 'AUXILIAR']);
        Funcao::create(['id' => 3, 'name' => 'GERENTE']);
        Funcao::create(['id' => 4, 'name' => 'SUPERVISOR']);
        Funcao::create(['id' => 5, 'name' => 'TÉCNICO']);
        Funcao::create(['id' => 6, 'name' => 'RECURSO HUMANO']);
        Funcao::create(['id' => 7, 'name' => 'TÉCNICO DE SEGURANÇA']);
        Funcao::create(['id' => 8, 'name' => 'DIRETOR']);
        Funcao::create(['id' => 9, 'name' => 'COMERCIAL']);
    }
}
