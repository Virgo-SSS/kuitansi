<?php

namespace App\Actions\RolePermission;

use App\Actions\RolePermission\Interfaces\CreateRolePermissionActionInterface;
use Spatie\Permission\Models\Role;

class CreateRolePermission implements CreateRolePermissionActionInterface
{
    public function handle(array $data): void
    {
        $role = Role::create(['name' => $data['name']]);
        $role->givePermissionTo($data['permissions']);
    }
}
