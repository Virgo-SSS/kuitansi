<?php

namespace App\Http\Controllers;

use App\Actions\CreateRolePermission;
use App\Actions\UpdateRolePermission;
use App\Http\Requests\CreateRolePermissionRequest;
use App\Http\Requests\EditRolePermissionRequest;
use App\Repository\interfaces\RolePermissionRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(): View
    {
        $this->authorize('view role page');

        $roles = Role::with('permissions')
            ->where('name', '!=', 'admin')
            ->get();

        return view('role-permission.index', compact('roles'));
    }

    public function create(): View
    {
        $this->authorize('create role');

        $permissions = app(RolePermissionRepositoryInterface::class)->getPermissions();
        return view('role-permission.create', compact('permissions'));
    }

    public function store(CreateRolePermissionRequest $request, CreateRolePermission $action): RedirectResponse
    {
        $this->authorize('create role');

        $action->handle($request->validated());

        return redirect()->route('role.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role): View
    {
        $this->authorize('edit role');

        $permissions = app(RolePermissionRepositoryInterface::class)->getPermissions();

        return view('role-permission.edit', compact('role', 'permissions'));
    }

    public function update(EditRolePermissionRequest $request, Role $role, UpdateRolePermission $action): RedirectResponse
    {
        $this->authorize('edit role');

        $action->handle($request->validated(), $role);

        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }
}
