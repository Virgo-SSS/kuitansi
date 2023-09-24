<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserPageTest extends TestCase
{
    public function test_guest_cant_view_user_page(): void
    {
        $this->get(route('user.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_cant_view_users_page_if_doesnt_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user'));

        $this->get(route('user.index'))
            ->assertForbidden();
    }

    public function test_user_can_view_users_page_if_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'view user page'));

        $this->get(route('user.index'))
            ->assertOk()
            ->assertViewIs('user.index');
    }
}
