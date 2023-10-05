<?php

namespace Tests\Feature\User;

use App\Http\Livewire\DeleteUserModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    public function test_load_component(): void
    {
        $this->actingAs($this->createUser('user'));

        $user = $this->createUser('any role');

        Livewire::test(DeleteUserModal::class, ['userId' => $user->id])
            ->assertSuccessful()
            ->assertViewIs('user.delete-user-modal');
    }

    public function test_user_cant_delete_user_if_dont_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user'));

        $userToDelete = $this->createUser('any role');

        Livewire::test(DeleteUserModal::class, ['userId' => $userToDelete->id])
            ->call('deleteUser')
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $userToDelete->id]);
    }

    public function test_user_can_delete_user_if_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','delete user'));

        $userToDelete = $this->createUser('any role');

        Livewire::test(DeleteUserModal::class, ['userId' => $userToDelete->id])
            ->call('deleteUser')
            ->assertRedirect(route('user.index'))
            ->assertDispatchedBrowserEvent('toast:success',['message' => 'User deleted successfully!']);

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
