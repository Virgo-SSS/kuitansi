<?php

namespace App\Http\Livewire\receipt;

use App\Models\Receipt;
use App\Trait\ToastTrait;
use Illuminate\View\View;
use Livewire\Component;

class EditReceiptForm extends Component
{
    use ToastTrait;

    public array $state = [
        'received_from' => null,
        'amount' => null,
        'in_payment_for' => null,
        'payment_method' => null,
        'giro_bank' => null,
    ];

    public array $rules = [
        'state.received_from' => 'required|string|max:255',
        'state.amount' => 'required|numeric|min:0',
        'state.in_payment_for' => 'required|string|max:255',
        'state.payment_method' => 'required|string|uppercase|in:CASH,TRANSFER,GIRO',
        'state.giro_bank' => ['nullable', 'string', 'max:255', 'required_if:state.payment_method,GIRO']
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
        'state.payment_method.uppercase' => 'The payment method field must be uppercase.',
        'state.payment_method.in' => 'The selected payment method is invalid.',
        'state.giro_bank.string' => 'The giro bank field must be a string.',
        'state.giro_bank.max' => 'The giro bank field must not exceed 255 characters.',
    ];

    public bool $giroBankDiv = false;

    public function mount(Receipt $receipt): void
    {
        $this->state['received_from']   = $receipt->received_from;
        $this->state['amount']          = $receipt->amount;
        $this->state['in_payment_for']  = $receipt->in_payment_for;
        $this->state['payment_method']  = $receipt->payment_method;
        $this->state['giro_bank']       = $receipt->giro_bank;
    }

    public function render(): View
    {
        return view('receipt.edit-receipt-form');
    }

    public function setGiroBankDiv(bool $status): void
    {
        $this->giroBankDiv = $status;
    }
}
