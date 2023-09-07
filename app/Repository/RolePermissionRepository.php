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

        return collect($permissions['permissions'])->groupBy(array_search('category', $permissions['alias']))->map(function (Collection $item) use ($permissions) {
            return $item->map(function (array $item) use ($permissions) {
                return $item[array_search('name', $permissions['alias'])];
            });
        });
    }

    public function getRoles(): Collection
    {
       return Role::with('permissions')
        ->where('name', '!=', 'admin')
        ->get();
    }

    public function getRoleById(string $name): Role
    {

    }

    public function getPermissionById(string $name): Permission
    {

    }
}
