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
        Permission::firstOrCreate(['name' => 'visualizar evento']);
        Permission::firstOrCreate(['name' => 'criar evento']);
        Permission::firstOrCreate(['name' => 'editar evento']);
        Permission::firstOrCreate(['name' => 'deletar evento']);

        Role::firstOrCreate(['name' => 'Usuário']);

        Role::firstOrCreate(['name' => 'Moderador']);

        Role::firstOrCreate(['name' => 'Administrador'])
            ->givePermissionTo(Permission::all());

    }
}