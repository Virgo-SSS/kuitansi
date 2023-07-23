<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardData extends Component
{
   use WithPagination;


    public function render(): View
    {
        return view('dashboard.dashboard-data', [
            'receipts' => \App\Models\Receipt::with(['created_by_user'])->paginate(15),
        ]);
    }
}
