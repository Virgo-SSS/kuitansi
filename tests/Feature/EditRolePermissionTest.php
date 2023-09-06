<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditRolePermissionTest extends TestCase
{
    public function test_guest_cannot_view_edit_role_permission_page(): void
    {
        $role = Role::create(['name' => 'test']);
        $this->get(route('role.edit', $role->id))->assertRedirect(route('login'));
    }

    public function test_role_admin_can_view_edit_role_permission_page(): void
    {
        $this->actingAs($user = $this->createAdmin());

        $role = Role::create(['name' => 'test']);
        $this->get(route('role.edit', $role->id))->assertOk();
    }

    public function test_role_without_permission_cannot_view_edit_role_permission_page(): void
    {
        $this->actingAs($user = $this->createUser('user'));
        $role = Role::create(['name' => 'test']);
        $this->get(route('role.edit', $role->id))->assertForbidden();
    }

    public function test_guest_cannot_update_role_permission(): void
    {
        $role = Role::create(['name' => 'test']);
        $this->put(route('role.update', $role->id))->assertRedirect(route('login'));
    }

    public function test_role_admin_can_update_role_permission(): void
    {
        $this->actingAs($user = $this->createAdmin());

        $role = Role::create(['name' => 'test']);
        $permission = Permission::create(['name' => 'view role page']);
        $role->givePermissionTo($permission->name);

        $this->put(route('role.update', $role->id), [
            'name' => 'test 123',
            'permissions' => [$permission->name],
        ])->assertRedirect(route('role.index'))
            ->assertSessionHas('success', 'Role updated successfully');

        $this->assertDatabaseHas('roles', [
            'name' => 'test 123',
        ]);
        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
    }

    public function test_role_with_permission_can_edit_role_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'edit role'));

        $role = Role::create(['name' => 'test']);
        $permission = Permission::create(['name' => 'view role page']);
        $role->givePermissionTo($permission->name);

        $this->put(route('role.update', $role->id), [
            'name' => 'test 123',
            'permissions' => [$permission->name],
        ])
            ->assertRedirect(route('role.index'))
            ->assertSessionHas('success', 'Role updated successfully');

        $this->assertDatabaseHas('roles', [
            'name' => 'test 123',
        ]);
        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);

    }

    /**
     * @dataProvider CreateRoleValidation
     */
    public function test_create_role_validation(string $field, mixed $value, string $error_message, ?string $session_error_field = null): void
    {
        $this->actingAs($user = $this->createAdmin());

        $role = Role::create(['name' => 'test']);
        $this->put(route('role.update', $role->id), [
            $field => $value,
        ])->assertSessionHasErrors($session_error_field ?? $field, $error_message);
    }

    public static function CreateRoleValidation(): array
    {
        return [
            'name is required' => ['name', '', 'The role name field is required.'],
            'name is unique' => ['name', 'admin', 'The role name field is required.'],
            'permissions is required' => ['permissions', '', 'The permissions field is required.'],
            'permissions is array' => ['permissions', 'test', 'The permissions must be an array.'],
            'permissions.* is required' => ['permissions', [ 0 => null ], 'The permissions.0 field is required.', 'permissions.0'],
            'permissions.* is string' => ['permissions', [ 0 => 234 ], 'The permissions.0 field must be a string.', 'permissions.0'],
            'permissions.* is exists' => ['permissions', [0 => 'invalid permission' ], 'The selected permissions.0 is invalid.', 'permissions.0'],
        ];
    }
}
