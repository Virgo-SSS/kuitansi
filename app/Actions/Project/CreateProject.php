<?php

namespace App\Actions\Project;

use App\Actions\Project\interface\CreateProjectActionInterface;
use App\Models\Project;

class CreateProject implements CreateProjectActionInterface
{
    public function handle(array $data): void
    {
        Project::create([
            'name' => $data['name'],
            'number' => $data['number'],
            'block' => $data['block'],
            'type' => $data['type'],
        ]);
    }
}
