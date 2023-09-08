<?php

namespace App\Actions\Project;

use App\Actions\Project\interface\UpdateProjectActionInterface;
use App\Models\Project;

class UpdateProject implements UpdateProjectActionInterface
{
    public function handle(array $data, Project $project): void
    {
        $project->update($data);
    }
}
