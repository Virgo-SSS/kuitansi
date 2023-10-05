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

    public string $search = '';

    protected $listeners = [
        'bankCreated' => '$refresh',
        'bankUpdated' => '$refresh',
        'bankDeleted' => '$refresh',
    ];

    public function mount(): void
    {
        $this->authorize('view bank page');
    }

    public function render(): View
    {
        sleep(1);

        return view('bank.bank-data', [
            'banks' => $this->getBankData(),
        ]);
    }

    private function getBankData(): Collection
    {
        return Bank::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->get();
    }
}
