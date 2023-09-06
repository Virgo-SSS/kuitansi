<?php

namespace App\Http\Livewire;

use App\Models\Receipt;
use App\Trait\ToastTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardData extends Component
{
    use WithPagination, ToastTrait;


    public function render(): View
    {
        return view('dashboard.dashboard-data');
    }

//    public function setModelToDelete(Receipt $receipt): void
//    {
//        $this->receipt = $receipt;
//    }
//
//    public function deleteReceipt(): void
//    {
//        $this->receipt->delete();
//
//        $this->toastSuccess('Receipt deleted successfully');
//    }
}
