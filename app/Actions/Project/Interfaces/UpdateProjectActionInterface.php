<?php

namespace  App\Actions\Project\Interfaces;

use App\Models\Project;

interface UpdateProjectActionInterface
{
    public function handle(array $data, Project $project): void;
}
