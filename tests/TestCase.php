<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function createUser(string $role, mixed $permission = null): User
    {
        $role = Role::create(['name' => $role]);

        if($permission) {
            if(is_array($permission)) {
                foreach($permission as $p) {
                    $permission = Permission::create(['name' => $p]);
                    $role->givePermissionTo($permission->name);
                }
            }

            if(is_string($permission)) {
                $permission = Permission::create(['name' => $permission]);
                $role->givePermissionTo($permission->name);
            }
        }

        $user = User::factory()->create();
        $user->assignRole($role->name);

        return $user;
    }

    public function createAdmin(): User
    {
        return $this->createUser('admin');
    }
}
