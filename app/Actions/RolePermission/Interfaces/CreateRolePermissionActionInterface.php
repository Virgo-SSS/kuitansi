<?php

namespace App\Actions\RolePermission\Interfaces;

interface CreateRolePermissionActionInterface
{
    public function handle(array $data): void;
}
