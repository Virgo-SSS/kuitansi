<?php

namespace App\Http\Livewire\receipt;

use App\Actions\CreateReceipt;
use App\Trait\ToastTrait;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class CreateReceiptForm extends Component
{
    use ToastTrait;

    public array $state = [
        'received_from' => null,
        'amount' => null,
        'in_payment_for' => null,
        'payment_method' => null,
    ];

    public array $rules = [
        'state.received_from' => 'required|string|max:255',
        'state.amount' => 'required|numeric|min:0',
        'state.in_payment_for' => 'required|string|max:255',
        'state.payment_method' => 'required|string|in:cash,transfer,giro',
    ];

    public array $messages = [
        'state.received_from.required' => 'The received from field is required.',
        'state.received_from.string' => 'The received from field must be a string.',
        'state.received_from.max' => 'The received from field must not exceed 255 characters.',
        'state.amount.required' => 'The amount field is required.',
        'state.amount.numeric' => 'The amount field must be a number.',
        'state.amount.min' => 'The amount field must be at least 0.',
        'state.in_payment_for.required' => 'The in payment for field is required.',
        'state.in_payment_for.string' => 'The in payment for field must be a string.',
        'state.in_payment_for.max' => 'The in payment for field must not exceed 255 characters.',
        'state.payment_method.required' => 'The payment method field is required.',
        'state.payment_method.string' => 'The payment method field must be a string.',
        'state.payment_method.in' => 'The selected payment method is invalid.',
    ];

    public function store(CreateReceipt $action): void
    {
        $this->prepareStateForValidation();
        $this->validate();

        $action->create($this->state);

        $this->resetState();

        $this->toastSuccess('Receipt created successfully!');
    }

    protected function resetState(): void
    {
        $this->state = [
            'received_from' => null,
            'amount' => null,
            'in_payment_for' => null,
            'payment_method' => null,
        ];
    }

    public function render(): View
    {
        return view('receipt.create-receipt-form');
    }

    public function prepareStateForValidation(): void
    {
        $this->state['amount'] = Str::replace([',', '.'], '', $this->state['amount']);
    }
}
