<?php

namespace App\Actions\RolePermission;

use App\Actions\RolePermission\Interfaces\UpdateRolePermissionActionInterface;
use Spatie\Permission\Models\Role;

class UpdateRolePermission implements UpdateRolePermissionActionInterface
{
    public function handle(array $data, Role $role): void
    {
        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions']);
    }
}
