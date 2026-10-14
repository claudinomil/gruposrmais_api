<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Edificacao;
use App\Models\EdificacaoNivel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Z_Faker5Seeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // // Usuário para testes no Grupo Cliente Domínio'''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // User::create([
        //     'name' => 'CLAUDINO TESTE 1',
        //     'email' => 'claudinoteste1@gmail.com',
        //     'situacao_id' => 1,
        //     'grupo_id' => 1,
        //     'password' => Hash::make('12345678'),
        //     'email_verified_at' => now(),
        //     'user_confirmed_at' => now(),
        //     'layout_mode' => 'layout_mode_light',
        //     'layout_style' => 'layout_style_vertical_scrollable',
        //     'avatar' => 'build/assets/images/users/avatar-0.png',
        //     'created_at' => now()
        // ]);

        // User::create([
        //     'name' => 'CLAUDINO TESTE 2',
        //     'email' => 'claudinoteste2@gmail.com',
        //     'situacao_id' => 1,
        //     'grupo_id' => 11,
        //     'cliente_id' => 1,
        //     'password' => Hash::make('12345678'),
        //     'email_verified_at' => now(),
        //     'user_confirmed_at' => now(),
        //     'layout_mode' => 'layout_mode_light',
        //     'layout_style' => 'layout_style_vertical_scrollable',
        //     'avatar' => 'build/assets/images/users/avatar-0.png',
        //     'created_at' => now()
        // ]);
        // //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
