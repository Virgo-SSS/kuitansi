<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    public function test_guest_cant_delete_user(): void
    {
        $user = $this->createUser('user');
        $response = $this->delete(route('user.destroy', $user));

        $response->assertRedirect(route('login'));
    }

    public function test_user_cant_delete_user_if_dont_have_permission(): void
    {
        $user = $this->createUser('user');
        $userToDelete = $this->createUser('any roles');
        $this->actingAs($user);
        $response = $this->delete(route('user.destroy', $userToDelete));

        $response->assertForbidden();
    }

    public function test_user_can_delete_user_if_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'delete user'));

        $userToDelete = $this->createUser('any roles');

        $response = $this->delete(route('user.destroy', $userToDelete));

        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
