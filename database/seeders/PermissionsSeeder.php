<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $viewBenef = Permission::create(['name' => 'view beneficiarias']);
        $viewMunicBenef = Permission::create(['name' => 'view municBeneficiarias']);
        $createBenef = Permission::create(['name' => 'create beneficiarias']);
        $approveBenef = Permission::create(['name' => 'approve beneficiarias']);
        $cadOrdemJud = Permission::create(['name' => 'create ordemJud']);

        $createUser = Permission::create(['name' => 'create user']);
        $editUser = Permission::create(['name' => 'edit user']);
        $removeUser = Permission::create(['name' => 'remove user']);

        $viewReports = Permission::create(['name' => "view reports"]);

        $admin = Role::create(['name' => 'Super-Admin']);

        $secretariaMulher = Role::create(['name' => 'secretaria-mulher']);
        $secretariaMulher->givePermissionTo($approveBenef);
        $secretariaMulher->givePermissionTo($cadOrdemJud);
        $secretariaMulher->givePermissionTo($viewBenef);
        $secretariaMulher->givePermissionTo($createBenef);

        $municipio = Role::create(['name' => 'municipio']);
        $municipio->givePermissionTo($viewMunicBenef);
        $municipio->givePermissionTo($createBenef);

        $user = \App\Models\User::factory()->create([
            'name' => 'Daniel',
            'email' => 'daniel.mestre@sp.gov.br',
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'municipio' => 565
        ]);
        $user->assignRole($admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'Secretaria Mulher',
            'email' => 'secretaria.mulher@sp.gov.br',
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'municipio' => 565
        ]);
        $user->assignRole($secretariaMulher);

        $user = \App\Models\User::factory()->create([
            'name' => 'Municipio',
            'email' => 'municipio@sp.gov.br',
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'municipio' => 565
        ]);
        $user->assignRole($municipio);
    }
}
