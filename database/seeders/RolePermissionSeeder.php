<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view role page',
            'create role',
            'edit role',
            'delete role',
            'create receipt',
            'edit receipt',
            'delete receipt',
            'view user page',
            'create user',
            'edit user',
            'delete user',
        ];

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // this can be done as separate statements
        Role::create(['name' => 'admin']);

        // or may be done by chaining
        Role::create(['name' => 'user'])->givePermissionTo(['create receipt']);
    }
}
