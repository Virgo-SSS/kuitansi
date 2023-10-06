<?php

namespace App\Providers;

use App\Repository\AcceptanceReceiptRepository;
use App\Repository\BankRepository;
use App\Repository\interfaces\AcceptanceReceiptRepositoryInterface;
use App\Repository\interfaces\BankRepositoryInterface;
use App\Repository\interfaces\PaymentReceiptRepositoryInterface;
use App\Repository\interfaces\ProjectRepositoryInterface;
use App\Repository\interfaces\RolePermissionRepositoryInterface;
use App\Repository\PaymentReceiptRepository;
use App\Repository\ProjectRepository;
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
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(AcceptanceReceiptRepositoryInterface::class, AcceptanceReceiptRepository::class);
        $this->app->bind(PaymentReceiptRepositoryInterface::class, PaymentReceiptRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
