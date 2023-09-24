<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    public function test_guest_cant_view_edit_page_user(): void
    {
        $user = $this->createUser('any roles');
        $this->get(route('user.edit', $user))
            ->assertRedirect(route('login'));
    }

    public function test_user_cant_view_edit_page_if_dont_have_permission(): void
    {
        $user = $this->createUser('any roles');
        $this->actingAs($user)
            ->get(route('user.edit', $user))
            ->assertForbidden();
    }

    public function test_user_can_edit_user_if_have_permission(): void
    {
        $userToEdit = $this->createUser('any roles');

        // view edit page
        $this->actingAs($user = $this->createUser('user', ['edit user']))
            ->get(route('user.edit', $userToEdit))
            ->assertOk();

        $this->put(route('user.update', $userToEdit), [
            'uuid' => $userToEdit->uuid,
            'name' => 'new name',
            'email' => 'newemail@gmail.com',
            'role' => $userToEdit->roles->first()->name,
        ])->assertRedirect(route('user.index'))
            ->assertSessionHas('success', 'User updated successfully.');

        $this->assertDatabaseHas('users', [
            'uuid' => $userToEdit->uuid,
            'name' => 'new name',
            'email' => 'newemail@gmail.com',
        ]);

        $this->assertDatabaseMissing('users', [
            'uuid' => $userToEdit->uuid,
            'name' => $userToEdit->name,
            'email' => $userToEdit->email,
        ]);
    }

    /**
     * @dataProvider editUserValidationProvider
     */
    public function test_edit_user_validation(string $field, string|int $value, string $error, string $error_message): void
    {
        // view create user page
        $this->actingAs($user = $this->createUser('user', ['edit user']));

        $fakeUser = User::factory()->create();
        $userToEdit = $this->createUser('any roles');

        if($field === 'uuid' && $error === 'unique') {
            $value = $fakeUser->uuid;
        }

        if($field === 'email' && $error === 'unique') {
            $value = $fakeUser->email;
        }

        $this->put(route('user.update', $userToEdit), [
            $field => $value,
        ])->assertSessionHasErrors($field, $error_message);
    }

    public static function editUserValidationProvider(): array
    {
        return [
            'uuid is required' => ['uuid', '', 'required', 'The uuid field is required.'],
            'uuid is string' => ['uuid', 1, 'string', 'The uuid must be a string.'],
            'uuid is max 255 characters' => ['uuid', str_repeat('a', 256), 'max.string', 'The uuid must not be greater than 255 characters.'],
            'uuid is unique' => ['uuid', '000', 'unique', 'The uuid has already been taken.'],
            'name is required' => ['name', '', 'required', 'The name field is required.'],
            'name is string' => ['name', 1, 'string', 'The name must be a string.'],
            'name is max 255 characters' => ['name', str_repeat('a', 256), 'max.string', 'The name must not be greater than 255 characters.'],
            'email is required' => ['email', '', 'required', 'The email field is required.'],
            'email is string' => ['email', 1, 'string', 'The email must be a string.'],
            'email is email' => ['email', 'invalid email', 'email', 'The email must be a valid email address.'],
            'email is max 255 characters' => ['email', str_repeat('a', 256), 'max.string', 'The email must not be greater than 255 characters.'],
            'email is unique' => ['email', '000', 'unique', 'The email has already been taken.'],
            'password is string' => ['password', 1, 'string', 'The password must be a string.'],
            'password is min 8 characters' => ['password', '1234567', 'min.string', 'The password must be at least 8 characters.'],
            'password is confirmed' => ['password', 'password', 'confirmed', 'The password confirmation does not match.'],
            'role is required' => ['role', '', 'required', 'The role field is required.'],
            'role is exists' => ['role', 'invalid role', 'exists', 'The selected role is invalid.'],
        ];
    }
}
