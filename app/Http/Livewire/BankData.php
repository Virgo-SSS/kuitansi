<?php

namespace App\Http\Livewire;

use App\Actions\Bank\Interfaces\DeleteBankActionInterface;
use App\Models\Bank;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class BankData extends Component
{
    use ToastTrait, AuthorizesRequests;

    protected $listeners = [
        'bankCreated' => '$refresh',
        'bankUpdated' => '$refresh',
    ];

    public function mount(): void
    {
        $this->authorize('view bank page');
    }

    public function render(): View
    {
        return view('bank.bank-data', [
            'banks' => $this->getBankData(),
        ]);
    }

    private function getBankData(): Collection
    {
        return Bank::all();
    }

    public function deleteBank(Bank $bank, DeleteBankActionInterface $action): void
    {
        $this->authorize('delete bank');

        $action->handle($bank);

        $this->toastSuccess('Bank deleted successfully');
    }

}
