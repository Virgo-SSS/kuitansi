<?php

namespace App\Actions\Project\interface;

use App\Models\Project;

interface DeleteProjectActionInterface
{
    public function handle(Project $project): void;
}
