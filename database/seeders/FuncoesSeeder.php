<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncoesSeeder extends Seeder
{
    public function run()
    {
        Funcao::create(['id' => 1, 'empresa_id' => 1, 'name' => 'BRIGADISTA']);
        Funcao::create(['id' => 2, 'empresa_id' => 1, 'name' => 'AUXILIAR']);
        Funcao::create(['id' => 3, 'empresa_id' => 1, 'name' => 'GERENTE']);
        Funcao::create(['id' => 4, 'empresa_id' => 1, 'name' => 'SUPERVISOR']);
        Funcao::create(['id' => 5, 'empresa_id' => 1, 'name' => 'TÉCNICO']);
        Funcao::create(['id' => 6, 'empresa_id' => 1, 'name' => 'RECURSO HUMANO']);
        Funcao::create(['id' => 7, 'empresa_id' => 1, 'name' => 'TÉCNICO DE SEGURANÇA']);
        Funcao::create(['id' => 8, 'empresa_id' => 1, 'name' => 'DIRETOR']);
        Funcao::create(['id' => 9, 'empresa_id' => 1, 'name' => 'COMERCIAL']);
    }
}
