<?php

namespace App\Repository;

use App\Repository\interfaces\RolePermissionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionRepository implements RolePermissionRepositoryInterface
{
    public function getPermissions(): Collection
    {
        $permissions = Cache::get(config('permission.cache.key'));
        if($permissions) {
            return collect($permissions['permissions'])->pluck(array_search('name', $permissions['alias']));
        }

        return Permission::pluck('name');
    }

    public function getRoles(): Collection
    {

    }

    public function getRoleById(string $name): Role
    {

    }

    public function getPermissionById(string $name): Permission
    {

    }
}
