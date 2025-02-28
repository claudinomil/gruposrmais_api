<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    public function run()
    {
        Departamento::create(['id' => 1, 'empresa_id' => 1, 'name' => 'ADMINISTRATIVO']);
        Departamento::create(['id' => 2, 'empresa_id' => 1, 'name' => 'COMERCIAL']);
        Departamento::create(['id' => 3, 'empresa_id' => 1, 'name' => 'OPERACIONAL']);
        Departamento::create(['id' => 4, 'empresa_id' => 1, 'name' => 'MANUTENÇÃO']);
        Departamento::create(['id' => 5, 'empresa_id' => 1, 'name' => 'DA EMPRESA']);
    }
}
