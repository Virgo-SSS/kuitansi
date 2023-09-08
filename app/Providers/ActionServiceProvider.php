<?php

namespace App\Providers;

use App\Actions\Project\CreateProject;
use App\Actions\Project\DeleteProject;
use App\Actions\Project\UpdateProject;
use App\Actions\Project\Interfaces\CreateProjectActionInterface;
use App\Actions\Project\Interfaces\DeleteProjectActionInterface;
use App\Actions\Project\Interfaces\UpdateProjectActionInterface;
use App\Actions\RolePermission\CreateRolePermission;
use App\Actions\RolePermission\Interfaces\CreateRolePermissionActionInterface;
use App\Actions\RolePermission\Interfaces\UpdateRolePermissionActionInterface;
use App\Actions\RolePermission\UpdateRolePermission;
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
        $this->app->bind(CreateRolePermissionActionInterface::class, CreateRolePermission::class);
        $this->app->bind(UpdateRolePermissionActionInterface::class, UpdateRolePermission::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
