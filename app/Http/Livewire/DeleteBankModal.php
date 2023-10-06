<?php

namespace App\Http\Livewire;

use App\Actions\Bank\Interfaces\DeleteBankActionInterface;
use App\Models\Bank;
use App\Repository\interfaces\BankRepositoryInterface;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class DeleteBankModal extends ModalComponent
{
    use ToastTrait, AuthorizesRequests;

    public Bank $bank;

    public function mount(int $bankId): void
    {
        $this->bank = app(BankRepositoryInterface::class)->find($bankId);
    }

    public function render(): View
    {
        return view('bank.delete-bank-modal');
    }

    public function deleteBank(DeleteBankActionInterface $action): void
    {
        $this->authorize('delete bank');

        $action->handle($this->bank);

        $this->toastSuccess('Bank deleted successfully');

        $this->bank = new Bank();

        $this->emit('bankDeleted');

        $this->closeModal();
    }
}
