<?php

namespace App\Http\Controllers;

use App\Actions\User\DeleteUser;
use App\Actions\User\Interfaces\DeleteUserActionInterface;
use App\Actions\User\Interfaces\UpdateUserActionInterface;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repository\interfaces\RolePermissionRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('view user page');

        $users = User::paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create user');

        $roles = app(RolePermissionRepositoryInterface::class)->getRoles();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, CreatesNewUsers $action): RedirectResponse
    {
        $action->create($request->validated());

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $this->authorize('edit user');

        $roles = app(RolePermissionRepositoryInterface::class)->getRoles();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserActionInterface $action): RedirectResponse
    {
        $action->handle($user, $request->validated());

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, DeleteUserActionInterface $action): RedirectResponse
    {
        $this->authorize('delete user');

        $action->handle($user);

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
