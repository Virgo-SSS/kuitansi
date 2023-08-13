<?php

namespace App\Providers;

use App\Repository\interfaces\RolePermissionRepositoryInterface;
use App\Repository\RolePermissionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RolePermissionRepositoryInterface::class, RolePermissionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
