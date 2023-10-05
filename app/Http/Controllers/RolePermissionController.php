<?php

namespace App\Http\Controllers;

use App\Actions\RolePermission\Interfaces\CreateRolePermissionActionInterface;
use App\Actions\RolePermission\Interfaces\UpdateRolePermissionActionInterface;
use App\Http\Requests\RolePermission\CreateRolePermissionRequest;
use App\Http\Requests\RolePermission\EditRolePermissionRequest;
use App\Repository\interfaces\RolePermissionRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function __construct(
        private readonly RolePermissionRepositoryInterface $repository
    ){}

    public function index(): View
    {
        $this->authorize('view role page');

        $roles = $this->repository->getRoles();
        $permissions = $this->repository->getPermissions();
        return view('role-permission.index', compact('roles', 'permissions'));
    }

    public function create(): View
    {
        $this->authorize('create role');

        $permissions = $this->repository->getPermissions();
        return view('role-permission.create', compact('permissions'));
    }

    public function store(CreateRolePermissionRequest $request, CreateRolePermissionActionInterface $action): RedirectResponse
    {
        $this->authorize('create role');

        $action->handle($request->validated());

        return redirect()->route('role.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role): View
    {
        $this->authorize('edit role');

        $permissions = $this->repository->getPermissions();

        return view('role-permission.edit', compact('role', 'permissions'));
    }

    public function update(EditRolePermissionRequest $request, Role $role, UpdateRolePermissionActionInterface $action): RedirectResponse
    {
        $this->authorize('edit role');

        $action->handle($request->validated(), $role);

        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }
}
