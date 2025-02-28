<?php

namespace Database\Seeders;

use App\Models\Nacionalidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NacionalidadesSeeder extends Seeder
{
    public function run()
    {
        //Somente paises da america sul
        Nacionalidade::create(['nation' => 'Argentina', 'name' => 'Argentina']);
        Nacionalidade::create(['nation' => 'Bolívia', 'name' => 'Boliviana']);
        Nacionalidade::create(['nation' => 'Brasil', 'name' => 'Brasileira']);
        Nacionalidade::create(['nation' => 'Chile', 'name' => 'Chilena']);
        Nacionalidade::create(['nation' => 'Colômbia', 'name' => 'Colombiana']);
        Nacionalidade::create(['nation' => 'Cuba', 'name' => 'Cubana']);
        Nacionalidade::create(['nation' => 'Equador', 'name' => 'Equatoriana']);
        Nacionalidade::create(['nation' => 'Paraguai', 'name' => 'Paraguaia']);
        Nacionalidade::create(['nation' => 'Peru', 'name' => 'Peruana']);
        Nacionalidade::create(['nation' => 'Uruguai', 'name' => 'Uruguaia']);
        Nacionalidade::create(['nation' => 'Venezuela', 'name' => 'Venezuelana']);
    }
}
