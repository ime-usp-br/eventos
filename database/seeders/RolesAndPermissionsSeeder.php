<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'editar usuario']);

        Role::firstOrCreate(['name' => 'Usuário']);

        Role::firstOrCreate(['name' => 'Moderador']);

        Role::firstOrCreate(['name' => 'Administrador'])
            ->givePermissionTo(Permission::all());

    }
}