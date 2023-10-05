<?php

namespace App\Http\Livewire;

use App\Actions\Bank\Interfaces\EditBankActionInterface;
use App\Models\Bank;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class EditBank extends ModalComponent
{
    use ToastTrait,AuthorizesRequests;

    public Bank $bank;

    public function mount(int $bankId): void
    {
        $this->bank = Bank::find($bankId);
    }

    public function render(): View
    {
        return view('bank.edit-bank');
    }

    public function rules(): array
    {
        return [
            'bank.name' => 'required|string|max:255',
        ];
    }

    public function editBank(EditBankActionInterface $action): void
    {
        $this->authorize('edit bank');

        $this->validate();

        $action->handle($this->bank, $this->bank->toArray());

        $this->toastSuccess('Bank Updated successfully');

        $this->emit('bankUpdated');

        $this->closeModal();
    }
}
