<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $user = \App\Models\User::factory()->create([
            'id' => 1,
            'name' => 'CLAUDINO MIL HOMENS DE MORAES',
            'email' => 'claudinomoraes@yahoo.com.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'created_at' => now()
        ]);

        $user2 = \App\Models\User::factory()->create([
            'id' => 2,
            'name' => 'MARCUS VINICIUS MACHADO DE OLIVEIRA',
            'email' => 'mvmdeoliveira@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'created_at' => now()
        ]);
    }
}
