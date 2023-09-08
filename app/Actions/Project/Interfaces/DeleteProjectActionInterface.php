<?php

namespace App\Actions\Project\Interfaces;

use App\Models\Project;

interface DeleteProjectActionInterface
{
    public function handle(Project $project): void;
}
