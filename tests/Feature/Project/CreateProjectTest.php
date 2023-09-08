<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    public function test_guest_cannot_create_project(): void
    {
        $this->get(route('project.create'))->assertRedirect(route('login'));
        $this->post(route('project.store'))->assertRedirect(route('login'));
    }

    public function test_user_can_create_project_if_has_permission(): void
    {
        // login user
        $this->actingAs($user = $this->createUser('user', 'create project'));

        // view create project page
        $this->get(route('project.create'))
            ->assertStatus(200)
            ->assertSee('Create Project');

        // create project
        $this->post(route('project.store'), [
                'name' => 'Test Project',
                'block' => 1,
                'number' => 1,
                'type' => '30/40',
        ])
        ->assertRedirect(route('project.index'))
        ->assertSessionHas('success', 'Project created successfully');

        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            'block' => 1,
            'number' => 1,
            'type' => '30/40',
        ]);
    }

    /**
     * @dataProvider createProjectRequest
     */
    public function test_create_project_validation_request(string $field, string|int $value, string $error, string $error_message): void
    {
        $this->actingAs($user = $this->createUser('user', 'create project'));

        $this->post(route('project.store'), [
            $field => $value
        ])->assertSessionHasErrors($error, $error_message);
    }

    public static function createProjectRequest(): array
    {
        return [
            'name_is_required' => ['name', '', 'name', 'The name field is required.'],
            'name_is_string' => ['name', 1, 'name', 'The name must be a string.'],
            'name_is_max_255' => ['name', str_repeat('a', 256), 'name', 'The name field must not be greater than 255 characters.'],
            'block_is_required' => ['block', '', 'block', 'The block field is required.'],
            'block_is_integer' => ['block', 'a', 'block', 'The block must be an integer.'],
            'number_is_required' => ['number', '', 'number', 'The number field is required.'],
            'number_is_integer' => ['number', 'a', 'number', 'The number must be an integer.'],
            'type_is_required' => ['type', '', 'type', 'The type field is required.'],
            'type_is_string' => ['type', 1, 'type', 'The type must be a string.'],
            'type_is_max_255' => ['type', str_repeat('a', 256), 'type', 'The type may not be greater than 255 characters.'],
        ];
    }
}
