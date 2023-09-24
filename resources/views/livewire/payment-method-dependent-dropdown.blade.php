@php use App\Enums\BankPaymentMethod;use App\Enums\PaymentMethod; @endphp
<div>
    <div class="grid grid-cols-3 gap-4 mt-3">
        <div>
            <label class="block text-sm">
                <x-span>
                    Payment Method
                    @error('payment_method')
                        <x-message.error>{{ $message }}</x-message.error>
                    @enderror
                </x-span>

                <x-inputs.select-icon-left wire:model="selectedPaymentMethod" name="payment_method" required>
                    <option selected value="-1">Select Payment Method</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->value }}">{{ $method->name }}</option>
                    @endforeach
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                        </svg>
                    </x-slot>
                </x-inputs.select-icon-left>
            </label>
        </div>

        @if(!is_null($selectedPaymentMethod) && $selectedPaymentMethod == PaymentMethod::BANK->value)
            <div>
                <label class="block text-sm">
                    <x-span>
                        Bank
                        @error('bank_id')
                            <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                    </x-span>

                    <x-inputs.select-icon-left name="bank_id" required>
                        <option selected value="-1">Select Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" @selected($selectedBankId ==  $bank->id)>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                            </svg>
                        </x-slot>
                    </x-inputs.select-icon-left>
                </label>
            </div>

            <div>
                <label class="block text-sm">
                    <x-span>
                        Bank Method
                        @error('bank_method')
                            <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                    </x-span>

                    <x-inputs.select-icon-left wire:model="selectedBankMethod" name="bank_method" required>
                        <option selected value="-1">Select Bank Method</option>
                        @foreach($bankPaymentMethods as $bankPaymentMethod)
                            <option value="{{ $bankPaymentMethod->value }}" @selected($selectedBankMethod == $bankPaymentMethod->value)>
                                {{ $bankPaymentMethod->name }}
                            </option>
                        @endforeach
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                            </svg>
                        </x-slot>
                    </x-inputs.select-icon-left>
                </label>
            </div>
        @endif
    </div>

    @if(!is_null($selectedBankMethod) && $selectedBankMethod != BankPaymentMethod::TRANSFER->value && $selectedBankMethod != -1 && $selectedPaymentMethod != PaymentMethod::TUNAI->value)
        <label class="block text-sm mt-3">
            <x-span id="cek_or_giro_label">
                Cek/Giro Number
                @error('cek_or_giro_number')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </x-span>

            <x-inputs.icon-left type="number" name="cek_or_giro_number" value="{{ old('cek_or_giro_number') ?? $cekGiroNumber }}" required placeholder="Giro Number">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </x-slot>
            </x-inputs.icon-left>
        </label>
    @endif
</div>
