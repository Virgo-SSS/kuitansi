<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role' => [
                'view role page',
                'create role',
                'edit role',
                'delete role',
            ],
            'receipt' => [
                'view receipt page',
                'create receipt',
                'edit receipt',
                'delete receipt',
            ],
            'user' => [
                'view user page',
                'create user',
                'edit user',
                'delete user',
            ],
            'project' => [
                'view project page',
                'create project',
                'edit project',
                'delete project',
            ],
        ];

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        foreach ($permissions as $key => $permission) {
            foreach ($permission as $value) {
                Permission::updateOrCreate(
                    ['name' => $value],
                    ['category' => $key]
                );
            }
        }

        // this can be done as separate statements
        Role::create(['name' => 'admin']);

        // or may be done by chaining
        Role::create(['name' => 'user'])->givePermissionTo(['create receipt']);
    }
}
