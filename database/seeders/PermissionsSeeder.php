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
        $viewAllList = Permission::create(['name' => 'view all lists']);
        $approveList = Permission::create(['name' => 'approve list']);
        $cadOrdemJud = Permission::create(['name' => 'create ordemJud']);
        $giveEditPermissions = Permission::create(['name' => "give edit permissions"]);
        $viewPontuacao = Permission::create(['name' => "view benefPontuacao"]);

        $judicializacao = Permission::create(['name' => "cadastrar judicializacao"]);

        $createUser = Permission::create(['name' => 'create user']);
        $editUser = Permission::create(['name' => 'edit user']);
        $removeUser = Permission::create(['name' => 'remove user']);

        $transferAvailableSpot = Permission::create(['name' => 'transfer available']);

        $viewReports = Permission::create(['name' => "view reports"]);


        $admin = Role::create(['name' => 'Super-Admin']);
        $adminCds = Role::create(['name' => 'Admin-CDS']);
        $adminCds->givePermissionTo($viewBenef, $viewMunicBenef, $createBenef, $cadOrdemJud, $giveEditPermissions, $createUser, $editUser, $removeUser, $viewReports, $viewPontuacao, $judicializacao, $viewAllList, $transferAvailableSpot);


        $municipio = Role::create(['name' => 'municipio']);
        $municipio->givePermissionTo($viewMunicBenef);
        $municipio->givePermissionTo($createBenef);
        $municipio->givePermissionTo($approveList);

        $user = \App\Models\User::factory()->create([
            'name' => 'Daniel',
            'cpf' => "43734045851",
            'email' => 'daniel.mestre@sp.gov.br',
            'email_verified_at' => now(),
            'password' => Hash::make("123456"),
            'municipio' => 565
        ]);
        $user->assignRole($adminCds);

        $user = \App\Models\User::factory()->create([
            'name' => 'Daniel Super',
            'cpf' => "43734045851",
            'email' => 'daniel.super@sp.gov.br',
            'email_verified_at' => now(),
            'password' => Hash::make("123456"),
            'municipio' => 565
        ]);
        $user->assignRole($admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'Municipio',
            'cpf' => "11111111111",
            'email' => 'municipio@sp.gov.br',
            'email_verified_at' => now(),
            'password' => Hash::make("123456"),
            'municipio' => 565
        ]);
        $user->assignRole($municipio);
    }
}
