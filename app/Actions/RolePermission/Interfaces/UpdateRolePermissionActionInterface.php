<?php

namespace App\Actions\RolePermission\Interfaces;

use Spatie\Permission\Models\Role;

interface UpdateRolePermissionActionInterface
{
    public function handle(array $data, Role $role): void;
}
