<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\RoleFactory;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreateRolePermissionTest extends TestCase
{
    public function test_guest_cannot_view_create_role_permission_page(): void
    {
        $this->get(route('role.create'))->assertRedirect(route('login'));
    }

    public function test_role_admin_can_view_create_role_permission_page(): void
    {
        $this->actingAs($user = $this->createAdmin());
        $this->get(route('role.create'))->assertOk();
    }

    public function test_role_without_permission_cannot_view_create_role_permission_page(): void
    {
        $this->actingAs($user = $this->createUser('user'));
        $this->get(route('role.create'))->assertForbidden();
    }

    public function test_guest_cannot_create_role_permission(): void
    {
        $this->post(route('role.store'))->assertRedirect(route('login'));
    }

    public function test_role_admin_can_create_role_permission(): void
    {
        $this->actingAs($user = $this->createAdmin());

        $permission = Permission::create(['name' => 'view role page']);
        $this->post(route('role.store'), [
            'name' => 'test',
            'permissions' => [$permission->name],
        ])
            ->assertRedirect(route('role.index'))
            ->assertSessionHas('success', 'Role created successfully');
    }

    public function test_role_with_permission_can_create_role_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'create role'));

        $permission = Permission::create(['name' => 'view role page']);
        $this->post(route('role.store'), [
            'name' => 'test',
            'permissions' => [$permission->name],
        ])
            ->assertRedirect(route('role.index'))
            ->assertSessionHas('success', 'Role created successfully');
    }

    /**
     * @dataProvider CreateRoleValidation
     */
    public function test_create_role_validation(string $field, mixed $value, string $error_message, ?string $session_error_field = null): void
    {
        $this->actingAs($user = $this->createAdmin());

        $this->post(route('role.store'), [
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
