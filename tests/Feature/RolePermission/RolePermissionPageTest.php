<?php

namespace Tests\Feature\RolePermission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolePermissionPageTest extends TestCase
{
    public function test_guest_cant_view_role_permission_page(): void
    {
        $this->get(route('role.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_view_role_permission_page(): void
    {
        $this->actingAs($user = $this->createAdmin());
        $this->get(route('role.index'))
            ->assertOk()
            ->assertViewIs('role-permission.index')
            ->assertViewHas('roles');
    }

    public function test_role_without_permission_cant_view_role_permission_page(): void
    {
        $this->actingAs($user = $this->createUser('user'));
        $this->get(route('role.index'))
            ->assertForbidden();
    }

    public function test_role_with_permission_can_view_role_permission_page(): void
    {
        $this->actingAs($user = $this->createUser('user', 'view role page'));
        $this->get(route('role.index'))
            ->assertOk()
            ->assertViewIs('role-permission.index')
            ->assertViewHas('roles');
    }
}
