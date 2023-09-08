<?php

namespace App\Providers;

use App\Actions\Project\CreateProject;
use App\Actions\Project\DeleteProject;
use App\Actions\Project\UpdateProject;
use App\Actions\Project\interface\CreateProjectActionInterface;
use App\Actions\Project\interface\DeleteProjectActionInterface;
use App\Actions\Project\interface\UpdateProjectActionInterface;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CreateProjectActionInterface::class, CreateProject::class);
        $this->app->bind(UpdateProjectActionInterface::class, UpdateProject::class);
        $this->app->bind(DeleteProjectActionInterface::class, DeleteProject::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
