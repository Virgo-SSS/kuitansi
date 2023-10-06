<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class BankData extends Component
{
    use ToastTrait, AuthorizesRequests, withPagination;

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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    private function getBankData(): LengthAwarePaginator
    {
        return Bank::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate(20);
    }
}
