<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectPageTest extends TestCase
{
    public function test_guest_cannot_view_project_page(): void
    {
        $response = $this->get(route('project.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_project_page(): void
    {
        $this->actingAs($user = $this->createAdmin());

        $response = $this->get(route('project.index'));

        $response->assertSuccessful();
        $response->assertViewIs('project.index');
    }

    public function test_user_cannot_view_project_page_if_dont_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','test'));

        $response = $this->get(route('project.index'));

        $response->assertForbidden();
    }

    public function test_user_can_view_project_page_if_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','view project page'));

        $response = $this->get(route('project.index'));

        $response->assertSuccessful();
        $response->assertViewIs('project.index');
    }
}
