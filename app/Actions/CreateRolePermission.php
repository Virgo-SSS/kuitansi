<?php

namespace App\Actions;

use Spatie\Permission\Models\Role;

class CreateRolePermission
{
    public function handle(array $data): void
    {
        $role = Role::create(['name' => $data['name']]);
        $role->givePermissionTo($data['permissions']);
    }
}
