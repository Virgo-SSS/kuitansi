<?php

namespace App\Actions\Project;

use App\Actions\Project\interface\DeleteProjectActionInterface;
use App\Models\Project;

class DeleteProject implements DeleteProjectActionInterface
{
    public function handle(Project $project): void
    {
        $project->delete();
    }
}
