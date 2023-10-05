<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class DeleteButtonConfirmation extends Component
{
    public string $modalComponentName = '';

    // The attributes must be a JSON string
    public string $attributes = '{}';

    public function render(): View
    {
        return view('livewire.delete-button-confirmation');
    }
}
