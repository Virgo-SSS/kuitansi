<?php

namespace App\Http\Livewire;

use App\Enums\BankPaymentMethod;
use App\Enums\PaymentMethod;
use App\Models\Bank;
use Illuminate\View\View;
use Livewire\Component;

class PaymentMethodDependentDropdown extends Component
{
    public ?int $selectedPaymentMethod = null;
    public ?int $selectedBankMethod = null;
    public ?int $selectedBankId = null;
    public ?int $cekGiroNumber = null;

    public function mount(): void
    {
        $this->checkOldRequest();
    }

    public function render(): View
    {
        return view('livewire.payment-method-dependent-dropdown',[
            'paymentMethods' =>PaymentMethod::cases(),
            'banks' =>  Bank::all(),
            'bankPaymentMethods' => BankPaymentMethod::cases(),
        ]);
    }

    public function updatedSelectedPaymentMethod(int $paymentMethod): void
    {
        if($paymentMethod == -1) {
            $this->selectedPaymentMethod = null;
            $this->selectedBankMethod = null;
        }

        $this->selectedPaymentMethod = $paymentMethod;
    }

    public function updatedSelectedBankMethod(int $bankMethod): void
    {
        if($bankMethod == -1) $this->selectedBankMethod = null;

        $this->selectedBankMethod = $bankMethod;
    }

    private function checkOldRequest(): void
    {
        if (old('payment_method') != null && is_null($this->selectedPaymentMethod)) {
            $this->selectedPaymentMethod = old('payment_method');
        }

        if (old('bank_method') != null && is_null($this->selectedBankMethod)) {
            $this->selectedBankMethod = old('bank_method');
        }

        if (old('bank_id') != null && is_null($this->selectedBankId)) {
            $this->selectedBankId = old('bank_id');
        }
    }
}
