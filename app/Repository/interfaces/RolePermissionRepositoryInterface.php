<?php

namespace App\Repository\interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface RolePermissionRepositoryInterface
{
    public function getPermissions(): Collection;

    public function getRoles(): Collection;

    public function getRoleById(string $name): Role;

    public function getPermissionById(string $name): Permission;
}
