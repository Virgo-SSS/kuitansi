<?php

namespace Tests\Feature\Project;

use App\Http\Livewire\DeleteProjectModal;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteProjectTest extends TestCase
{
    public function test_load_component(): void
    {
        $this->actingAs($this->createUser('user'));
        $project = Project::factory()->create();
        Livewire::test(DeleteProjectModal::class, ['projectId' => $project->id])
            ->assertSuccessful()
            ->assertViewIs('project.delete-project-modal');
    }

    public function test_user_cant_delete_project_if_dont_have_permission(): void
    {
        $this->actingAs($this->createUser('user'));
        $project = Project::factory()->create();
        Livewire::test(DeleteProjectModal::class, ['projectId' => $project->id])
            ->call('deleteProject')
            ->assertForbidden();
    }

    public function test_user_can_delete_project_if_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'delete project'));

        $project = Project::factory()->create();
        Livewire::test(DeleteProjectModal::class, ['projectId' => $project->id])
            ->call('deleteProject')
            ->assertRedirect(route('project.index'))
            ->assertDispatchedBrowserEvent('toast:success', ['message' => 'Project deleted successfully']);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
