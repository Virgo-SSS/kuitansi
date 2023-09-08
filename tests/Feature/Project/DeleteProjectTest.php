<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProjectTest extends TestCase
{
    public function test_guest_cant_delete_project(): void
    {
        $project = Project::create([
            'name' => 'Test Project',
            'block' => 1,
            'number' => 1,
            'type' => 'Test Type',
        ]);

        $this->delete(route('project.destroy', $project))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_delete_project_if_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'delete project'));

        $project = Project::create([
            'name' => 'Test Project',
            'block' => 1,
            'number' => 1,
            'type' => 'Test Type',
        ]);

        $this->delete(route('project.destroy', $project))
            ->assertRedirect(route('project.index'))
            ->assertSessionHas('success', 'Project deleted successfully');

        $this->assertDatabaseMissing('projects', [
            'name' => 'Test Project',
            'block' => 1,
            'number' => 1,
            'type' => 'Test Type',
        ]);
    }
}
