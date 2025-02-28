<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancosSeeder extends Seeder
{
    public function run()
    {
        Banco::create(['numero' => '001', 'name' => 'Banco do Brasil S.A.']);
        Banco::create(['numero' => '033', 'name' => 'Banco Santander (Brasil) S.A.']);
        Banco::create(['numero' => '104', 'name' => 'Caixa Econômica Federal']);
        Banco::create(['numero' => '237', 'name' => 'Banco Bradesco S.A.']);
        Banco::create(['numero' => '341', 'name' => 'Banco Itaú S.A.']);
        Banco::create(['numero' => '356', 'name' => 'Banco Real S.A. (antigo)']);
        Banco::create(['numero' => '389', 'name' => 'Banco Mercantil do Brasil S.A.']);
        Banco::create(['numero' => '399', 'name' => 'HSBC Bank Brasil S.A. – Banco Múltiplo']);
        Banco::create(['numero' => '422', 'name' => 'Banco Safra S.A.']);
        Banco::create(['numero' => '453', 'name' => 'Banco Rural S.A.']);
        Banco::create(['numero' => '633', 'name' => 'Banco Rendimento S.A.']);
        Banco::create(['numero' => '652', 'name' => 'Itaú Unibanco Holding S.A.']);
        Banco::create(['numero' => '745', 'name' => 'Banco Citibank S.A.']);
        Banco::create(['numero' => '318', 'name' => 'Banco BMG S.A.']);
    }
}
