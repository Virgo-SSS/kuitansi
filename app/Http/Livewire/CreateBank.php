<?php

namespace App\Http\Livewire;

use App\Actions\Bank\Interfaces\CreateBankActionInterface;
use App\Models\Bank;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class CreateBank extends ModalComponent
{
    use ToastTrait, AuthorizesRequests;

    public string $bankName = '';

    public function render(): View
    {
        return view('bank.create-bank');
    }

    public function rules(): array
    {
        return [
            'bankName' => 'required|max:255',
        ];
    }

    public function createBank(CreateBankActionInterface $action): void
    {
        $this->authorize('create bank');

        $this->validate();

        $action->handle(['name' => $this->bankName]);

        $this->reset('bankName');

        $this->toastSuccess('Bank created successfully');

        $this->emit('bankCreated');

        $this->closeModal();
    }
}
