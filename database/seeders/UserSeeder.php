<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Daniel',
            'email' => 'daniel.mestre@sp.gov.br',
            'cpf' => '43734045851',
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'municipio' => 565
        ]);
        $user->assignRole("Super-Admin");

        $user = \App\Models\User::factory()->create([
            'name' => 'Secretaria Mulher',
            'email' => 'secretaria.mulher@sp.gov.br',
            'cpf' => '11111111111',
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'municipio' => 565
        ]);
        $user->assignRole("secretaria-mulher");

        $user = \App\Models\User::factory()->create([
            'name' => 'Municipio',
            'email' => 'municipio@sp.gov.br',
            'cpf' => '22222222222',
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'municipio' => 565
        ]);
        $user->assignRole("municipio");
    }
}
