<?php

namespace App\Providers;

use App\Actions\Bank\CreateBank;
use App\Actions\Bank\DeleteBank;
use App\Actions\Bank\EditBank;
use App\Actions\Bank\Interfaces\DeleteBankActionInterface;
use App\Actions\Project\CreateProject;
use App\Actions\Project\DeleteProject;
use App\Actions\Project\UpdateProject;
use App\Actions\Receipt\CreateAcceptanceReceipt;
use App\Actions\Receipt\CreatePaymentReceipt;
use App\Actions\Receipt\EditAcceptanceReceipt;
use App\Actions\Receipt\EditPaymentReceipt;
use App\Actions\Receipt\Interfaces\CreateAcceptanceReceiptActionInterface;
use App\Actions\Receipt\Interfaces\CreatePaymentReceiptActionInterface;
use App\Actions\Receipt\Interfaces\EditAcceptanceReceiptActionInterface;
use App\Actions\Receipt\Interfaces\EditPaymentReceiptActionInterface;
use App\Actions\RolePermission\CreateRolePermission;
use App\Actions\RolePermission\UpdateRolePermission;
use App\Actions\Bank\Interfaces\EditBankActionInterface;
use App\Actions\Bank\Interfaces\CreateBankActionInterface;
use App\Actions\Project\Interfaces\CreateProjectActionInterface;
use App\Actions\Project\Interfaces\DeleteProjectActionInterface;
use App\Actions\Project\Interfaces\UpdateProjectActionInterface;
use App\Actions\RolePermission\Interfaces\CreateRolePermissionActionInterface;
use App\Actions\RolePermission\Interfaces\UpdateRolePermissionActionInterface;
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

        $this->app->bind(CreateBankActionInterface::class, CreateBank::class);
        $this->app->bind(EditBankActionInterface::class, EditBank::class);
        $this->app->bind(DeleteBankActionInterface::class, DeleteBank::class);

        $this->app->bind(CreatePaymentReceiptActionInterface::class, CreatePaymentReceipt::class);
        $this->app->bind(CreateAcceptanceReceiptActionInterface::class, CreateAcceptanceReceipt::class);

        $this->app->bind(EditAcceptanceReceiptActionInterface::class, EditAcceptanceReceipt::class);
        $this->app->bind(EditPaymentReceiptActionInterface::class, EditPaymentReceipt::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
