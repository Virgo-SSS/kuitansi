<?php

namespace Tests\Feature\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function test_guest_cannot_create_user(): void
    {
        $this->get(route('user.create'))
            ->assertRedirect(route('login'));
    }

    public function test_user_cannot_view_create_user_page_if_does_not_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user'))
            ->get(route('user.create'))
            ->assertForbidden();
    }

    public function test_user_can_create_user_if_have_permission(): void
    {
        // view create user page
        $this->actingAs($user = $this->createUser('user', ['create user']))
            ->get(route('user.create'))
            ->assertOk()
            ->assertViewIs('user.create');

        $request = User::factory()->make()->toArray();

        $request['password'] = 'password';
        $request['password_confirmation'] = 'password';
        $request['role'] = Role::create(['name' => 'any role'])->name;

        $this->post(route('user.store'), $request)
            ->assertRedirect(route('user.index'))
            ->assertSessionHas('success', 'User created successfully.');

        $this->assertDatabaseHas('users', [
            'uuid' => $request['uuid'],
            'name' => $request['name'],
            'email' => $request['email'],
        ]);
    }

    /**
     *  @dataProvider createUserRequest
     */
    public function test_create_user_validation(string $field, string|int $value, string $error, string $error_message): void
    {
        // view create user page
        $this->actingAs($user = $this->createUser('user', ['create user']));
        $user = User::factory()->create();

        if($field === 'uuid' && $error === 'unique') {
            $value = $user->uuid;
        }

        if($field === 'email' && $error === 'unique') {
            $value = $user->email;
        }

        $this->post(route('user.store'), [
            $field => $value,
        ])->assertSessionHasErrors($field, $error_message);
    }

    public static function createUserRequest(): array
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
            'password is required' => ['password', '', 'required', 'The password field is required.'],
            'password is string' => ['password', 1, 'string', 'The password must be a string.'],
            'password is min 8 characters' => ['password', '1234567', 'min.string', 'The password must be at least 8 characters.'],
            'password is confirmed' => ['password', 'password', 'confirmed', 'The password confirmation does not match.'],
            'role is required' => ['role', '', 'required', 'The role field is required.'],
            'role is exists' => ['role', 'invalid role', 'exists', 'The selected role is invalid.'],
        ];
    }

}
