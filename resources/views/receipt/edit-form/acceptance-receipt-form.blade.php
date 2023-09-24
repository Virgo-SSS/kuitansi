@php use App\Enums\AcceptancePaymentForCategory;use App\Enums\ReceiptCategory; @endphp
<form action="{{ route('receipt.update.acceptance', $receipt->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <x-span>Acceptance Receipt</x-span>
        <label class="block text-sm mt-3">
            <x-span>
                Name
                @error('customer_name')
                <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </x-span>

            <x-inputs.icon-left type="text" name="customer_name" required value="{{ $receipt->customer_name }}"
                                placeholder="Input Client Name">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </x-slot>
            </x-inputs.icon-left>
        </label>

        <div class="grid grid-cols-2 gap-4 mt-3">
            <div>
                <label class="block text-sm">
                    <x-span>
                        Amount
                        @error('amount')
                        <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                    </x-span>

                    <x-inputs.icon-left type="text" name="amount" value="{{ $receipt->amount }}" data-type="currency"
                                        required placeholder="Rp. 1.000.000">
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                            </svg>
                        </x-slot>
                    </x-inputs.icon-left>
                </label>
            </div>

            <div>
                <label class="block text-sm">
                    <x-span>
                        Category
                        @error('category')
                        <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                    </x-span>
                    <x-inputs.select-icon-left name="category" onclick="selectedCategory(this)" required>
                        <option disabled selected value="">Select Receipt Category</option>
                        @foreach($receiptCategories as $receiptCategory)
                            <option
                                value="{{ $receiptCategory->value }}" @selected($receipt->category_id == $receiptCategory->value)>{{ str_replace('_', ' ', $receiptCategory->name) }}</option>
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
        </div>

        <div class="grid grid-cols-2 gap-4 mt-3">
            <div>
                <label class="block text-sm">
                    <x-span id="payment_for_label">
                        Payment for
                        @error('payment_for_consumer')
                        <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                        @error('payment_for_non_consumer')
                        <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                    </x-span>

                    <div id="payment_for_consumer"
                         class="{{ $receipt->category_id != ReceiptCategory::CONSUMER->value  ? 'hidden' : '' }}">
                        <x-inputs.select-icon-left name="payment_for_consumer" onchange="selectedPaymentFor(this)">
                            <option disabled selected value="">Select Payment For</option>
                            @foreach($acceptancePaymentForCategories as $category)
                                <option
                                    value="{{ $category->value }}" @selected($receipt->acceptanceReceiptPayment->payment_for == $category->value)>{{ str_replace('_', ' ',$category->name) }}</option>
                            @endforeach
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                                </svg>
                            </x-slot>
                        </x-inputs.select-icon-left>
                    </div>

                    <div id="payment_for_non_consumer"
                         class="{{ $receipt->category_id != ReceiptCategory::NON_CONSUMER->value  ? 'hidden' : '' }}">
                        <x-inputs.icon-left type="text" name="payment_for_non_consumer"
                                            value="{{ $receipt->category_id == ReceiptCategory::NON_CONSUMER->value ? $receipt->acceptanceReceiptPayment->payment_for : '' }}"
                                            placeholder="Input payment for">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                            </x-slot>
                        </x-inputs.icon-left>
                    </div>
                </label>
            </div>

            <div id="deskripsi"
                 class="{{ $receipt->category_id == ReceiptCategory::CONSUMER->value && $receipt->acceptanceReceiptPayment->payment_for == AcceptancePaymentForCategory::BOOKING_FEE->value
                            || $receipt->category_id == ReceiptCategory::NON_CONSUMER->value ? 'hidden' : '' }}">
                <label class="block text-sm">
                    <x-span>
                        Deskripsi (Angsuran/Lain nya)
                        @error('payment_for_consumer_description')
                            <x-message.error>{{ $message }}</x-message.error>
                        @enderror
                    </x-span>

                    <x-inputs.icon-left type="text" name="payment_for_consumer_description"
                                        value="{{ $receipt->acceptanceReceiptPayment->payment_for_description }}" placeholder="deskripsi">
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                            </svg>
                        </x-slot>
                    </x-inputs.icon-left>
                </label>
            </div>
        </div>

        @livewire('payment-method-dependent-dropdown', [
            'selectedPaymentMethod' => $receipt->acceptanceReceiptPayment->payment_method,
            'selectedBankMethod' => $receipt->acceptanceReceiptPayment->bank_method,
            'selectedBankId' => $receipt->acceptanceReceiptPayment->bank_id,
            'cekGiroNumber' => $receipt->acceptanceReceiptPayment->cek_or_giro_number,
        ])

        @livewire('project-dependent-dropdown', ['selectedProject' => $receipt->project])

        <div class="mt-3 flex justify-end">
            <x-buttons.submit>
                Save
            </x-buttons.submit>
        </div>
    </div>
</form>
