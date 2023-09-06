<?php

namespace App\Actions;

use Spatie\Permission\Models\Role;

class UpdateRolePermission
{
    public function handle(array $data, Role $role): void
    {
        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions']);
    }
}
