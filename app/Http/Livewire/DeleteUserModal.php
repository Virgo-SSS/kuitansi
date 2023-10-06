<?php

namespace App\Http\Livewire;

use App\Actions\User\Interfaces\DeleteUserActionInterface;
use App\Models\User;
use App\Repository\interfaces\UserRepositoryInterface;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class DeleteUserModal extends ModalComponent
{
    use ToastTrait, AuthorizesRequests;

    public User $user;

    public function mount(int $userId)
    {
        $this->user = app(UserRepositoryInterface::class)->find($userId);
    }

    public function render(): View
    {
        return view('user.delete-user-modal');
    }

    public function deleteUser(DeleteUserActionInterface $action): Redirector
    {
        $this->authorize('delete user');

        $action->handle($this->user);

        $this->toastSuccess('User deleted successfully!');

        $this->user = new User();

        return redirect()->to(route('user.index'));
    }
}
